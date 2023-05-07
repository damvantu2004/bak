<?php
session_start();
require './Core/UploadFile.php';
require './Core/Database.php';
require './Helper/Common.php';
require './Application/Models/BaseModel.php';
require './Application/Controllers/BaseController.php';

// get controller name: by default í Homecontroller which direct to the home page
$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'home')) . 'Controller');

// get action to execute method in controller by default is index()
$actionName = $_REQUEST['action'] ?? 'index';

$moduleName =  $_GET['module'] ?? null;

if ($moduleName === "admin") {
    // if anon or normal user
    if (empty($_SESSION['user']) || $_SESSION['user']["role"] != "admin") {
        header('location:index.php');
    }
    $controllerFile = "./Application/Controllers/Admin/${controllerName}.php";
} else {
    $controllerFile = "./Application/Controllers/${controllerName}.php";
}

// if user has chosen 'remember-me' and not logged in (session not create) -> auto login and move to index
$cookie_name = "UserToken";
if (isset($_COOKIE[$cookie_name]) && !isset($_SESSION['user'])) {
    $controllerName = "verifyController";
    $controllerFile = "./Application/Controllers/${controllerName}.php";
    $actionName = "autoLogin";
}


if (file_exists($controllerFile)) {
    require $controllerFile;
} else {
    // echo "<h1>Không tìm thấy ${controllerName}</h1>";
    view("shared.site.404");
    die();
}

$object1 = new $controllerName;

if (method_exists($object1, $actionName)) {
    $object1->$actionName();
} else {
    // echo "<h2>Không tìm thấy method: ${actionName} ở trong ${controllerName}</h2>";
    view("shared.site.404");
}

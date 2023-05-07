<?php

class BaseController
{
    const VIEW_FOLDER_NAME = "Views";

    const MODEL_FOLDER_NAME = "Models";

    // mô tả path : 
    // +path name:  foldername.filename
    //+ lấy từ sau thư mục view

    public function __construct()
    {
        if (!empty($_GET['module'])) {
            // if access admin section
            if ($_GET['module'] == 'admin') {
                // if anon or normal user
                if (empty($_SESSION['user']) || $_SESSION['user']["role"] != "admin") {
                    header('location:index.php');
                }
            }
        }
    }

    protected function view($path, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        //những cái gì được khai báo trước khi require thì sẽ lấy ra đc giá trị ở trong phần view
        //đây là cách truyền dữ liệu từ trong conttoller ra ngoài view
        return require('./Application/' . self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $path) . '.php');
    }

    protected function loadModel($modelPath)
    {
        return require('./Application/' . self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php');
    }
    protected function loadHelper($modelPath)
    {
        return require('Helper' . '/' . $modelPath . '.php');
    }
    protected function redirect($url)
    {
        header("location : ${url}");
    }
}

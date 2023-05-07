 <?php

    function view($path, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        return require('./Application/Views/' . str_replace('.', '/', $path) . '.php');
    }

<?php

class Controller
{
    public function model($model)
    {
        require_once "../bankSystem/models/$model.php";
        return new $model();
    }

    public function view($view, $data = array())
    {
        require_once "../bankSystem/views/$view.php";
    }
}

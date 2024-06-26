<?php

    // Carrega os modelos e as views
    class Controller {

        //Carrega models
        public function model($model){
            //requere o arquivo de modelo
            require_once '../app/models/'.$model.'.php';
            return new $model;
        }

        //Carrega views
        public function view($view, $dados = []){
            $arquivo = ('../app/views/'.$view.'.php');
            if(file_exists($arquivo))
                require_once $arquivo;
            else
                die();
        }

    }
?>
<?php
    // namespace App;
    class Autoload{
        public static function register(){
            spl_autoload_register(function ($class){
                $class = str_replace('\\','/', $class);
                if(file_exists(__DIR__."/".$class.".php")){
                    require __DIR__."/".$class.".php";
                }
            });
        }
    }
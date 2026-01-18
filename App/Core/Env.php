<?php
    namespace App\Core;
    use RuntimeException;

    class Env{
        public static function load($path):void{
            if(!file_exists($path)){
                throw new RuntimeException("file .env not found!");
            }

            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach($lines as $line){
                if(str_starts_with(trim($line),'#')){
                    continue;
                }
                [$key, $value] = explode('=',$line,2);
                $_ENV[$key] = $value;
            }
        }

        public static function get(string $key, mixed $default = null):mixed{
            return $_ENV[$key] ?? $default;
        }
    }
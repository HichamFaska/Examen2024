<?php
    namespace App\Database;
    use PDO;
    use App\Core\Env;
    use PDOException;

    class Database{
        private PDO $conn;
        private static ?Database $instance = null;

        private function __construct(){
            Env::load(__DIR__."../../../.env");
            try{
                $options = [
                    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ];

                $this->conn = new PDO("mysql:host=" . Env::get('SERVEUR') .";port=" . Env::get('PORT') .";dbname=" . Env::get('DBNAME') .";charset=utf8mb4",
                    Env::get('UTILISATEUR'),
                    Env::get('MOTDEPASSE'),
                    $options
                );

                
            }
            catch(PDOException $e){
                throw new PDOException("erreur de connexion a la base de donnée");
            }
        }

        public static function getInstance():self{
            if(self::$instance === null){
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getConnection():PDO{
            return $this->conn;
        }
    }
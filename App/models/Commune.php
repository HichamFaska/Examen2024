<?php
    namespace App\Models;

    use App\Database\Database;
    use PDO;
    use PDOException;
    use PDOStatement;

    class Commune{
        private PDO $conn;

        public function __construct(){
            try{
                $this->conn = Database::getInstance()->getConnection();
            }
            catch(PDOException $e){
                throw new PDOException($e->getMessage());
            }
        }

        public function getAll():PDOStatement{
            try{
                $stmt = $this->conn->prepare("SELECT * FROM communes");
                $stmt->execute();
                return $stmt;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la récupération de la liste des communes");
            }
        }
    }
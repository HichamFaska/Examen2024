<?php
    namespace App\Models;
    use App\Database\Database;
    use PDO;
    use PDOException;

    class Admin{
        private PDO $conn;

        public function __construct(){
            try{
                $this->conn = Database::getInstance()->getConnection();
            }
            catch(PDOException $e){
                throw new PDOException($e->getMessage());
            }
        }

        public function find(string $cnie, string $password):object{
            try{
                $stmt = $this->conn->prepare("SELECT * FROM admins WHERE cnieAdmin = ? AND password = ?");
                $stmt->execute([$cnie, $password]);
                $admin = $stmt->fetch();

                if (!$admin) { throw new PDOException("Admin not found"); } return $admin;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur d'authentification!!");
            }
        }
    }
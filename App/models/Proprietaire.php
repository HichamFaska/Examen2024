<?php
    namespace App\Models;
    use App\Database\Database;
    use PDO;
    use PDOException;
    use PDOStatement;

    class Proprietaire{
        private PDO $conn;

        public function __construct(){
            try{
                $this->conn = Database::getInstance()->getConnection();
            }
            catch(PDOException $e){
                throw new PDOException($e->getMessage());
            }
        }

        public function create(array $data){
            try{
                $stmt = $this->conn->prepare("INSERT INTO proprietaires (cnieProprietaire, nom, prenom, fonction, nombrePersonneCharge, etatMaison, idCommune) VALUES
                    (:cnie, :nom, :prenom, :fonction, :nbCharge, :etatMaison, :idCommune)");
                $stmt->execute([
                    ':cnie'       => $data['cnie'],
                    ':nom'        => $data['nom'],
                    ':prenom'     => $data['prenom'],
                    ':fonction'   => $data['fonction'],
                    ':nbCharge'   => $data['nbCharge'],
                    ':etatMaison' => (int)$data['etatMaison'],
                    ':idCommune'  => (int)$data['idCommune']
                ]);
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la création d'un propriétaire");
            }
        }

        public function getAll():PDOStatement{
            try{
                $stmt = $this->conn->prepare("SELECT * FROM proprietaires WHERE etatMaison = 2");
                $stmt->execute();
                return $stmt;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la récupération de la liste des communes");
            }
        }

        public function getByCommune(string $commune):PDOStatement{
            try{
                $stmt = $this->conn->prepare("SELECT p.*
                    FROM proprietaires AS p
                    INNER JOIN communes as c
                        ON c.idCommune = p.idCommune
                    WHERE c.intituleCommune = :commune
                    AND p.etatMaison = 2");
                $stmt->execute([':commune' => $commune]);
                return $stmt;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la récupération de la liste des communes");
            }
        }
    }
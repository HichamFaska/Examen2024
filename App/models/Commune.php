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

        public function getBilan(){
            try{
                $stmt = $this->conn->prepare("SELECT c.idCommune, c.intituleCommune, COUNT(DISTINCT p.cnieProprietaire) AS nb, SUM(a.montant) as totalParCommune
                FROM communes as c
                INNER JOIN proprietaires AS p
                    ON c.idCommune = p.idCommune
                INNER JOIN aidelogements AS a
                    ON a.cnieProprietaire = p.cnieProprietaire
                GROUP BY c.idCommune");

                $stmt->execute();
                return $stmt;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la récupération des information");
            }
        }

        public function getbonAide(int $idCommune):PDOStatement{
            try{
                $stmt = $this->conn->prepare("SELECT p.cnieProprietaire, p.nom, p.prenom, p.adresse, p.tel, a.date, a.montant, a.percue
                    FROM proprietaires p 
                    INNER JOIN communes c ON p.idCommune = c.idCommune 
                    INNER JOIN aideLogements a ON p.cnieProprietaire = a.cnieProprietaire
                    WHERE c.idCommune = ?
                ");
                $stmt->execute([$idCommune]);
                return $stmt;
            }
            catch(PDOException $e){
                throw new PDOException("Erreur lors de la récupération des information");
            }
        }
    }
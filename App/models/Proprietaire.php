<?php
    namespace App\Models;
    use App\Database\Database;
    use PDO;
    use PDOException;

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
    }
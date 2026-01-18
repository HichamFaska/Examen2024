<?php
    session_start();
    require "../Autoload.php";
    use App\Models\Proprietaire;

    Autoload::register();

    if($_SERVER['REQUEST_METHOD'] === "POST"){

        $cnie = $_POST['cnie'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $fonction = $_POST['fonction'];
        $nbCharge = $_POST['nb_charge'];
        $etatMaison = $_POST['etat_maison'];
        $idCommune = $_POST['id_commune'];

        $data = compact('cnie','nom','prenom','fonction','nbCharge','etatMaison','idCommune');
        try{
            (new Proprietaire)->create($data);
            $_SESSION['success'] = "Ajout avec succés";
        }
        catch(Exception $e){
            $_SESSIN['erreur'] = $e->getMessage();
        }

        header('location: formInfo.php');
        exit;
    }
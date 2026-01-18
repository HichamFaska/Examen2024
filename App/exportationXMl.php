<?php
    session_start();
    require_once "../Autoload.php";
    Autoload::register();
    use App\Models\Commune;

    $idCommune = isset($_GET['idCommune'])? intval($_GET['idCommune']) : 0;
    if($idCommune > 0){
        try {
            $stmt = (new Commune)->getbonAide($idCommune);
            
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;
            $proprietaires = $dom->createElement("proprietaires");
            $dom->appendChild($proprietaires);

            while ($tab = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $proprietaire = $dom->createElement("proprietaire");
                $proprietaire->setAttribute("cnie", $tab['cnieProprietaire']);
                $identite = $dom->createElement("identite");
                $aide = $dom->createElement("aide");
                $identite->appendChild($dom->createElement("nom", htmlspecialchars($tab['nom'])));
                $identite->appendChild($dom->createElement("prenom", htmlspecialchars($tab['prenom'])));
                $identite->appendChild($dom->createElement("adresse", htmlspecialchars($tab['adresse'])));
                $identite->appendChild($dom->createElement("tel", htmlspecialchars($tab['tel'])));
                $aide->appendChild($dom->createElement("dateAide", $tab['date']));
                $aide->appendChild($dom->createElement("montantAide", $tab['montant']));
                $aide->appendChild($dom->createElement("percue", $tab['percue']));
                $proprietaire->appendChild($identite);
                $proprietaire->appendChild($aide);
                $proprietaires->appendChild($proprietaire);
            }

            header("Content-Type: application/xml");
            header("Content-Disposition: attachment; proprietaires.xml");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");

            echo $dom->saveXML();

        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
    else{
        $_SESSION['erreur'] = "Commune introuvable";
        header('Location: aideCommune.php');
        exit;
    }


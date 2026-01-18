<?php
require_once "../Autoload.php";
Autoload::register();
use App\Database\Database;
try {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT p.cnieProprietaire, p.nom, p.prenom, p.adresse, p.tel, 
                     a.date, a.montant, a.percue
              FROM proprietaires p 
              INNER JOIN communes c ON p.idCommune = c.idCommune 
              INNER JOIN aideLogements a ON p.cnieProprietaire = a.cnieProprietaire
              WHERE c.idCommune = 2";
    $stmt = $db->query($query);
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

    $dom->save("proprietaires.xml");
    echo "Fichier XML généré avec succès.";

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<?php
    session_start();
    require "../Autoload.php";
    Autoload::register();
    use App\Models\Commune;
    use App\Models\Proprietaire;

    if (!isset($_COOKIE['cnieAdmin']) || !isset($_COOKIE['nomAdmin'])) {
        header("Location: authAdmin.php");
        exit;
    }

    try{
        $stmtCommune = (new Commune())->getAll();
    }
    catch(Exception $e){
        $_SESSION['erreur'] = $e->getMessage();
    }

    $commune = $_GET['commune'] ?? "";

    if(!empty($commune)){
        try{
            $stmt = (new Proprietaire)->getByCommune($commune);
        }
        catch(Exception $e){
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
    else{
        try{
            $stmt = (new Proprietaire)->getAll();
            //  var_dump($stmt->fetchAll());
        }
        catch(Exception $e){
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class = "container  mb-4">
        <div class = "card card-body shadow-sm p-3">
            <h3 class = "text-center text-primary fw-bold">LISTE DES PROPRIETAIRE DONT LEUR MAISON SONR TOTALEMENT DETRUITE</h3>
            <form action="" method = "GET">
                    <div class="mb-4">
                        <label class="form-label">Commune :</label>
                        <select name="commune" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            <?php while($tabCommune = $stmtCommune->fetch()):?>
                                <option value="<?= $tabCommune->intituleCommune; ?>"><?= $tabCommune->intituleCommune; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button class = "btn btn-sm btn-primary">valider</button>
            </form>
            <p class = "text-center text-ligth"><?= !empty($commune) ? "la commune de : $commune" : "tous les Communes"; ?></p>
            <div class = "table-responsive">
                <table class = "table table-hover table-sm align-middle">
                    <thead>
                        <tr>
                            <th>CNIE</th>
                            <th>nom</th>
                            <th>Prénom</th>
                            <th>Fonction</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $empty = true;?>
                        <?php while($proprietaires = $stmt->fetch()): ?>
                            <?php $empty = false;?>
                            <tr>
                                <td><?= $proprietaires->cnieProprietaire ?? '-' ?></td>
                                <td><?= $proprietaires->nom ?? '-' ?></td>
                                <td><?= $proprietaires->prenom ?? '-' ?></td>
                                <td><?= $proprietaires->fonction ?? '-' ?></td>
                                <td><?= $proprietaires->tel ?? '-' ?></td>
                                <td><?= $proprietaires->adresse ?? '-' ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if($empty): ?>
                            <tr  class = "text-center">
                                <td colspan = "100%">liste Vide</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
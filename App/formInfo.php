<?php
    session_start();
    require "../Autoload.php";
    Autoload::register();
    use App\Models\Commune;

    if (!isset($_COOKIE['cnieAdmin']) || !isset($_COOKIE['nomAdmin'])) {
        header("Location: authAdmin.php");
        exit;
    }

    try{
        $stmt = (new Commune())->getAll();
    }
    catch(Exception $e){
        $_SESSION['erreur'] = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de propriétaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class = "container mt-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
            </div>
        <?php endif; ?>

        <h3 class = "text-center fw-bold text-primary mb-4">AJOUT de PROPRIETAIRES DE MAISON SINSTREES</h3>
        <div class = "card card-body">
            <form action = "ajoutInfo.php" method = "POST">
                <div class="md-4">
                    <label for="CNIE " class="form-label">CNIE</label>
                    <input type="text" name = "cnie" class="form-control" id="CNIE" value="" required />
                </div>
                <div class="md-4">
                    <label for="Nom" class="form-label">Nom</label>
                    <input type="text" name = "nom" class="form-control" id="Nom" value="" required />
                </div>
                <div class="md-4">
                    <label for="Prénom" class="form-label">Prénom</label>
                    <input type="text" name = "prenom" class="form-control" id="Prénom" value="" required />
                </div>

                <div class="md-4">
                    <label for="Fonction" class="form-label">Fonction</label>
                    <input type="text" name = "fonction" class="form-control" id="Fonction" value="" required />
                </div>
                <div class="md-4">
                    <label for="nb" class="form-label">Nombre de personnes à charge</label>
                    <input type="text" name = "nb_charge" class="form-control" id="nb" value="" required />
                </div>

                <div class="mb-3">
                    <label class="form-label">État de la maison :</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="etat_maison" value="2" required>
                        <label class="form-check-label">Totalement détruite</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="etat_maison" value="1">
                        <label class="form-check-label">Partiellement détruite</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Commune :</label>
                    <select name="id_commune" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        <?php while($commune = $stmt->fetch()):?>
                            <option value="<?= $commune->idCommune ?>"><?= $commune->intituleCommune; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
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
        $stmtBilan = (new Commune())->getBilan();
        // var_dump($stmt->fetchAll());
    }
    catch(PDOException $e){
        $_SESSION['erreur'] = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class = "container mt-4">
        <div class = "card card-body shadow-sm p-3">
            <h3 class = "text-center text-primary fw-bold mb-3">BILAN DES AIDES</h3>
            <div class = "table-responsive">
                <table class = "table table-hover table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Commune</th>
                            <th>Nombre de propriétaire bénéficiaire</th>
                            <th>Montant Global (dh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $empty = true; $total = 0.0?>
                        <?php while($ligne = $stmtBilan->fetch()): ?>
                            <?php $empty = false; $total += $ligne->totalParCommune?>
                            <tr>
                                <td><?= $ligne->intituleCommune ?? '-' ?></td>
                                <td><?= $ligne->nb ?? '-' ?></td>
                                <td><?= $ligne->totalParCommune ?? '-' ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if($empty): ?>
                            <tr  class = "text-center">
                                <td colspan = "100%">liste Vide</td>
                            </tr>
                        <?php endif; ?>
                        <tr class = "fw-bold">
                            <td colspan = "2" class = "text-primary" >Montant total des aides</td>
                            <td class = "text-primary"><?= $total; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
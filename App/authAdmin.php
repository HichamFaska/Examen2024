<?php
    session_start();
    require_once "../Autoload.php";
    Autoload::register();

    use App\Models\Admin;

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $cnie = $_POST['cnie'];
        $password = $_POST['password'];

        try{
            $admin = (new Admin)->find($cnie, $password);
            if($admin !== null){
                $_SESSION['cnieAdmin'] = $admin->cnieAdmin;
                $_SESSION['nomAdmin']  = $admin->nomAdmin;

                setcookie('cnieAdmin', $admin->cnieAdmin, time()+604800, '/');
                setcookie('nomAdmin', $admin->nomAdmin, time()+604800, '/');

                $_SESSION['success'] = "bienvenue M.$admin->nomAdmin";
                header('Location: formInfo.php');
                exit;
            }
            else{
                $_SESSION['erreur'] = "CNIE ou mot de passe incorrect";
            }
        }
        catch(PDOException $e){
            $_SESSION['erreur'] = "CNIE ou mot de passe incorrect";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Authentification</title>
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
        <h3 class = "text-center fw-bold text-primary mb-4">VEUILLEZ VOUS AUTHENTIFIEZ</h3>
        <div class = "card card-sm p-4">
            <form action="" method="POST">
                <div class="md-4">
                    <label for="CNIE " class="form-label">CNIE</label>
                    <input type="text" name = "cnie" class="form-control" id="CNIE" value="" required />
                </div>
                <div class="md-4">
                    <label for="password " class="form-label">Mot de passe</label>
                    <input type="text" name = "password" class="form-control" id="password" value="" required />
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success">valider</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
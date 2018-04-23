<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<title>Biblioteca UNLP - Usuario Creado</title>
<link href="css/bootstrap.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body style="padding-top: 70px;">
    <div class="container-fluid">
        <div class="row">
            <?php
                include "defaultnavbar.php";
            ?>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="alert alert-success">
                    <strong>Usuario creado exitosamente!</strong> Para iniciar sesion ir a <a href="/login.php" class="alert-link">este</a> link.
                </div>
            </div>
        </div>
    </div>
</body>
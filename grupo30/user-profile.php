<?php
session_start();
require_once "user.class.php";
if (User::isLogged()) {
    try
    {
        $user = User::login($_SESSION['email'], $_SESSION['password'], $pdo);
    } catch (Exception $e) {
        session_destroy();
        $url = 'index.php?cred=false';
        header("Location: $url");
    }
    ?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP - Perfil</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/user-profile.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>

    <?php
require_once "pdo-connect.php";
    require_once 'paginator.class.php';

    $pdoconn = $pdo;

    $links = isset($_GET['links']) ? $_GET['links'] : 10;
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 0;
    $order = isset($_GET['order']) ? $_GET['order'] : 0;

    $query = "SELECT l.id ,l.portada, l.titulo, l.autores_id, a.apellido, a.nombre, o.ultimo_estado, o.fecha_ultima_modificacion FROM usuarios u INNER JOIN operaciones o ON u.id=o.lector_id INNER JOIN libros l ON o.libros_id=l.id INNER JOIN autores a ON l.autores_id=a.id WHERE u.id=:userid";

    $Paginator = new Paginator($pdoconn, $query, $sort, $order);

    $results = $Paginator->getReaderHistory($limit, $page, $user->id);

    ?>

</head>

<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
        <?php include "loggednavbar.php";?>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
            <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>
        </div>
        <hr/>

        <div class="row offset-md-1">
            <p class='h1'> Mi Perfil </p>
        </div>

        <div class="row">
            <div class="col-md-4 offset-md-1">

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th colspan="2">Datos personales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>Nombre:</td>
                        <td><?=$user->nombre?></td>
                        </tr>
                        <tr>
                        <td>Apellido:</td>
                        <td><?=$user->apellido?></td>
                        </tr>
                        <tr>
                        <td>Email:</td>
                        <td><?=$user->email?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 offset-md-3">
                    <?php
                        $image_data = $user->foto;
                        $encoded_image = base64_encode($image_data);
                    ?>
                    <img  src="data:image/jpg;base64,<?=$encoded_image?>" width='200' height='200' />
            </div>

      
        </div>
        <?php
            if ($user->isReader()) {
                    include "lector.php";
            }
        ?>

</body>

</html>

<?php
}
?>
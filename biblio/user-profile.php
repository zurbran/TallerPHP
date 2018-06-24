<?php
    session_start();
    if((isset($_SESSION['email']))&&isset($_SESSION['password']))
    {
?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP - Perfil</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <?php
    require_once "pdo-connect.php";
    require_once 'paginator.class.php';

    $pdoconn = $pdo;

    $links= isset( $_GET['links'] ) ? $_GET['links'] : 10;
    $limit= isset( $_GET['limit'] ) ? $_GET['limit'] : 5;
    $page=  isset( $_GET['page'] )  ? $_GET['page']  : 1;
    $sort=  isset( $_GET['sort'] )  ? $_GET['sort']  : 0;
    $order= isset( $_GET['order'] ) ? $_GET['order'] : 0;

    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    $stmt = $pdoconn->prepare('SELECT id, nombre, apellido, foto, rol FROM usuarios WHERE email = :email AND clave = :password');
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() == 0)
    {
        throw new Exception("Credenciales invalidas.");
    }
    else
    {
        $row = $stmt->fetch();
        $userData['id'] = $row['id'];
        $userData['email'] = $email;
        $userData['nombre'] = $row['nombre'];
        $userData['apellido'] = $row['apellido'];
        $userData['foto'] = $row['foto'];
        $userData['rol'] = $row['rol'];
    }

    $query      = "SELECT l.id ,l.portada, l.titulo, l.autores_id, a.apellido, a.nombre, o.ultimo_estado, o.fecha_ultima_modificacion FROM usuarios u INNER JOIN operaciones o ON u.id=o.lector_id INNER JOIN libros l ON o.libros_id=l.id INNER JOIN autores a ON l.autores_id=a.id WHERE u.id=:userid";

    $Paginator  = new Paginator( $pdoconn, $query, $sort, $order);

    $results    = $Paginator->getReaderHistory($limit, $page, $userData['id']);

    ?>
    
</head>

<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
        <?php include "loggednavbar.php"; ?>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
            <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>
        </div>
        <hr/>

        <div class="row">
            <div class="col-md-8">
                <p class='h1'> Mi Perfil </p>
                <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <p> Nombre: </p>
                    </div>
                    <div class="row">
                        <p> Apellido: </p>
                    </div>
                    <div class="row">
                        <p> Email: </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <p> <?= $userData['nombre']?> </p>
                    </div>
                    <div class="row">
                        <p> <?= $userData['apellido']?> </p>
                    </div>
                    <div class="row">
                    <p> <?= $userData['email']?> </p>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                    <?php
                        $image_data = $userData['foto'];
                        $encoded_image = base64_encode($image_data);
                    ?>
                    <img  src="data:image/jpg;base64,<?=$encoded_image?>" width='200' height='200' />
            </div>
        </div>
        <?php
            

            if($userData['rol'] == 'LECTOR')
            {
                include "lector.php";
            }
        ?>    

</body>

</html>

<?php
    }
    ?>
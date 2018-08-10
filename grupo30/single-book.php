<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->

    <link href="css/single-book.css" rel="stylesheet">
    <link href="css/media.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
    <script src="js/single-book.js"></script>

        <?php
        require_once "pdo-connect.php";
        require_once "user.class.php";

        $isLogged = false;
        $stmt= $pdo->prepare('SELECT l.baja, l.portada, l.titulo, a.nombre, a.apellido, l.cantidad, l.descripcion, l.id FROM libros l INNER JOIN autores a ON (l.autores_id = a.id) WHERE l.id = :book');
        $stmt->execute([':book' => $_GET['libro_id']]);

        $result= $stmt->fetchAll();

        $stmt= null;
        ?>
</head>
<body>

    <div class="container-fluid fill-height">
        <div class="row">
            <?php
            if(User::isLogged())
            {
                try
                {
                    $user = User::login($_SESSION['email'],$_SESSION['password'],$pdo);
                }
                catch(Exception $e)
                {
                    session_destroy();
                    $url = 'single-book.php?cred=false';
                    header( "Location: $url" );
                }
                include "loggednavbar.php";
            }
            else
            {
                include "defaultnavbar.php";
            }
            ?>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
            <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>
        </div>

        <hr/>
        <div class=row>
            <div class="col-md-6">
                <div class=row>
                    <p class='h1 titulo-libro'><?=$result[0]['titulo']?></p>
                </div>
                <div class=row>
                    <p class='texto-ficha'> Autor: <?=$result[0]['nombre'] . " " . $result[0]['apellido']?></p>
                </div>
                <div class=row>
                    <p class='texto-ficha'> Ejemplares: <?=$result[0]['cantidad']?></p>   
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <?php $enconded_image = base64_encode($result[0]['portada']); ?>
                <img src="data:image/jpg;base64,<?=$enconded_image?>" width='200'/>;
            </div>
        </div>
        <div class=row>
            <div class="col-md-12">
                <div class=row>
                    <p class="p texto-ficha">Descripcion: </p>
                </div>
            </div>
        </div>
        <div class=row>
            <p class='sinopsis'>  <?=$result[0]['descripcion']?> </p>
        </div>
<?php if($user->isLibrarian()){
        if($result[0]['baja']==0){ 
?>
        <div class="row col-md-2">
            <btn class="btn btn-primary btn-block" onclick="takedown(<?=$_GET['libro_id']?>)">Baja</btn>
        </div>
<?php   }
    } 
?>
    </div>
</body>

</html>
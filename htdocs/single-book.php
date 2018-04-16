<!DOCTYPE html>
<html lang="es">

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
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

        <?php
        include "pdo-connect.php";

        $stmt= $pdo->prepare('SELECT l.portada, l.titulo, a.nombre, a.apellido, l.cantidad, l.descripcion, l.id FROM libros l INNER JOIN autores a ON (l.autores_id = a.id) WHERE l.id = :book');
        $stmt->execute([':book' => $_GET['libro_id']]);

        $result= $stmt->fetchAll();

        $stmt= null;
        ?>
</head>
<body>

    <div class="container-fluid fill-height">
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

        <hr/>
        <div class=row>
            <div class="col-md-6">
                <div class=row>
                    <?php echo "<p class='h1 titulo-libro'>" . $result[0]['titulo'] . "</p>"?>
                </div>
                <div class=row>
                    <?php echo "<p class='texto-ficha'> Autor: " . $result[0]['nombre'] . " " . $result[0]['apellido'] . "</p>"?>
                </div>
                <div class=row>
                    <?php echo "<p class='texto-ficha'> Ejemplares: " . $result[0]['cantidad'] . "</p>"?>   
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
            <?php
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $result[0]['portada'] ).'" width="200";/>';
            ?>
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
            <?php echo "<p class='sinopsis'>" . $result[0]['descripcion'] . "</p>" ?>
        </div>
    </div>
</body>

</html>
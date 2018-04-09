<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

        <?php
        include "connection.php";
        
        $conn       = $connect;
        //if (isset( $_GET('book'))){
        //    echo "No se pudo conectar la Base de Datos";
        //}
        $book = ( isset( $_GET['libro_id'] ) ) ? $_GET['libro_id'] : 1;
        $query = "SELECT l.portada, l.titulo, a.nombre, a.apellido, l.cantidad, l.descripcion, l.id FROM libros l INNER JOIN autores a ON (l.autores_id = a.id) WHERE l.id = ". $libro_id .";";
        ?>
</head>
<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
            <?php
                include "defaultnavbar.php";
            ?>
        </div>

        <div class="row">
            <div class="col-md-6">
            <img src="img/logo-transparente.png" width='200' alt="logounlp">
            </div>
        </div>
    </div>

    <div class="container-fluid fill-height">
        <div class=row>
            <div class="col-md-6">
            <?php
                $sth = $conn->query($query);
                $result=mysqli_fetch_array($sth);
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';
            ?>
            </div>
        </div>
    </div>

    <hr/>

        <div class="row">
            <div class="col-md-1">
            </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</body>

</html>
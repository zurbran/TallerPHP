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
        include "connection.php";
        require_once 'paginator.class.php';

        $conn = $connect;

        $author = ( isset( $_GET['author_id'] ) ) ? $_GET['author_id'] : 1;
        $query_author = "SELECT l.id, l.portada, l.titulo, a.nombre, a.apellido, l.cantidad FROM libros l INNER JOIN autores a ON (l.autores_id = a.id) WHERE l.autores_id =" . $author . ";" ;

        //$Paginator  = new Paginator( $conn, $query_author );

        $sth = $conn->query($query_author);
        $results=mysqli_fetch_array($sth);

        //$Paginator->getData( $_GET['limit'] , $_GET['page']);
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
            <div class="col-xs-12 col-sm-6 col-md-6">
            <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>
        </div>

        <hr/>

        <div class="row">
            <?php echo "<p class='h1 titulo-libro'> Libros de " . $results['nombre'] . " " . $results['apellido'] . "</p>"?>
        </div>

        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-xs-16 col-sm-10 col-md-10" style="height: 600px; overflow: auto;">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Portada</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Ejemplares</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                                for( $i = 0; $i < count( $results->data ); $i++ ) :
                                    $image_data = $results->data[$i]["portada"];
                                    $encoded_image = base64_encode($image_data);
                                    // $Hinh = "<img  src='data:image/" . $results->data[$i]['tipoimagen'] . ";base64,{$encoded_image}' width='200' height='200' />";
                                    $Hinh = "<a href='/single-book.php?libro_id=" . $results->data[$i]["id"] . "'><img  src='data:image/jpg;base64,{$encoded_image}' width='200' height='200' /> </a>";
                        ?>
                            <tr>
                            <th scope="row"><?php echo $Hinh ?></th>
                            <?php echo '<td><a href="/single-book.php?libro_id='.  $results->data[$i]["id"]  .'"> ' . $results->data[$i]["titulo"] .' </a></td> ';?> 
                            <td><a href="#"><?php echo $results->data[$i]["nombre"] . " " . $results->data[$i]["apellido"]; ?></a></td>
                            <td><?php echo $results->data[$i]["cantidad"] ?></td>
                            </tr>
                        <?php
                            endfor;
                        ?>
                        </tbody>


                    </table>
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
                   <?php
            //        echo $Paginator->createLinks( $links, 'pagination','indexpages' );
                   ?>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</body>

</html>
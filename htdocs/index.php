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
        require_once 'paginator.class.php';

        $conn       = $connect;

        $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 10;
        $query      = "SELECT l.portada, l.titulo, a.nombre, a.apellido, l.cantidad FROM libros l INNER JOIN autores a ON (l.autores_id = a.id)";

        $Paginator  = new Paginator( $conn, $query );

        $results    = $Paginator->getData( $_GET['limit'] , $_GET['page']);
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
            <img src="img/logo-transparente.png" alt="logounlp">
            </div>

            <div class="col-md-6">
                <form>
                    <fieldset>
                    <legend>Refinar Búsqueda:</legend>
                        <div class="form-group">
                        <label for="titulobusqueda">Título</label>
                        <input type="text" id="titulobusqueda" class="form-control" placeholder="Ingrese el título del libro a buscar">
                        </div>
                        <div class="form-group">
                        <label for="autorbusqueda">Autor</label>
                        <input type="text" id="autorbusqueda" class="form-control" placeholder="Ingrese el autor el cual buscar">
                        </div>
                        <div class="checkbox">
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </fieldset>
                </form>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-10" style="height: 600px; overflow: auto;">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Portada</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Ejemplares</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                                for( $i = 0; $i < count( $results->data ); $i++ ) :
                                    $image_data = $results->data[$i]["portada"];
                                    $encoded_image = base64_encode($image_data);
                                    // $Hinh = "<img  src='data:image/" . $results->data[$i]['tipoimagen'] . ";base64,{$encoded_image}' width='200' height='200' />";
                                    $Hinh = "<img  src='data:image/jpg;base64,{$encoded_image}' width='200' height='200' />";
                        ?>
                            <tr>
                            <th scope="row"><?php echo $Hinh ?></th>
                            <td><a href="#"><?php echo $results->data[$i]["titulo"]; ?></a></td>
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
                    echo $Paginator->createLinks( $links, 'pagination','indexpages' );
                    ?>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</body>

</html>

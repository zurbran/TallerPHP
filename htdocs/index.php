<!DOCTYPE html>
<html lang="es">

<head>


    <title>Cinema Rocha</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

        <?php
        include "connection.php";
        include "defaultnavbar.php";
        require_once 'paginator.class.php';

        $conn       = $connect;

        $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
        $query      = "SELECT p.nombre, p.sinopsis, p.anio, g.genero, p.contenidoimagen, p.tipoimagen FROM peliculas p INNER JOIN generos g ON (p.generos_id = g.id)";

        $Paginator  = new Paginator( $conn, $query );

        $results    = $Paginator->getData( $_GET['limit'] , $_GET['page']);
        ?>
</head>
<body>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
            <img src="img/logo-transparente.png" alt="Smiley face">
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

    <hr>

    <div style="height: 400px; overflow: auto;">
        <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Portada</th>
            <th scope="col">Titulo</th>
            <th scope="col">Autor</th>
            <th scope="col">Ejemplares</th>
            </tr>
        </thead>

    <?php
                    for( $i = 0; $i < count( $results->data ); $i++ ) :
                        $image_data = $results->data[$i]["contenidoimagen"];
                        $encoded_image = base64_encode($image_data);
                        //You dont need to decode it again.

                        $Hinh = "<img  src='data:image/" . $results->data[$i]['tipoimagen'] . ";base64,{$encoded_image}' width='200' height='200' />";

                        //and you echo $Hinh



    ?>

        <tbody>
            <tr>
            <th scope="row"><?php echo $Hinh ?></th>
            <td><a href="#"><?php echo $results->data[$i]["nombre"]; ?></a></td>
            <td><?php echo $results->data[$i]["sinopsis"]; ?></td>
            <td>@mdo</td>
            </tr>
        </tbody>
    </div>
        <?php
            endfor;
            ?>
    </table>
        <div class="row">
                <?php
                echo $Paginator->createLinks( $links, 'pagination pagination-sm' );
                ?>
        </div>

    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP</title>

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

    $links=  ( isset( $_GET['links'] ) ) ? $_GET['links'] : 10;
    $limit=  ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 5;
    $page=  ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;

    $query      = "SELECT l.autores_id, l.id, l.portada, l.titulo, a.nombre, a.apellido, l.cantidad FROM libros l INNER JOIN autores a ON (l.autores_id = a.id)";

    $pdoconn = $pdo;
    $Paginator  = new Paginator( $pdoconn, $query );

    // if(isset($_GET['searchT'])|(isset($_GET['searchA'])))
    // {
        $title = $_GET['searchT'] ?? '';
        $author = $_GET['searchA'] ?? '';

        $results    = $Paginator->getData($limit , $page, $author, $title);
    // }
    // else
    // {
    //     $results    = $Paginator->getData($limit , $page, '', '');
    // }


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

            <div class="col-xs-12 col-sm-6 col-md-6">
                <form action= 'index.php'>
                    <fieldset>
                    <legend>Refinar Búsqueda:</legend>
                        <div class="form-group">
                        <label for="titulobusqueda">Título</label>
                        <input type="search" id="titulobusqueda" class="form-control" placeholder="Ingrese el título del libro a buscar" name="searchT">
                        </div>
                        <div class="form-group">
                        <label for="autorbusqueda">Autor</label>
                        <input type="search" id="autorbusqueda" class="form-control" placeholder="Ingrese el autor el cual buscar" name="searchA">
                        </div>
                        <div class="checkbox">
                        </div>
                        <button type="submit" name ="searchTt" value="Busqueda" class="btn btn-primary">Buscar</button>
                    </fieldset>
                </form>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-xs-16 col-sm-10 col-md-10" style="height: 600px; overflow: auto;">
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
                                    $Hinh = "<a href='/single-book.php?libro_id=" . $results->data[$i]["id"] . "'><img  src='data:image/jpg;base64,{$encoded_image}' width='200' height='200' /> </a>";
                        ?>
                            <tr>
                            <th scope="row"><?php echo $Hinh ?></th>
                            <?php echo '<td><a href="/single-book.php?libro_id='.  $results->data[$i]["id"]  .'"> ' . $results->data[$i]["titulo"] .' </a></td> ';?> 
                            <?php echo '<td><a href="/show-writers.php?author_id='. $results->data[$i]["autores_id"] .'&limit=5&page=1"> ' . $results->data[$i]["nombre"] . " " . $results->data[$i]["apellido"] . '</a></td>';?>
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

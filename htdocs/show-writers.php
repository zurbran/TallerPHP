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
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

        <?php
        require_once "pdo-connect.php";
        require_once 'paginator.class.php';

        $stmt= $pdo->prepare('SELECT l.id, l.portada, l.titulo, a.nombre, a.apellido, l.cantidad FROM libros l INNER JOIN autores a ON (l.autores_id = a.id) WHERE l.autores_id = :author ORDER BY l.titulo ASC');
        $stmt->execute([':author' => $_GET['author_id']]);

        $data= $stmt->fetchAll();
        $stmt= null;

        //$writerPaginator  = new Paginator( $pdo );
        //$writerBooks = $writerPaginator->getData( $_GET['limit'] , $_GET['page']);
        
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
            <?php echo "<p class='h1 titulo-libro'> Libros de " . $data[0]['nombre'] . " " . $data[0]['apellido'] . "</p>"?>
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
                                for( $i = 0; $i < count( $data ); $i++ ) :
                                    $image_data = $data[$i]["portada"];
                                    $encoded_image = base64_encode($image_data);
                                    $Hinh = "<a href='/single-book.php?libro_id=" . $data[$i]["id"] . "'><img  src='data:image/jpg;base64,{$encoded_image}' width='200' height='200' /> </a>";
                        ?>
                            <tr>
                            <th scope="row"><?php echo $Hinh ?></th>
                            <?php echo '<td><a href="/single-book.php?libro_id='.  $data[$i]["id"]  .'"> ' . $data[$i]["titulo"] .' </a></td> ';?> 
                            <td><?php echo $data[$i]["cantidad"] ?></td>
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
            //        echo $writerPaginator->createLinks( $links, 'pagination','indexpages' );
                   ?>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</body>

</html>
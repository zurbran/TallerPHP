<!DOCTYPE html>
<html lang="es">

<head>


    <title>Cinema Rocha</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

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

    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">
                    <a href="#" class="list-group-item active">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>
            </div>
                <?php 
                    for( $i = 0; $i < count( $results->data ); $i++ ) :
                        $image_data = $results->data[$i]["contenidoimagen"];
                        $encoded_image = base64_encode($image_data);
                        //You dont need to decode it again.

                        $Hinh = "<img  src='data:image/" . $results->data[$i]['tipoimagen'] . ";base64,{$encoded_image}' width='200' height='200' />";
 
                        //and you echo $Hinh



                ?>
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
            
                <div class="thumbnail">
                    <?php echo $Hinh ?>
                    <div class="caption-full">
                        <h4 class="pull-right"> <?php echo $results->data[$i]["anio"]; ?> </h4>
                        <h4><a href="#"><?php echo $results->data[$i]["nombre"]; ?></a>
                        </h4>
                        <p class="text-muted"> <?php echo $results->data[$i]["genero"]; ?>  </p>
                        <p> <?php echo $results->data[$i]["sinopsis"]; ?> </p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">3 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>
                </div>
            </div>
            <?php 
            endfor;
            ?>
        </div>
        <div class="col-md-3">
        </div>
        <?php
        echo $Paginator->createLinks( $links, 'pagination pagination-sm' );
        ?>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

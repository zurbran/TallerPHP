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

    <link href="/grupo30/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->

    <link href="/grupo30/css/single-book.css" rel="stylesheet">
    <link href="/grupo30/css/media.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/grupo30/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/grupo30/js/bootstrap.min.js"></script>
    <script src="/grupo30/js/bootstrap.js"></script>

        <?php
        require_once "../grupo30/pdo-connect.php";
        require_once '../grupo30/paginator.class.php';
        require_once "../grupo30/user.class.php";

        $isLogged = false;
        $links= isset( $_GET['links'] ) ? $_GET['links'] : 8;
        $authorId = isset($_GET['author_id']) ? $_GET['author_id'] : NULL;
        if($authorId == NULL)
        {
            echo "Autor Invalido";
        }
        else
        {
        $stmt= $pdo->prepare('SELECT a.nombre, a.apellido FROM autores a WHERE a.id = :author');
        $stmt->execute([':author' => $authorId]);
        $predata= $stmt->fetchAll();
        $stmt= null;
        $name= $predata[0]['nombre'] . " " . $predata[0]['apellido'];

        $query      = "SELECT l.autores_id, l.id, l.portada, l.titulo, a.nombre, a.apellido,l.cantidad, (SELECT COUNT(*) FROM operaciones o WHERE o.libros_id = l.id AND ultimo_estado = 'RESERVADO') AS reservados, (SELECT COUNT(*) FROM operaciones o WHERE o.libros_id = l.id AND ultimo_estado = 'PRESTADO') AS prestados FROM libros l INNER JOIN autores a ON (l.autores_id = a.id)";
        $writerPaginator  = new Paginator( $pdo, $query, 1, 1 );
        $results = $writerPaginator->getData( $_GET['limit'] , $_GET['page'], $name,'');
        
        ?>
</head>
<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
        <?php
        if(User::isLogged())
        {
            $user = User::login($_SESSION['email'],$_SESSION['password'],$pdo);
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

        <div class="row">
            <p class='h1 titulo-libro'> Libros de <?= $name ?> </p>
        </div>

        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-xs-16 col-sm-10 col-md-10">
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
                        ?>
                            <tr>
                            <th scope="row"><a href='/grupo30/single-book.php?libro_id=<?=$results->data[$i]["id"]?>'><img  src="data:image/jpg;base64,<?=$encoded_image?>" width='200' height='200' /> </a></th>
                            <td><a href='/grupo30/single-book.php?libro_id=<?=$results->data[$i]["id"]?>'><?=$results->data[$i]["titulo"]?></a></td>
                                <?php 
                                    $total = $results->data[$i]["cantidad"];
                                    $prestados = $results->data[$i]["prestados"];
                                    $reservados = $results->data[$i]["reservados"];
                                    $disponibles = $total - $prestados - $reservados;
                                    $stockString = $total . "(";
                                    if($disponibles > 0)
                                    {
                                        $stockString .= $disponibles . " disponibles";
                                        if(($prestados > 0)|| ($reservados > 0))
                                        {
                                            $stockString .= "- ";
                                        }
                                    }
                                    if($prestados > 0)
                                    {
                                        $stockString .= $prestados . " prestados ";
                                        if($reservados > 0)
                                        {
                                            $stockString .= "- ";
                                        }
                                    }
                                    if($reservados > 0 )
                                    {
                                        $stockString .= $reservados . " reservados";
                                    }
                                    $stockString .= ") </td>";
                                ?>
                            <td><?=$stockString?></td>
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

        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <?php $writerPaginator->createAuthorLinks( $links, 'pagination','indexpages', $authorId, $name);?>
            </div>
        </div>
    </div>
</body>
<?php
    }
?>
</html>
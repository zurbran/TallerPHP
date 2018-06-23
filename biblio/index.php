<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP - Indice</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <script src="js/index.js"></script>

    <?php
    require_once "pdo-connect.php";
    require_once 'paginator.class.php';

    $links= isset( $_GET['links'] ) ? $_GET['links'] : 10;
    $limit= isset( $_GET['limit'] ) ? $_GET['limit'] : 5;
    $page=  isset( $_GET['page'] )  ? $_GET['page']  : 1;
    $sort=  isset( $_GET['sort'] )  ? $_GET['sort']  : 0;
    $order= isset( $_GET['order'] ) ? $_GET['order'] : 0;
    $tittle = isset($_GET['searchT']) ? $_GET['searchT'] : '';
    $author = isset($_GET['searchA']) ? $_GET['searchA'] : '';

    $query      = "SELECT l.autores_id, l.id, l.portada, l.titulo, a.nombre, a.apellido,l.cantidad, (SELECT COUNT(*) FROM operaciones o WHERE o.libros_id = l.id AND ultimo_estado = 'RESERVADO') AS reservados, (SELECT COUNT(*) FROM operaciones o WHERE o.libros_id = l.id AND ultimo_estado = 'PRESTADO') AS prestados FROM libros l INNER JOIN autores a ON (l.autores_id = a.id)";

    $pdoconn = $pdo;

    $Paginator  = new Paginator( $pdoconn, $query, $sort, $order );

    $results    = $Paginator->getData($limit , $page, $author, $tittle);

    ?>
    
</head>
<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
        <?php 
            if((isset($_SESSION['email']))&&(isset($_SESSION['password'])))
            {
                $email = $_SESSION['email'];
                $password = $_SESSION['password'];

                $stmt = $pdoconn->prepare('SELECT id, nombre, apellido FROM usuarios WHERE email = :email AND clave = :password');
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                if($stmt->rowCount() == 0)
                {
                    session_destroy();
                    throw new Exception("Credenciales invalidas.");
                }
                else
                {
                    $row = $stmt->fetch();
                    $userData['id'] = $row['id'];
                    $userData['email'] = $email;
                    $userData['nombre'] = $row['nombre'];
                    $userData['apellido'] = $row['apellido'];
                    $userData['password'] = $password;
                    $isLogged = true;
                }
    
                include "loggednavbar.php";
            }
            else
            {
                $isLogged = false;
                include "defaultnavbar.php";
            }
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
                        <input type="search" id="titulobusqueda" class="form-control" placeholder="Ingrese el título del libro a buscar" name="searchT" value= "<?= $tittle?>">
                        </div>
                        <div class="form-group">
                        <label for="autorbusqueda">Autor</label>
                        <input type="search" id="autorbusqueda" class="form-control" placeholder="Ingrese el autor el cual buscar" name="searchA" value= "<?= $author?>">
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
            <?php
                if($results == NULL)
                {
                    echo "No se encontraron libros.";
                }
                else
                {
            ?>
            <div class="col-xs-16 col-sm-10 col-md-10">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Portada</th>
                            <th scope="col"><a href="/index.php?sort=0&order=<?=(($order == 0)?1:0);?>&searchA=<?=$author?>&searchT=<?=$tittle?>&limit=5&page=1">Titulo</a></th>
                            <th scope="col"><a href="/index.php?sort=2&order=<?=(($order == 0)?1:0);?>&searchA=<?=$author?>&searchT=<?=$tittle?>&limit=5&page=1">Autor</a></th>
                            <th scope="col">Ejemplares</th>
                            <?php
                                if($isLogged)
                                {
                            ?>
                            <th scope="col">Accion</th>
                            <?php
                                }
                            ?>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                                for( $i = 0; $i < count( $results->data ); $i++ ) :
                                    $image_data = $results->data[$i]["portada"];
                                    $encoded_image = base64_encode($image_data);
                        ?>
                            <tr>
                            <th scope="row"><a href='/single-book.php?libro_id=<?=$results->data[$i]["id"]?>'><img  src="data:image/jpg;base64,<?=$encoded_image?>" width='200' height='200' /> </a></th>
                            <td><a href='/single-book.php?libro_id=<?=$results->data[$i]["id"]?>'><?=$results->data[$i]["titulo"]?></a></td>
                            <td><a href='/show-writers.php?author_id=<?=$results->data[$i]["autores_id"]?>&limit=5&page=1'><?=$results->data[$i]["nombre"]?> <?=$results->data[$i]["apellido"]?></a></td>
                            <?php 
                                $total = $results->data[$i]["cantidad"];
                                $prestados = $results->data[$i]["prestados"];
                                $reservados = $results->data[$i]["reservados"];
                                $disponibles = $total - $prestados - $reservados;
                                if($isLogged)
                                {
                                    $stmt = $pdoconn->prepare("SELECT * FROM operaciones WHERE lector_id=:userid AND libros_id=:bookid AND NOT ultimo_estado='DEVUELTO'");
                                    $stmt->bindValue(':userid', (int) $userData['id'], PDO::PARAM_INT);
                                    $stmt->bindValue(':bookid', (int) $results->data[$i]["id"], PDO::PARAM_INT);
                                    $stmt->execute();
                                    if($stmt->rowCount() == 0)
                                    {
                                        $hasBook[$i] = false;
                                    }
                                    else
                                    {
                                        $hasBook[$i] = true;
                                    }
                                    if (($_SERVER['REQUEST_METHOD'] === 'POST')&&($disponibles > 0)&&(isset($_POST['bookId']))&&($_POST['bookId']==$results->data[$i]["id"])&&(!$hasBook[$i]))
                                    {
                                        $dateString = date("Y:m:d");
                                        $stmt = $pdoconn->prepare("INSERT INTO operaciones(ultimo_estado,fecha_ultima_modificacion,lector_id,libros_id) VALUES ('RESERVADO','".$dateString."', :userid , :bookid)");
                                        $stmt->bindValue(':bookid', (int) $results->data[$i]["id"], PDO::PARAM_INT);
                                        $stmt->bindValue(':userid', (int) $userData['id'], PDO::PARAM_INT);
                                        $stmt->execute();
                                        $hasBook[$i] = false;
                                        $disponibles--;
                                        $reservados++;
                                    }
                                }
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
                            <?php
                                if($isLogged)
                                {
                                    if(($disponibles > 0)&&(!$hasBook[$i]))
                                    {
                            ?>
                                        <td><button type="button" onclick="reservate(<?=$results->data[$i]["id"]?>)" id="reserve" class="btn btn-dark" >Reservar</button></td>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                                        <td></td>
                            <?php
                                    }
                                }
                            ?>
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
                    $Paginator->createLinks( $links, 'pagination','indexpages', $tittle, $author);
                    ?>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</body>
</html>
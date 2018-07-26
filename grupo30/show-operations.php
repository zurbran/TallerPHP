<?php
    session_start();

    require_once "../grupo30/user.class.php";

    if(User::isLogged())
    {
        try
        {
            $user = User::login($_SESSION['email'],$_SESSION['password'],$pdo);
        }
        catch(Exception $e)
        {
            session_destroy();
            $url = 'http://localhost/grupo30/index.php?cred=false';
            header( "Location: $url" );
        }
        if($user->isLibrarian())
        {
?>
<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca UNLP - Perfil</title>

    <!-- Bootstrap Core CSS -->

    <link href="/grupo30/css/bootstrap.css" rel="stylesheet">
    <link href="/grupo30/css/hidden.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/grupo30/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/grupo30/js/bootstrap.min.js"></script>
    <script src="/grupo30/js/bootstrap.js"></script>
    <script src="/grupo30/js/show-operations.js"></script>

    <?php

    require_once "../grupo30/pdo-connect.php";
    require_once '../grupo30/paginator.class.php';

    $links= isset( $_GET['links'] ) ? $_GET['links'] : 8;
    $limit= isset( $_GET['limit'] ) ? $_GET['limit'] : 5;
    $page=  isset( $_GET['page'] )  ? $_GET['page']  : 1;
    $sort=  isset( $_GET['sort'] )  ? $_GET['sort']  : 0;
    $order= isset( $_GET['order'] ) ? $_GET['order'] : 0;
    $tittle = isset($_GET['searchT']) ? $_GET['searchT'] : '';
    $author = isset($_GET['searchA']) ? $_GET['searchA'] : '';
    $reader = isset($_GET['searchL']) ? $_GET['searchL'] : '';
    $fromdate = isset($_GET['datefrom']) ? $_GET['datefrom'] : '';
    $todate = isset($_GET['dateuntil']) ? $_GET['dateuntil'] : date("Y-m-d");
    $isPost = false;
    $pdoconn = $pdo;

    $query= "SELECT l.autores_id, l.id, l.titulo, a.nombre, a.apellido, o.ultimo_estado, o.fecha_ultima_modificacion, u.nombre AS username, u.apellido AS userlastname, o.id AS operId FROM operaciones o INNER JOIN libros l ON o.libros_id=l.id INNER JOIN autores a ON l.autores_id=a.id INNER JOIN usuarios u ON o.lector_id = u.id";

    $Paginator  = new Paginator( $pdo, $query, $sort, $order);

    $results= $Paginator->getRequestedOperations($limit , $page, $author, $tittle, $reader, $fromdate, $todate);            

    ?>
    
</head>

<body style="padding-top: 70px;">

    <div class="container-fluid fill-height">
        <div class="row">
        <?php include "loggednavbar.php"; ?>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
            <img class="logo" src="img/logo-transparente.png" alt="logounlp">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6">
                <form action= 'show-operations.php'>
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
                        <div class="form-group">
                        <label for="lectorbusqueda">Lector</label>
                        <input type="search" id="lectorbusqueda" class="form-control" placeholder="Ingrese el lector el cual buscar" name="searchL" value= "<?= $reader?>">
                        </div>
                        <div class="form-group">
                        <label for="fechadesde">Fecha desde:</label>
                        <input type="date" id="fechadesde" class="form-control" name="datefrom" value="<?= $fromdate?>">
                        </div>
                        <div class="form-group">
                        <label for="fechahasta">Fecha hasta:</label>
                        <input type="date" id="fechahasta" class="form-control" name="dateuntil" value="<?= $todate?>" >
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
                        <th scope="col">Titulo</a></th>
                        <th scope="col">Autor</a></th>
                        <th scope="col">Lector</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acción</th>
                        </tr>
                    </thead>

                    <?php if (($_SERVER['REQUEST_METHOD'] === 'POST'))
                        {
                            $isPost = true;
                            if (isset($_POST['opNum'])&&isset($_POST['operation']))
                            {
                                $opid = $_POST['opNum'];
                                $op = $_POST['operation'];
                            }
                            else
                            {
                                $opid = NULL;
                                $op = NULL;
                            }
                        } 
                    ?>

                    <tbody>
                    <?php
                        for( $i = 0; $i < count( $results->data ); $i++ ) :
                    ?>
                        <tr>
                        <td><a href='/grupo30/single-book.php?libro_id=<?=$results->data[$i]["id"]?>'><?=$results->data[$i]["titulo"]?></a></td>
                        <td><a href='/grupo30/show-writers.php?author_id=<?=$results->data[$i]["autores_id"]?>&limit=5&page=1'><?=$results->data[$i]["nombre"]?> <?=$results->data[$i]["apellido"]?></a></td>
                        <td><?= $results->data[$i]["username"].' '.$results->data[$i]["userlastname"] ?></td>
                        <?php if (($isPost)&&($opid == $results->data[$i]["operId"]))
                            {
                                if(($op == "borrow")&&($results->data[$i]["ultimo_estado"] == 'RESERVADO'))
                                {
                                    $dateString = date("Y-m-d");
                                    $stmt = $pdoconn->prepare("UPDATE operaciones SET ultimo_estado='PRESTADO', fecha_ultima_modificacion= :currentDate WHERE id= :operationid");
                                    $stmt->bindValue(':operationid', $opid , PDO::PARAM_INT);
                                    $stmt->bindValue(':currentDate', $dateString, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $results->data[$i]["ultimo_estado"] = 'PRESTADO';
                                    $results->data[$i]["fecha_ultima_modificacion"] = $dateString;
                                }
                                elseif (($op == "takeback")&&($results->data[$i]["ultimo_estado"] == 'PRESTADO'))
                                {
                                    $dateString = date("Y-m-d");
                                    $stmt = $pdoconn->prepare("UPDATE operaciones SET ultimo_estado='DEVUELTO', fecha_ultima_modificacion= :currentDate WHERE id= :operationid ");
                                    $stmt->bindValue(':operationid', $opid , PDO::PARAM_INT);
                                    $stmt->bindValue(':currentDate', $dateString, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $results->data[$i]["ultimo_estado"] = 'DEVUELTO';
                                    $results->data[$i]["fecha_ultima_modificacion"] = $dateString;
                                }
                            }
                        ?>
                        <td><?= $results->data[$i]["ultimo_estado"] ?></td>
                        <td><?= $results->data[$i]["fecha_ultima_modificacion"] ?></td>
                        <?php if($results->data[$i]["ultimo_estado"] == 'RESERVADO') : ?>
                            <td><button type="button" onclick="borrow(<?=$results->data[$i]["operId"]?>)" id="borrowed" class="btn btn-dark" >Prestar</button></td>
                        <?php elseif($results->data[$i]["ultimo_estado"] == 'PRESTADO') : ?>
                            <td><button type="button" onclick="takeback(<?=$results->data[$i]["operId"]?>)" id="taked" class="btn btn-dark" >Devolver</button></td>
                        <?php else : ?>
                                <td></td>
                        <?php endif; ?>
                        </tr>
                    <?php
                        endfor;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <?php                 
                    $Paginator->createBiblioLinks( $links, 'pagination', 'indexpages', $tittle, $author, $reader, $fromdate, $todate);
                ?>
            </div>
        </div>
    </div>  
    <?php
                }
    ?>
</body>

</html>

<?php
        }
    }
    ?>
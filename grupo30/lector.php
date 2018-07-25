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
                    <th scope="col"><a href="?sort=0&order=<?=(($order == 0)?1:0);?>&limit=5&page=1">Titulo</a></th>
                    <th scope="col"><a href="?sort=2&order=<?=(($order == 0)?1:0);?>&limit=5&page=1">Autor</a></th>
                    <th scope="col">Estado</th>
                    <th scop="col">Fecha</th>
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
                    <td><a href='/grupo30/show-writers.php?author_id=<?=$results->data[$i]["autores_id"]?>&limit=5&page=1'><?=$results->data[$i]["nombre"]?> <?=$results->data[$i]["apellido"]?></a></td>
                    <td><?=$results->data[$i]["ultimo_estado"]?></td>
                    <td><?=$results->data[$i]["fecha_ultima_modificacion"]?></td>
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
            $Paginator->createReaderHistoryLinks( $links, 'pagination','indexpages');
            ?>
    </div>
    <div class="col-md-4">
    </div>
</div>

<?php
        }
?>
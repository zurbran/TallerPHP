<?php
 
 require_once "../grupo30/pdo-connect.php";

class Paginator {
 
    private $_conn;
    private $_statement;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
    private $_sort;
    private $_order;
    private $_fromdate;

public function __construct( $conn, $query, $sort, $order ) {
     
    $this->_conn = $conn;
    $this->_sort = $sort;
    $this->_order = $order;
    $this->_query = $query;
}

private function setOrder(){
    $this->_query .= " ORDER BY";
    switch($this->_sort){
        case 2:
        case 3:
            $this->_query .= " a.nombre";
            break;
        default:
            $this->_query .= " l.titulo";
            break;
    }

    if($this->_order != 0)
        $this->_query .= " DESC";
    else
        $this->_query .= " ASC";
}

private function totalRows($author, $title){
    if(!empty($author)||!empty($title))
    {
        $this->_query .= " WHERE";
        if(!empty($author))
        {
            $this->_query .= ' (CONCAT(a.nombre, " ", a.apellido) LIKE :searchAn OR CONCAT(a.apellido, " ", a.nombre) LIKE :searchAa)';
            if(!empty($title))
            {
                $this->_query .= " AND (l.titulo LIKE :searchT)";
                $this->_statement = $this->_conn->prepare($this->_query);
                $this->_statement->bindValue(':searchT', '%'.$title.'%', PDO::PARAM_STR);
            }
            else
            {
                $this->_statement = $this->_conn->prepare($this->_query);
            }
            $this->_statement->bindValue(':searchAa', '%'.$author.'%', PDO::PARAM_STR);
            $this->_statement->bindValue(':searchAn', '%'.$author.'%', PDO::PARAM_STR);
        }
        else
        {
            $this->_query .= " (l.titulo LIKE :searchT)";
            $this->_statement = $this->_conn->prepare($this->_query);
            $this->_statement->bindValue(':searchT', '%'.$title.'%', PDO::PARAM_STR);
        }
    }
    else
    {
        $this->_statement = $this->_conn->prepare($this->_query);
    }

    $this->_statement->execute();
    return $this->_statement->rowCount();
}

public function getData( $limit, $page, $author, $title) {
    $this->_total = $this->totalRows($author, $title);
    if($this->_total == 0)
    {
        return NULL;
    }
    $this->_limit   = $limit;
    $this->_page    = $page;

    $this->setOrder();

    if ( $this->_limit == 'all' ) {
        $query      = $this->_query;
    } else {
        $query      = $this->_query . " LIMIT :floorlimit, :rooflimit";
    }
    $this->_statement = $this->_conn->prepare($query);
    $this->_statement->bindValue(':floorlimit', (int) ( ( $this->_page - 1 ) * $this->_limit ), PDO::PARAM_INT);
    $this->_statement->bindValue(':rooflimit', (int) $this->_limit, PDO::PARAM_INT);
    if(!empty($title))
    {
        $this->_statement->bindValue(':searchT', '%'.$title.'%', PDO::PARAM_STR);
    }
    if(!empty($author))
    {
        $this->_statement->bindValue(':searchAa', '%'.$author.'%', PDO::PARAM_STR);
        $this->_statement->bindValue(':searchAn', '%'.$author.'%', PDO::PARAM_STR);
    }
    $this->_statement->execute();

    while ( $row =  $this->_statement->fetch(PDO::FETCH_ASSOC) ) {
        $results[]  = $row;
    }
 
    $result         = new stdClass();
    $result->page   = $this->_page;
    $result->limit  = $this->_limit;
    $result->total  = $this->_total;
    $result->data   = $results;
    
    return $result;
}

private function totalOperations($author, $title, $reader, $fromdate, $todate){
    $this->_query .= ' WHERE ((CONCAT(a.nombre, " ", a.apellido) LIKE :searchAn) OR (CONCAT(a.apellido, " ", a.nombre) LIKE :searchAa)) AND (l.titulo LIKE :searchT) AND ((CONCAT(u.nombre, " ", u.apellido) LIKE :searchLn) OR (CONCAT(u.apellido, " ", u.nombre) LIKE :searchLa)) AND (o.fecha_ultima_modificacion >= :datefromfilter) AND (o.fecha_ultima_modificacion <= :datetofilter)';
    $this->_statement = $this->_conn->prepare($this->_query);

    if(empty($author))
        $author = '%';
    if(empty($title))
        $title = '%';
    if(empty($reader))
        $reader = '%';
    if(empty($fromdate))
        $fromdate = '1999-12-31';

    $this->_fromdate = $fromdate;

    $this->_statement->bindValue(':searchAn', '%'.$author.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchAa', '%'.$author.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchT', '%'.$title.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchLn', '%'.$reader.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchLa', '%'.$reader.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':datefromfilter', $fromdate, PDO::PARAM_STR);
    $this->_statement->bindValue(':datetofilter', $todate, PDO::PARAM_STR);
    $this->_statement->execute();
    return $this->_statement->rowCount();
}

public function getRequestedOperations($limit, $page, $author, $title, $reader, $fromdate, $todate){
    $this->_total = $this->totalOperations($author, $title, $reader, $fromdate, $todate);

    if($this->_total == 0)
    {
        return NULL;
    }
    
    $this->_limit   = $limit;
    $this->_page    = $page;

    $this->_query .= " ORDER BY o.fecha_ultima_modificacion DESC";

    if ( $this->_limit == 'all' ) {
        $query      = $this->_query;
    } else {
        $query      = $this->_query . " LIMIT :floorlimit, :rooflimit";
    }

    $this->_statement = $this->_conn->prepare($query);
    $this->_statement->bindValue(':floorlimit', (int) ( ( $this->_page - 1 ) * $this->_limit ), PDO::PARAM_INT);
    $this->_statement->bindValue(':rooflimit', (int) $this->_limit, PDO::PARAM_INT);
    $this->_statement->bindValue(':searchT', '%'.$title.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchAa', '%'.$author.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchAn', '%'.$author.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchLn', '%'.$reader.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':searchLa', '%'.$reader.'%', PDO::PARAM_STR);
    $this->_statement->bindValue(':datefromfilter',$this->_fromdate, PDO::PARAM_STR);
    $this->_statement->bindValue(':datetofilter', $todate, PDO::PARAM_STR);
    $this->_statement->execute();

    while ( $row =  $this->_statement->fetch(PDO::FETCH_ASSOC) ) {
        $results[]  = $row;
    }
 
    $result         = new stdClass();
    $result->page   = $this->_page;
    $result->limit  = $this->_limit;
    $result->total  = $this->_total;
    $result->data   = $results;
    
    return $result;
}

private function totalHistoryRows($id){
    $this->_statement = $this->_conn->prepare($this->_query);
    $this->_statement->bindValue(':userid', (int) $id, PDO::PARAM_INT);
    $this->_statement->execute();
    return $this->_statement->rowCount();
}

public function getReaderHistory($limit, $page, $id){
    $this->_total = $this->totalHistoryRows($id);
    if($this->_total == 0)
    {
        return NULL;
    }
    $this->_limit   = $limit;
    $this->_page    = $page;

    $this->setOrder();

    if ( $this->_limit == 'all' ) {
        $query      = $this->_query;
    } else {
        $query      = $this->_query . " LIMIT :floorlimit, :rooflimit";
    }
    $this->_statement = $this->_conn->prepare($query);
    $this->_statement->bindValue(':floorlimit', (int) ( ( $this->_page - 1 ) * $this->_limit ), PDO::PARAM_INT);
    $this->_statement->bindValue(':rooflimit', (int) $this->_limit, PDO::PARAM_INT);
    $this->_statement->bindValue(':userid', (int) $id, PDO::PARAM_INT);

    $this->_statement->execute();

    while ( $row =  $this->_statement->fetch(PDO::FETCH_ASSOC) ) {
        $results[]  = $row;
    }
 
    $result         = new stdClass();
    $result->page   = $this->_page;
    $result->limit  = $this->_limit;
    $result->total  = $this->_total;
    $result->data   = $results;
    
    return $result;
}

public function createBiblioLinks( $links, $list_class, $paginatorlabel, $tittle, $author, $reader, $fromdate, $todate) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 2 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last-1 ) ? $this->_page + $links : $last;
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";
    ?>
    <nav aria-label='<?=$paginatorlabel?>'>
        <ul class='<?=$list_class?>'>
            <li class='<?=$class?>'>
                <a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&searchL=<?=$reader?>&datefrom=<?=$fromdate?>&dateuntil=<?=$todate?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=($this->_page - 1 )?>">Anterior</a>
            </li>
    <?php
    if ( $start > 1 ) 
    {?>
        <li><a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&searchL=<?=$reader?>&datefrom=<?=$fromdate?>&dateuntil=<?=$todate?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=1">1</a></li>
        <li class="page-item disabled"><span>...</span></li>
    <?php
    }
    ?>
 
    <?php
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "page-item active" : "page-item";
    ?>
        <li class='<?=$class?>'><a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&searchL=<?=$reader?>&datefrom=<?=$fromdate?>&dateuntil=<?=$todate?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=$i?>"><?=$i?></a></li>
    <?php
    }
    ?>
 
    <?php
    if ( $end < $last ) {
    ?>
        <li class="page-item disabled"><span>...</span></li>
        <li><a class="<?=$aclass?>" href="?sort=<?=$this->_sort?>&searchL=<?=$reader?>&datefrom=<?=$fromdate?>&dateuntil=<?$todate?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=$last?>"><?=$last?></a></li>
    <?php
    }
    ?>
 
    <?php
    $class      = ( $this->_page == $last ) ? "page-item disabled" : "page-item";
    ?>
    <li class="<?=$class?>"><a class="<?=$aclass?>" href="?sort=<?=$this->_sort?>&searchL=<?=$reader?>&datefrom=<?=$fromdate?>&dateuntil=<?=$todate?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=( $this->_page + 1 )?>">Siguiente</a></li>
    </ul>
    </nav>
<?php
}

public function createLinks( $links, $list_class, $paginatorlabel, $tittle, $author) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 2 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last-1 ) ? $this->_page + $links : $last;
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";
    ?>
    <nav aria-label='<?=$paginatorlabel?>'>
        <ul class='<?=$list_class?>'>
            <li class='<?=$class?>'>
                <a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=($this->_page - 1 )?>">Anterior</a>
            </li>
    <?php
    if ( $start > 1 ) 
    {?>
        <li><a class='<?=$aclass?>' href="?limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=1">1</a></li>
        <li class="page-item disabled"><span>...</span></li>
    <?php
    }
    ?>
 
    <?php
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "page-item active" : "page-item";
    ?>
        <li class='<?=$class?>'><a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=$i?>"><?=$i?></a></li>
    <?php
    }
    ?>
 
    <?php
    if ( $end < $last ) {
    ?>
        <li class="page-item disabled"><span>...</span></li>
        <li><a class="<?=$aclass?>" href="?limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=$last?>"><?=$last?></a></li>
    <?php
    }
    ?>
 
    <?php
    $class      = ( $this->_page == $last ) ? "page-item disabled" : "page-item";
    ?>
    <li class="<?=$class?>"><a class="<?=$aclass?>" href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&searchT=<?=$tittle?>&page=<?=( $this->_page + 1 )?>">Siguiente</a></li>
    </ul>
    </nav>
<?php
}

public function createAuthorLinks( $links, $list_class, $paginatorlabel, $id, $author) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 2 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last-1 ) ? $this->_page + $links : $last;
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";
    ?>
    <nav aria-label='<?=$paginatorlabel?>'>
        <ul class='<?=$list_class?>'>
            <li class='<?=$class?>'>
                <a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?$author?>&author_id=<?=$id?>&page=<?=($this->_page - 1 )?>">Anterior</a>
            </li>
    <?php
    if ( $start > 1 ) 
    {?>
        <li><a class='<?=$aclass?>' href="?limit=<?=$this->_limit?>&searchA=<?=$author?>&author_id=<?=$id?>&page=1">1</a></li>
        <li class="page-item disabled"><span>...</span></li>
    <?php
    }
    ?>
 
    <?php
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "page-item active" : "page-item";
    ?>
        <li class='<?=$class?>'><a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&author_id=<?=$id?>&page=<?=$i?>"><?=$i?></a></li>
    <?php
    }
    ?>
 
    <?php
    if ( $end < $last ) {
    ?>
        <li class="page-item disabled"><span>...</span></li>
        <li><a class="<?=$aclass?>" href="?limit=<?=$this->_limit?>&searchA=<?=$author?>&author_id=<?=$id?>&page=<?=$last?>"><?=$last?></a></li>
    <?php
    }
    ?>
 
    <?php
    $class      = ( $this->_page == $last ) ? "page-item disabled" : "page-item";
    ?>
    <li class="<?=$class?>"><a class="<?=$aclass?>" href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&searchA=<?=$author?>&author_id=<?=$id?>&page=<?=( $this->_page + 1 )?>">Siguiente</a></li>
    </ul>
    </nav>
<?php
}

public function createReaderHistoryLinks( $links, $list_class, $paginatorlabel) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 2 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last-1 ) ? $this->_page + $links : $last;
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";
    ?>
    <nav aria-label='<?=$paginatorlabel?>'>
        <ul class='<?=$list_class?>'>
            <li class='<?=$class?>'>
                <a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&page=<?=($this->_page - 1 )?>">Anterior</a>
            </li>
    <?php
    if ( $start > 1 ) 
    {?>
        <li><a class='<?=$aclass?>' href="?limit=<?=$this->_limit?>&page=1">1</a></li>
        <li class="page-item disabled"><span>...</span></li>
    <?php
    }
    ?>
 
    <?php
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "page-item active" : "page-item";
    ?>
        <li class='<?=$class?>'><a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&page=<?=$i?>"><?=$i?></a></li>
    <?php
    }
    ?>
 
    <?php
    if ( $end < $last ) {
    ?>
        <li class="page-item disabled"><span>...</span></li>
        <li><a class="<?=$aclass?>" href="?limit=<?=$this->_limit?>&page=<?=$last?>"><?=$last?></a></li>
    <?php
    }
    ?>
 
    <?php
    $class      = ( $this->_page == $last ) ? "page-item disabled" : "page-item";
    ?>
    <li class="<?=$class?>"><a class="<?=$aclass?>" href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?=$this->_limit?>&page=<?=( $this->_page + 1 )?>">Siguiente</a></li>
    </ul>
    </nav>
<?php
}

}
?>

<?php
 
 require_once "pdo-connect.php";

class Paginator {
 
    private $_conn;
    private $_statement;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
    private $_sort;
    private $_order;
 

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

public function createLinks( $links, $list_class, $paginatorlabel, $tittle, $author) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";
    ?>
    <nav aria-label='<?=$paginatorlabel?>'>
        <ul class='<?=$list_class?>'>
            <li class='<?=$class?>'>
                <a class='<?=$aclass?>' href="?sort=<?=$this->_sort?>&order=<?=$this->_order?>&limit=<?$this->_limit?>&searchA=<?$author?>&searchT=<?$tittle?>&page=<?=($this->_page - 1 )?>">Anterior</a>
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

}?>

<?php
 
 require_once "pdo-connect.php";

class Paginator {
 
    private $_conn;
    private $_statement;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
 //   private $_search;
 

public function __construct( $conn, $query ) {
     
    $this->_conn = $conn;
    $this->_query = $query;
    $this->_statement = $this->_conn->prepare($query);
    $this->_statement->execute();

    $this->_total = $this->_statement->rowCount();
     
}

public function getData( $limit, $page) {
     
    $this->_limit   = $limit;
    $this->_page    = $page;
    //$this->_search  = $search;

    if ( $this->_limit == 'all' ) {
        $query      = $this->_query;
    } else {
        $query      = $this->_query . " LIMIT :floorlimit, :rooflimit";
    }
    $this->_statement = $this->_conn->prepare($query);
    //$this->_statement->bindValue(':searchT', (string) $this->_search, PDO::PARAM_STR);WHERE titulo LIKE :searchT
    $this->_statement->bindValue(':floorlimit', (int) ( ( $this->_page - 1 ) * $this->_limit ), PDO::PARAM_INT);
    $this->_statement->bindValue(':rooflimit', (int) $this->_limit, PDO::PARAM_INT);
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

public function createLinks( $links, $list_class, $paginatorlabel ) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
 
    $html       =  '<nav aria-label="' . $paginatorlabel . '">';
    $html       .= '<ul class="' . $list_class . '">';
 
    $class      = ( $this->_page == 1 ) ? "page-item disabled" : "page-item";
    $aclass     = "page-link";

    $html       .= '<li class="' . $class . '"><a class="'. $aclass .'" href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">Anterior</a></li>';
 
    if ( $start > 1 ) {
        $html   .= '<li><a class="'. $aclass .'" href="?limit=' . $this->_limit . '&page=1">1</a></li>';
        $html   .= '<li class="page-item disabled"><span>...</span></li>';
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "page-item active" : "page-item";
        $html   .= '<li class="' . $class . '"><a class="'. $aclass .'" href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="page-item disabled"><span>...</span></li>';
        $html   .= '<li><a class="'. $aclass .'" href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
    }
 
    $class      = ( $this->_page == $last ) ? "page-item disabled" : "page-item";
    $html       .= '<li class="' . $class . '"><a class="'. $aclass .'" href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">Siguiente</a></li>';
 
    $html       .= '</ul>';
    $html       .= '</nav>';
 
    return $html;
}

}
?>
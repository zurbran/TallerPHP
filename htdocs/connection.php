<?php
$connect = mysqli_connect("127.0.0.1","root","movies","movies");
if (!$connect){
    echo "DB Connection Error!!";
}
?>
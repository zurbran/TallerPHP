<?php
$connect = mysqli_connect("127.0.0.1","root","asdasd","books");
mysqli_set_charset($connect, "utf8");
if (!$connect){
    echo "DB Connection Error!!";
}
?>
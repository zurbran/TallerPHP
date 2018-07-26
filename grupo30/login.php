<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if(isset($_POST['useremail']))
        {
            session_start();
            $_SESSION['email'] = $_POST['useremail'];
            if(isset($_POST['password']))
            {
                $_SESSION['password'] = $_POST['password'];
                $url = 'http://localhost/grupo30/index.php';
                header( "Location: $url" );
            }
            else
            {
                session_destroy();
                echo "Password no introducido";
            }
        }
        else
        {
            echo "Email no introducido";
        }
    }
?>
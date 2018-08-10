<?php
    session_start();
    require_once "user.class.php";
    require_once "pdo-connect.php";
    if(User::isLogged()){
        try
        {
            $user = User::login($_SESSION['email'],$_SESSION['password'],$pdo);
        }
        catch(Exception $e)
        {
            session_destroy();
            $url = 'index.php?cred=false';
            header( "Location: $url" );
        }
    }
    if($user->isLibrarian()){
        $stmt = $pdo->prepare("UPDATE libros SET baja=1 WHERE id= :libroid");
        $stmt->bindValue(':libroid', (int) $_POST['bookId'], PDO::PARAM_INT);
        $stmt->execute();
        $url = 'index.php';
        header( "Location: $url" );
    }
?>
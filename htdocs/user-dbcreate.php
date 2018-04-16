<?php
include "connection.php";

$uploadOk = 0;

if(isset($_POST['first_name']))
{
    $nombre = $_POST['first_name'];
    if(filter_var($nombre,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/[a-zA-Z\s]+/"))))
    {
        $validfirstname = true;
        echo "Nombre correcto";
        echo "<br>";
    }
    else
    {
        $validfirstname = false;
        echo "Nombre incorrecto";
        echo "<br>";
    }
}

if(isset($_POST['last_name']))
{
    $apellido = $_POST['last_name'];
    if(filter_var($apellido,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/[a-zA-Z\s]+/"))))
    {
        $validlastname = true;
        echo "Apellido correcto";
        echo "<br>";
    }
    else
    {
        $validlastname = false;
        echo "Apellido incorrecto";
        echo "<br>";
    }
}

if(isset($_POST['emailbox']))
{
    $email = $_POST['emailbox'];
    if(filter_var($email,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>'/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD'))))
    {
        $validemail = true;
        echo "Email correcto";
        echo "<br>";
    }
    else
    {
        $validemail = false;
        echo "Email incorrecto";
        echo "<br>";
    }
}

if(isset($_POST['password'])&isset($_POST['password_confirmation']))
{
    $pass = $_POST['password'];
    $passconf = $_POST['password_confirmation'];
    if(filter_var($pass,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/.{8}+/"))))
    {
        if(filter_var($passconf,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/.{8}+/"))))
        {
            if(!strcmp($pass,$passconf))
            {
                $validpass = true;
                echo "Password correcto";
                echo "<br>";
            }
            else
            {
                $validpass = false;
                echo "Password incorrecto";
                echo "<br>";
            }

        }
        else
        {
            $validpass = false;
        }
    }
    else
    {
        $validpass = false;
    }
    
}


if(isset($_POST['picturename']))
{
    // Check if image file is a actual image or fake image
    if(1) {//isset($_POST['submit'])
        $check = getimagesize($_FILES["userpic"]["tmp_name"]);
        echo "Tipo de imagen: ";
        echo $check['mime'];
        echo "<br>";
        echo "Tamaño imagen: ";
        echo $check[3];
        echo "<br>";
        if($check != false) {
            $uploadOk = 1;
            echo "Foto correcta";
            echo "<br>";
        } else {
            $uploadOk = 0;
            echo "Foto incorrecta";
            echo "<br>";
        }
    } else {
        echo "El submit no se encuentra.";
        echo "<br>";
    }

    
    // Check file size
    if ($_FILES["userpic"]["size"] > 5000000) {
        echo "Archivo de imagen excede el limite de 5MB.";
        echo "<br>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($check['mime'] != "image/jpg" && $check['mime'] != "image/jpeg") 
    {
        echo "Perdon, solo se permiten archivos de imagen con extensión JPG y JPEG.";
        echo "<br>";
        $uploadOk = 0;
    }  
}


if (($uploadOk == 0)|(!$validpass)|(!$validemail)|(!$validfirstname)|(!$validlastname))
{
    echo "Alguno de los campos son incorrectos...";
    echo "<br>";
    // if everything is ok, try to upload file
} 
else 
{
    $sql = "INSERT INTO usuarios (email, nombre, apellido, foto, clave, rol) VALUES ( '".$email."', '".$nombre."', '" .$apellido."', '" . $_FILES["userpic"]["tmp_name"] . "', '" . $pass ."','LECTOR');";
  
    if ($connect->query($sql) === true)
    {
        echo "User creado!";
        echo "<br>";
    }
}
?>
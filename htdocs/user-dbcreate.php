<?php
include "connection.php";

if(isset($_POST['first_name']))
{
    $firstname = $_POST['first_name'];
    if(filter_var($lastname,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/[a-zA-Z\s]+/"))))
    {
        $validfirstname = true;
    }
    else
    {
        $validfirstname = false;
    }
}

if(isset($_POST['last_name']))
{
    $lastname = $_POST['last_name'];
    if(filter_var($lastname,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/[a-zA-Z\s]+/"))))
    {
        $validlastname = true;
    }
    else
    {
        $validlastname = false;
    }
}

if(isset($_POST['emailbox']))
{
    $email = $_POST['emailbox'];
    if(filter_var($lastname,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>'/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD'))))
    {
        $validemail = true;
    }
    else
    {
        $validemail = false;
    }
}

if(isset($_POST['password'])&isset($_POST['password_confirmation']))
{
    $pass = $_POST['password'];
    $passconf = $_POST['password_confirmation'];
    
}

// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES["userpic"]["tmp_name"]);
//     if($check !== false) {
//         echo "File is an image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         echo "File is not an image.";
//         $uploadOk = 0;
//     }
// }

// // Check file size
// if ($_FILES["userpic"]["size"] > 5000000) {
//     echo "Archivo de imagen excede el limite de 5MB";
//     $uploadOk = 0;
// }
// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "jpeg") 
// {
//     echo "Perdon, solo se permiten archivos de imagen con extensión JPG y JPEG.";
//     $uploadOk = 0;
// }
// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) 
// {
//     echo "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } 
// else 
// {
//     $sqluserupload = "INSERT INTO usuarios (id, email, nombre, apellido, foto, clave, rol) VALUES ('Cardinal', 'Tom B. Erichsen', 'Skagen 21', 'Stavanger', '4006', 'Norway','LECTOR');";
// }
?>
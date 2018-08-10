<!DOCTYPE html>
<?php
require_once("pdo-connect.php");

$name= isset( $_GET['name'] ) ? $_GET['name'] : "";
$lastname= isset( $_GET['lastname'] ) ? $_GET['lastname'] : "";
$email= isset($_GET['email']) ? $_GET['email'] : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
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
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
            $stmt->bindParam(':email',$email);
            $stmt->execute();
            if($stmt->rowCount()!=0){
                $url = "user-create.php?email=true&name=$nombre&lastname=$apellido";
                header( "Location: $url" );
                die("ERROR: El email ya existe.");
            }else{
                $validemail = true;
                echo "Email correcto.";
            }
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
        if(filter_var($pass,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/^((?=.*[a-z])(?=.*[A-Z]))((?=.*[-!@#$&*])|(?=.*\d)).{6,}$/"))))
        {
            if(filter_var($passconf,FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>"/^((?=.*[a-z])(?=.*[A-Z]))((?=.*[-!@#$&*])|(?=.*\d)).{6,}$/"))))
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
                echo "El password no cumple con los criterios de seguridad.";
                $validpass = false;
            }
        }
        else
        {
            echo "El password no cumple con los criterios de seguridad.";
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
        $picturefile = fopen($_FILES["userpic"]["tmp_name"],'rb');
        $stmt = $pdo->prepare('INSERT INTO usuarios (email, nombre, apellido, foto, clave, rol) VALUES (:email, :first_name, :last_name, :picture, :pass, :rol)');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':first_name', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $apellido, PDO::PARAM_STR);
        $stmt->bindValue(':picture', $picturefile, PDO::PARAM_LOB);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindValue(':rol', 'LECTOR' , PDO::PARAM_STR);
        try{
            $stmt->execute();
        } catch (PDOException $e) {
            if($e->getCode() == "23000"){
                die("ERROR: El email ya existe.");
            }else{
                die("Hubo un error al crear la cuenta");
            }
        }
        $pdo->lastInsertId();
        $_SESSION['user'] = $email;
        $_SESSION['password'] = $pass;
        $url = 'index.php?create=true';
        header( "Location: $url" );
    }
}
else{
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <title>Biblioteca UNLP - Crear Usuario</title>

        <!-- Bootstrap Core CSS -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->

        <link href="css/user-create.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.js"></script>

    </head>

    <script src="js/createuser.js"> </script>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-12">
                    <form id="signup" action="user-create.php" method="post" enctype="multipart/form-data">
                        <h2> Registrese <small> al portal de libros UNLP.</small></h2>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input value="<?=$name?>" type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Nombre" tabindex="1">
                                </div>
                            </div>
                            <div class="alert alert-danger col-xs-12 col-sm-6 col-md-6" id="alertname" role="alert" style="display:none;">
                                Nombre Inválido
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input value="<?= $lastname?>" type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Apellido" tabindex="2">
                                </div>
                            </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 alert alert-danger" id="alertlastname" role="alert" style="display:none;">
                                    Apellido Inválido
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6 col-sm-3 col-md-3">
                                <input type="text" name="picturename" id="picturename" class="form-control input-lg" placeholder="Foto de Perfil" tabindex="3">
                            </div>
                            <div class="col-xs-6 col-sm-3 col-md-3">
                                <input type="file" id="userpic" name="userpic" onchange="showFileName()" style="display: none;" data-type='image' accept="image/*"/>
                                <label for="userpic" class="btn btn-success btn-block btn-md" id="picturelabel">
                                    Examinar
                                </label>
                            </div>
                            <div class="alert alert-danger col-xs-12 col-sm-6 col-md-6" id="alertpicture" role="alert" style="display:none;">
                                Por favor inserte una imagen cuya extension sea JPEG o JPG
                            </div>
                            <!-- <div class="col-xs-6 col-sm-3 col-md-3"><a href="#" class="btn btn-success btn-block btn-md">Examinar</a></div> -->
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-md-6">
                                <input type="email" name="emailbox" id="emailbox" class="form-control input-lg" placeholder="Email" tabindex="4">
                            </div>
                            <div class="alert alert-danger col-xs-12 col-sm-6 col-md-6" id="alertemail" role="alert" style="display:none;">
                                Email Inválido
                            </div>
                            <?php if($email): ?>
                            <div class="alert alert-danger col-xs-12 col-sm-6 col-md-6" id="alertemail2" role="alert">
                                El email ya existe.
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="5">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger col-xs-24 col-sm-12 col-md-12" id="alertpass" role="alert" style="display:none;">
                                Contraseña inválida.
                                </div>
                            </div>
                        </div>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <btn id="submitbtn" class="btn btn-primary btn-block" onclick="validate()" tabindex="7">Registrar</btn>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>
<?php 
}
?>
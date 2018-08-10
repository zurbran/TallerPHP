<?php

require_once "pdo-connect.php";

class User{

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $foto;
    public $password;
    public $rol;

    public function __construct($id, $nombre, $apellido, $email, $foto, $password, $rol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->foto = $foto;
        $this->password = $password;
        $this->rol = $rol;
    }

    public static function login($email, $password, $conn)
    {
        $stmt = $conn->prepare('SELECT id, nombre, apellido, foto, rol FROM usuarios WHERE email = :email AND clave = :password');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() == 0)
        {
            throw new Exception("Email o contaseña incorrecto.");
        }
        else
        {
            $row = $stmt->fetch();
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            return new User($row['id'], $row['nombre'], $row['apellido'], $email, $row['foto'], $password, $row['rol']);
        }
    }

    public static function isLogged()
    {
        if(!(isset($_SESSION['email']))||!(isset($_SESSION['password'])))
        {
            return false;
        }

        return true;
    }

    public function isReader()
    {
        if(!User::isLogged())
            return false;

        return $this->rol == 'LECTOR';
    }

    public function isLibrarian()
    {
        if(!User::isLogged())
            return false;

        return $this->rol == 'BIBLIOTECARIO';
    }

    public function logOut()
    {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    }


}
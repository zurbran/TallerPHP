<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Biblioteca UNLP - Crear Usuario</title>

        <!-- Bootstrap Core CSS -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->

        <style>
            .colorgraph {
                height: 5px;
                border-top: 0;
                background: #c4e17f;
                border-radius: 5px;
                background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
                background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
                background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
                background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
                }
        </style>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>

            <?php
            include "connection.php";
            require_once 'paginator.class.php';

            $conn       = $connect;

            ?>
    </head>

    <script src="js/createuser.js"> </script>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-12">
                    <form role="form">
                        <h2> Registresé <small> Al portal de libros UNLP.</small></h2>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Nombre" tabindex="1">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Apellido" tabindex="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-md-6">
                                <input type="text" name="display_name" id="display_name" class="form-control input-lg" placeholder="Foto de Perfil" tabindex="3">
                            </div>
                            <div class="col-xs-12 col-md-6"><a href="#" class="btn btn-success btn-block btn-md">Examinar</a></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-24 col-sm-12 col-md-12">
                                <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="5">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6">
                                </div>
                            </div>
                        </div>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-md-12"><input type="submit" value="Registrar" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>
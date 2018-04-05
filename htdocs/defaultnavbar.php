<nav class="navbar navbar-dark navbar-expand bg-dark fixed-top toggle collapsed">

    <!-- Brand and toggle get grouped for better mobile display -->
		<a class="navbar-brand" href="#">Biblioteca UNLP</a>
	
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbarindex">
			<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
			<a class="nav-link" href="#">Políticas <span class="sr-only">(current)</span></a>
			</li>
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">¿Usuario Registrado?</p></li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><b>Iniciar Sesión</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								 <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
										<div class="form-group">
											 <label class="sr-only" for="userinputnick">Usuario</label>
											 <input type="text" class="form-control" id="userinputnick" placeholder="Usuario" required>
										</div>
										<div class="form-group">
											 <label class="sr-only" for="exampleInputPassword2">Constraseña</label>
											 <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Contraseña" required>
                                             <div class="help-block text-right"><a href="">¿Olvido su contraseña?</a></div>
										</div>
										<div class="form-group">
											 <button type="submit" class="btn btn-primary btn-block">Conectarse</button>
										</div>
										<div class="checkbox">
											 <label>
											 <input type="checkbox"> Mantener sesión inicidada
											 </label>
										</div>
								 </form>
							</div>
							<div class="bottom text-center">
								¿No tiene usuario? <a href="#"><b>Registrarse</b></a>
							</div>
					 </div>
				</li>
			</ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
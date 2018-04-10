<nav class="navbar navbar-dark navbar-expand bg-dark fixed-top ">
		<a class="navbar-brand" href="/">Biblioteca UNLP</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#indexnavbar" aria-controls="indexnavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="indexnavbar">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#">Políticas <span class="sr-only"></span></a>
				</li>
			</ul>
			<span class="navbar-text">
    		¿ Tiene usuario ?
  		</span>
			<span class="nav-item dropdown show">
			<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white; text-decoration: none;">Iniciar Sesión / Registrarse</a>
			<div class="dropdown-menu" aria-labelledby="dropdown03">
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
					<div class="bottom text-center">
					¿No tiene usuario? <a href="/user-create.php"><b>Registrarse</b></a>
					</div>
				</div>
			</div>
			</span>	
		</div>
</nav>




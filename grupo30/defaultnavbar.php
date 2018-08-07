<nav class="navbar navbar-dark navbar-expand bg-dark fixed-top ">
		<a class="navbar-brand" href="index.php">Biblioteca UNLP</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#indexnavbar" aria-controls="indexnavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="indexnavbar">
			<ul class="navbar-nav mr-auto">

			</ul>
			<?php if(isset($_GET['cred'])): ?>
				<span class="navbar-text text-danger">
				Credenciales Incorrectas!
				</span>
			<?php elseif(isset($_GET['create'])): ?>
				<span class="navbar-text text-success">
				Cuenta creada con éxito! Por favor inicie sesión:
				</span>
			<?php else:	?>
			<span class="navbar-text">
    		¿ Tiene usuario ?
  			</span>
			<?php endif ?>
			<span class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="dropdown03" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; text-decoration: none;">Iniciar Sesión / Registrarse</a>
			<div class="dropdown-menu" aria-labelledby="dropdown03">
				<div class="col-md-12">
					<form class="form" role="form" method="post" action="login.php" accept-charset="UTF-8" id="login-nav" enctype="multipart/form-data">
						<div class="form-group">
								<label class="sr-only" for="useremail">Usuario</label>
								<input type="text" class="form-control" name="useremail" id="useremail" placeholder="Usuario" required>
						</div>
						<div class="form-group">
								<label class="sr-only" for="password">Constraseña</label>
								<input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
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
					¿No tiene usuario? <a href="user-create.php"><b>Registrarse</b></a>
					</div>
				</div>
			</div>
			</span>	
		</div>
</nav>




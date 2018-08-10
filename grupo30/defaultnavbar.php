<nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
	<a class="navbar-brand" href="index.php">Biblioteca UNLP</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#indexnavbar" aria-controls="indexnavbar" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="indexnavbar">
		<ul class="navbar-nav mr-auto">
		</ul>
		<ul class="navbar-nav mr-4">
			<?php if(isset($_GET['cred'])): ?>
			<li class="nav-item">
				<a class="navbar-text text-danger" >Credenciales Incorrectas!</a>
			</li>
			<?php elseif(isset($_GET['create'])): ?>
			<li class="nav-item">
				<a class="navbar-text text-success" >Cuenta creada con éxito! Por favor inicie sesión:</a>
			</li>
			<?php else:	?>
			<li class="nav-item">
				<a class="navbar-text text-muted" >¿ Tiene usuario ?</a>
			</li>
			<?php endif ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle text-white" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Iniciar Sesión</a>
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
						</form>
						<div class="bottom text-center">
						¿No tiene usuario? <a href="user-create.php"><b>Registrarse</b></a>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>

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
    		Usuario conectado:
  		</span>
			<span class="nav-item dropdown show">
			<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white; text-decoration: none;"><?=$userData['nombre']." ".$userData['apellido']?></a>
			<div class="dropdown-menu" aria-labelledby="dropdown03">
				<a class="dropdown-item" href="/user-profile.php">Mi Perfil</a>
				<a class="dropdown-item" href="/logout.php">Cerrar Sesion</a>
			</div>
			</span>	
		</div>
</nav>
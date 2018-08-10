<nav class="navbar navbar-dark navbar-expand bg-dark fixed-top ">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#indexnavbar" aria-controls="indexnavbar" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="index.php">Biblioteca UNLP</a>

	<div class="collapse navbar-collapse" id="indexnavbar">
		<ul class="navbar-nav mr-auto">
		</ul>
		<ul class="navbar-nav mr-4">
			<li class="nav-item">
			<a class="navbar-text text-muted" >Usuario Conectado: </a>
			</li>
			<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle text-white" id="dropdown03" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$user->nombre." ".$user->apellido?></a>
				<div class="dropdown-menu" aria-labelledby="dropdown03">
					<a class="dropdown-item" href="user-profile.php">Mi Perfil</a>
					<?php if($user->isLibrarian()) : ?>
					<a class="dropdown-item" href="show-operations.php">Operaciones</a>
					<?php endif ?>
					<a class="dropdown-item" href="logout.php">Cerrar Sesion</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
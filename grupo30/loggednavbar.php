<nav class="navbar navbar-dark navbar-expand bg-dark fixed-top ">
		<a class="navbar-brand" href="index.php">Biblioteca UNLP</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#indexnavbar" aria-controls="indexnavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="indexnavbar">
			<ul class="navbar-nav mr-auto">
				
			</ul>
			<span class="navbar-text">
    		Usuario conectado:
  		</span>
			<span class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="dropdown03" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; text-decoration: none;"><?=$user->nombre." ".$user->apellido?></a>
			<div class="dropdown-menu" aria-labelledby="dropdown03">
				<a class="dropdown-item" href="user-profile.php">Mi Perfil</a>
				<?php if($user->isLibrarian()) : ?>
				<a class="dropdown-item" href="show-operations.php">Operaciones</a>
				<?php endif ?>
				<a class="dropdown-item" href="logout.php">Cerrar Sesion</a>
			</div>
			</span>	
		</div>
</nav>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Activar Barra</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PWD 2019</a>
    </div>
      <form class="navbar-form navbar-left" action="<?= SITE_ROOT ?>index.php">
        <div class="form-group">
          <input type="text" name="inputBuscarPersonas" id="inputBuscarPersonas" class="form-control" placeholder="Buscar Personas">
        </div>
        <button type="submit" name="btnBuscarPersonas" class="btn btn-default">BUSCAR</button>
      </form>    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?= SITE_ROOT ?>index.php" class="active">Listado</a></li>
        <li><a href="<?= SITE_ROOT ?>formularioPersona.php">Nueva Persona</a></li>
        <li><a href="logout.php">Usuario: <?=$_SESSION['usuario']?> // Desconectar </a></li>
      </ul>
    </div>
  </div>
</nav>
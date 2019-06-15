<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'clases/Usuario.php';
use app\clases\Usuario;


$usuario = new Usuario();


// si quitan los comentarios, se registra en el sistem el usuario jose/jose
// Nota: Recuerden que hay un índice único para el campo usuario
if(isset($_POST['boton']) && $usuario->registrarUsuario($_POST['username'], $_POST['password'])){
    echo "usuario registrado";
}else{
    echo "error al registrar usuario";
}
?>
<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" />
        <link rel="stylesheet" href="../css/style.css" />

        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script src="../js/script.js"></script>
    </head>

    <body>
        <div class="container-fluid main-content">
            <div class="">
                <div class="login-content">

                    <div class="text-center">
                        <h2>Registro de Usuario</h2>

                        <div class="alert">
                            <div>Mensaje de Error</div>
                        </div>
                    </div>
                    <div >
                        <div >
                            <form class="form-horizontal" method="POST">
                                <div class="control-group">
                                    <label class="control-label" for="username">Usuario:</label>
                                    <div class="controls">
                                        <input id="username" type="text" name="username"required/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password">Password:</label>
                                    <div class="controls">
                                        <input id="password" type="password" name="password" required/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input value="Registrarse" class="btn btn-primary" type="submit" name="boton">
                                        <a id="registerLink" href="login.php">Ir al Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>

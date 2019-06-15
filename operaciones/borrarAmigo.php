<?php
require_once '..'.DIRECTORY_SEPARATOR.'header.php';
require_once '..'.DIRECTORY_SEPARATOR.'menu.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'Amigo.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'NullObjectError.php';
use app\clases\Amigo;
use app\clases\NullObjectError;
if(isset($_GET['idAmigo']))
{
    try 
    {
        $amigo = Amigo::buscarPorId($_GET['idAmigo']);
        $mensaje = ($amigo->eliminar()===TRUE)?"Amigo: {$amigo->getApellinom()} borrado correctamente":"Ocurrió un error al intentar borrar a {$amigo->getApellinom()}";
    }catch(TypeError $e){
        $mensaje = 'Error al obtener la información del amigo en la base de datos';
    }catch(NullObjectError $e)
    {
        $mensaje = 'El amigo que se quiere borrar no existe';
    }catch(Throwable $e){
        error_log($e->getMessage());
        $mensaje = 'Error inesperado, consulte con su administrador';
    }
}else{
    $mensaje = 'No se recibió el identificador necesario para realizar la operación';
}
?>
<div>
    <?= $mensaje ?>
</div>


<?php
require_once '../footer.php';
?>
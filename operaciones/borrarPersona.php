<?php
require_once '..'.DIRECTORY_SEPARATOR.'header.php';
require_once '..'.DIRECTORY_SEPARATOR.'menu.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'Persona.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'Amigo.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'Compania.php';
require_once '..'.DIRECTORY_SEPARATOR.'clases'.DIRECTORY_SEPARATOR.'Db.php';

use app\clases\Db;
use app\clases\Amigo;
use app\clases\Persona;
use app\clases\Compania;

if(isset($_GET['idPersona']))
{
    try 
    {
        //throw new Exception('Lógica no implementada');
        // pasos para realizar la operación:
        // obtener una conexión a la bd
        $conn = Db::getConexion();
        // usar esa conexión para iniciar una transacción
        $conn->beginTransaction();
        // obtener la persona a partir del ID (línea de abajo)
        $idPers = intval($_GET['idPersona']);
        $persona = Persona::buscarPorId($idPers);
        // invocar el getCompania de persona que obtiene un objeto compania
        $cia = $persona->getCompania();
        // invocar el metodo eliminar del objeto compania obtenido
        $cia->eliminar();
        // invocar el metodo getInformacionAmigos del objeto persona para obtener un arreglo de amigos
        $listadoAmigos = $persona->getInformacionAmigos();
        // // iniciar un bucle, recorriendo el arreglo de amigos obtenido
        foreach ($listadoAmigos as $amigo)
        {
            $amigo->eliminar();
        }
        // // dentro de cada iteracion invocar el metodo eliminar del objeto amigo actual
        // una vez finalizado el bucle, eliminar la persona con e método eliminar correspondiente
        $persona->eliminar();
        // realizar el commit de la transaccion
        $conn->commit();
        $mensaje = 'Operación exitosa';
        
    }catch(TypeError $e){
        // hacer rollback de la transacción
        $mensaje = 'Error al obtener la información de la base de datos';
    }catch(NullObjectError $e)
    {
        // hacer rollback de la transaccion
        $mensaje = 'La persona que se quiere borrar no existe';
    }catch(Throwable $e){
        // hacer rollback de la transacción
        error_log($e->getMessage());
        $mensaje = 'Error inesperado, consulte con su administrador';
    }
}else{
    $mensaje = 'No se recibió el identificador necesario para borrar la persona';
}
?>
<div>
    <?= $mensaje ?>
</div>

<?php
require_once '../footer.php';
?>
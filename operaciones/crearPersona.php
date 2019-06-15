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

if(isset($_POST['btnGuardarPersona']))
{
    try 
    {
        //throw new Exception('Lógica no implementada');
        // pasos para realizar la operación:
        $conn = Db::getConexion();
        // usar esa conexión para iniciar una transacción
        $conn->beginTransaction();
        // crear una persona desde parámetros usando el método provisto
        $persona1 = Persona::crearDesdeParametros($_POST);
        // invocar el método insertar de la persona creada
        $persona1->insertar();
        // crear una instancia de compania desde parámetros usando el método provisto
        $_POST[id_persona]=$persona1->getId();
        
        //$cia1 = new Compania($_POST['nombreCia'],$_POST['direccionCia'],$persona1);
        $cia1= Compania::crearDesdeParametros($_POST);
// invocar el método insertar del objeto compania creado
        $cia1->insertar();
        // iniciar un bucle, recorriendo el arreglo de amigos
        for($i = 0;$i < count($_POST['nombreAmigo']);$i++)
        {
            $parametro[apellinom]=$_POST['nombreAmigo'][$i];
            $parametro[telefono]=$_POST['telefonoAmigo'][$i];
            $parametro[id_persona]= intval($_POST['id_persona']);
            // dentro de cada iteracion crear una instancia de objeto amigo usando el método provisto 
            $amigo= Amigo::crearDesdeParametros($parametro);
            // en la instancia de amigo creada invocar el método insertar
            $amigo->insertar();
            // código de ejemplo para mostrar el acceso a la info recibida
            //echo "Nombre: {$_POST['nombreAmigo'][$i]} - Teléfono: {$_POST['telefonoAmigo'][$i]} <br>";
        }
        // realizar el commit de la transaccion
        $conn->commit();
        $mensaje = 'Operación exitosa';
        
    }catch(TypeError $e){
        // hacer rollback de la transacción
        $mensaje = 'Error al obtener la información del amigo en la base de datos';
    }catch(Throwable $e){
        // hacer rollback de la transacción
        error_log($e->getMessage());
        $mensaje = 'Error inesperado, consulte con su administrador';
    }
}else{
    $mensaje = 'No se recibió la información necesaria para crear una persona';
}
?>
<div>
    <?= $mensaje ?>
</div>


<?php
require_once '../footer.php';
?>
<?php
declare(strict_types=1);

namespace app\clases;
use \PDO;
class Db
{
    private static $conexion;
    /**
     * Implementación del método en el patrón Singleton, este método se encarga de devolver
     * una instancia ya creada de conexión a la BD, y si no existe la crea, la guarda para los siguientes
     * pedidos, y lo devuelve.
     * 
     */
    public static function getConexion(): PDO
    {
        if(isset(self::$conexion)){
            return self::$conexion;
        }else{
            $conexion = self::nuevaConexion();
            self::$conexion = $conexion;
            return self::$conexion;
        }
        
    }
    private static function nuevaConexion(): PDO
    {
        $archivoBd = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bd'.DIRECTORY_SEPARATOR.'db.sqlite';
        $db = new PDO('sqlite:'.$archivoBd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    
    
}
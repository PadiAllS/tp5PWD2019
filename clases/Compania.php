<?php
declare(strict_types=1);

namespace app\clases;

require_once 'Db.php';
require_once 'IRegistro.php';
require_once 'NullObjectError.php';

use app\clases\Db;
use app\clases\IRegistro;
use app\clases\NullObjectError;

class Compania implements IRegistro
{
    protected $id;
    protected $idPersona;
    protected $denominacion;
    protected $direccionCia;

    /*
     * Recibe todos los parámetros para construir una persona y un empleado, de manera transparente
    */
    public function __construct($denominacion, $direccion, $idPersona, $id=null)
    {
        $this->denominacion = $denominacion;
        $this->direccionCia = $direccion;
        $this->idPersona = $idPersona;
        $this->id = $id;
    }
    
    // -------------------- Getters ----------------------
    
    public function getId():int
    {
        return $this->id;
    }

    public function getIdPersona():int
    {
        return $this->idPersona;
    }
    
    public function getDireccionCia()//:string
    {
        return $this->direccionCia;
    }

    public function getDenominacion():string
    {
        return $this->denominacion;
    }
    
    public function setId($valor)
    {
        $this->id= intval($valor);
    }
    
    
    // -------------------- Interfaz IRegistro ----------------------

    /**
     * Inserta un registro de compañia en la base, a partir de la información que está en los atributos de la instancia
     * y devuelve TRUE o FALSE dependiendo de si la operación se realizó correctamente o no
     */
    public function insertar(): bool {
        //throw new Exception('Método no implementado');
        
        $sql = 'insert into compania (denominacion, direccion, id_persona) values(:denominacion, :direccion, :idPersona)';
        $conn = Db::getConexion();
        //$conn->prepare($sql);
        $pst = $conn->prepare($sql);
        $pst->bindValue(':denominacion', $this->denominacion);
        $pst->bindValue(':idPersona', $this->idPersona);
        $pst->bindValue(':direccion', $this->direccionCia);
        $pst->execute();
        $resultados = $pst->fetch();
        if(count($resultados)===1){
            $this->setId($conn->lastInsertId());
            return true;
        }else{
            return false;
        }
    }
    
    public function actualizar(): bool {
        throw new Exception('Método no implementado');
    }
    
    public function eliminar(): bool {
    //    throw new Exception('Método no implementado');
    
        $sql='delete from compania where id = :id';
    $conn= Db::getConexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $this->id);
    $ciaArray = $stmt->execute();
//    $amigoArray = $stmt->fetch();
        // si no hay coincidencia disparo una excepción
        if ($ciaArray === FALSE) {
            throw new NullObjectError('Objeto inexistente');
        }

        return true;
    
    }
    
    public static function buscarPorId(int $id): self
    {
        $conexion = Db::getConexion();
        $stmt = $conexion->prepare('select * from compania where id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $companiaArray = $stmt->fetch();
        // si no hay coincidencia disparo una excepción
        if($companiaArray===FALSE){
            throw new NullObjectError('Objeto inexistente');
        }
        
        return new Compania($companiaArray['denominacion'], $companiaArray['direccion'], $companiaArray['id_persona'], $companiaArray['id']);
        
    }
    
    public static function buscarPorParametros(array $parametros, string $tipo='AND'):array
    {
        //throw new Exception('Método no implementado');
        $sql= 'SELECT * FROM compania WHERE true ';
        foreach ($parametros as $key => $value) {
            $sql .= " AND ". $key . "=". $value;
        }
        $conexion = Db::getConexion();
        $pst = $conexion->prepare($sql);
        $pst->execute();
        $resultados = $pst->fetchAll();
        if(count($resultados)>0){
            return $resultados;
        }else{
            return [];
        }
    }
    
    public static function crearDesdeParametros(array $parametros):self
    {
        $id = intval($parametros['id'])??null;
        $idPersona = intval($parametros['id_persona'])??null;
        $denominacion = $parametros['denominacion']??null;
        $direccion = $parametros['direccionCia']??null;
        $compania = new Compania($denominacion, $direccion, $idPersona, $id);
        return $compania;
    }
    
    // -------------------- Métodos adicionales ------------------------
    
    public function getResumen(): string
    {
        return $this->getDenominacion().' '.$this->getDireccionCia();
    }

}
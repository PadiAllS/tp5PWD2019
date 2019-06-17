<?php

declare(strict_types=1);

namespace app\clases;

require_once 'Db.php';
require_once 'IRegistro.php';
require_once 'NullObjectError.php';

use app\clases\NullObjectError;
use \Exception;
use app\clases\IRegistro;
use app\clases\Db;
use PDO;

class Amigo implements IRegistro {

    protected $id;
    protected $idPersona;
    protected $apelliNom;
    protected $telefono;

    /*
     * Recibe todos los parámetros para construir una persona y un empleado, de manera transparente
     */

    public function __construct(string $apelliNom, string $telefono, int $idPersona, int $id = null) {
        $this->apelliNom = $apelliNom;
        $this->telefono = $telefono;
        $this->idPersona = $idPersona;
        $this->id = $id;
    }

    // -------------------- Getters ----------------------

    public function getId(): int {
        return $this->id;
    }

    public function getIdPersona(): int {
        return $this->idPersona;
    }

    public function getApelliNom(): string {
        return $this->apelliNom;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setId($valor) {
        $this->id = intval($valor);
    }

    // -------------------- Interfaz IRegistro ----------------------

    /**
     * Inserta un registro de amigo en la base, a partir de la información que está en los atributos de la instancia
     * y devuelve TRUE o FALSE dependiendo de si la operación se realizó correctamente o no
     */
    public function insertar(): bool {
        //throw new Exception('Método no implementado');
        //$sql = 'INSERT INTO amigos (apellinom, telefono, id_persona) VALUES (:apellinom, :telefono, :idPersona)';
        $sql = 'insert into amigos (apellinom, telefono, id_persona) values(:apellinom, :telefono, :idPersona)';
        $conn = Db::getConexion();
        //$conn->prepare($sql);
        $pst = $conn->prepare($sql);
        $pst->bindValue(':apellinom', $this->apelliNom);
        $pst->bindValue(':idPersona', $this->idPersona);
        $pst->bindValue(':telefono', $this->telefono);
        $pst->execute();
        if ($pst->rowCount() === 1) {
            $this->setId($conn->lastInsertId());
            return true;
        } else {
            return false;
        }
    }

    public function actualizar(): bool {
        throw new Exception('Método no implementado');
    }

    public function eliminar(): bool {
//        throw new Exception('Método no implementado');
    $sql='delete from amigos where id = :id';
    $conn= Db::getConexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $this->id);
    $amigoArray = $stmt->execute();
//    $amigoArray = $stmt->fetch();
        // si no hay coincidencia disparo una excepción
        if ($amigoArray === FALSE) {
            throw new NullObjectError('Objeto inexistente');
        }

        return true;
    }

    public static function buscarPorId(int $id): self {
        $conexion = Db::getConexion();
        $stmt = $conexion->prepare('select * from amigos where id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $amigoArray = $stmt->fetch();
        // si no hay coincidencia disparo una excepción
        if ($amigoArray === FALSE) {
            throw new NullObjectError('Objeto inexistente');
        }

        return new Amigo($amigoArray['apellinom'], $amigoArray['telefono'], intval($amigoArray['id_persona']), intval($amigoArray['id']));
    }

    public static function buscarPorParametros(array $parametros, string $tipo = 'AND'): array {
//        throw new Exception('Método no implementado');
       $sql= 'SELECT * FROM amigos WHERE true ';
        foreach ($parametros as $key => $value) {
            $sql .= " AND ". $key . "=". $value;
        }
        $conexion = Db::getConexion();
        $pst = $conexion->prepare($sql);
//        $pst->bindValue(':idPersona', $this->idPersona);
        $pst->execute();
        $resultados = $pst->fetchAll();
        if(count($resultados)>0){
            return $resultados;
        }else{
            return [];
        }
    }
        
    

    public static function crearDesdeParametros(array $parametros): self {
        $id = !empty($parametros['id']) ? intval($parametros['id']): null;
        $idPersona = intval($parametros['id_persona']) ?? null;
        $apelliNom = $parametros['apellinom'] ?? null;
        $telefono = $parametros['telefono'] ?? null;
        $amigo = new Amigo($apelliNom, $telefono, $idPersona, $id);
        return $amigo;
    }

}

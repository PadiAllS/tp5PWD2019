<?php

declare(strict_types=1);

namespace app\clases;

require_once 'Db.php';
require_once 'IRegistro.php';
require_once 'Amigo.php';
require_once 'Compania.php';
require_once 'NullObjectError.php';

use \Exception;
use app\clases\NullObjectError;
use app\clases\Amigo;
use app\clases\Compania;
use app\clases\IRegistro;
use app\clases\Db;
use app\clases\SqlHelper;

class Persona implements IRegistro {

    protected $id;
    protected $nombre;
    protected $apellido;
    protected $direccion;

    public function __construct(string $nombre, string $apellido, string $direccion, int $id = null) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->id = $id;
    }

    // -------------------- Getters ----------------------
    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido(): string {
        return $this->apellido;
    }

    public function getDireccion(): string {
        return $this->direccion;
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

        $sql = 'INSERT INTO persona (nombre, apellido, direccion) values (:nombre, :apellido, :direccion)';
        $conn = Db::getConexion();
        $pst = $conn->prepare($sql);
        $pst->bindValue(':nombre', $this->nombre);
        $pst->bindValue(':apellido', $this->apellido);
        $pst->bindValue(':direccion', $this->direccion);
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

        $sql='delete from persona where id = :id';
        $conn= Db::getConexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $personaArray = $stmt->execute();
        if ($personaArray === FALSE) {
            throw new NullObjectError('Objeto inexistente');
        }

        return true;
    }

    

    public static function buscarPorId(int $id): self {
        $conexion = Db::getConexion();
        $stmt = $conexion->prepare('select * from persona where id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $personaArray = $stmt->fetch();
        // si no hay coincidencia disparo una excepción
        if ($personaArray === FALSE) {
            throw new NullObjectError('Objeto inexistente');
        }

        return new Persona($personaArray['nombre'], $personaArray['apellido'], $personaArray['direccion'], intval($personaArray['id']));
    }

    public static function buscarPorParametros(array $parametros, string $tipo = 'AND'): array {
        $sql = SqlHelper::construirConsulta('persona', $parametros, $tipo);
        $conexion = Db::getConexion();
        $pst = $conexion->prepare($sql);
        foreach($parametros as $clave => $valor){
            $pst->bindValue(":{$clave}", $valor);
        }
        $pst->execute();
        $resultados = $pst->fetchAll();
        if(count($resultados)>0){
            return $resultados;
        }else{
            return [];
        }
    }

    public static function crearDesdeParametros(array $parametros): self {
        $id = !empty($parametros['id']) ? intval($parametros['id']):null;
        $nombre = $parametros['nombre'] ?? null;
        $apellido = $parametros['apellido'] ?? null;
        $direccion = $parametros['direccion'] ?? null;
        $persona = new Persona($nombre, $apellido, $direccion, $id);
        return $persona;
    }

    // -------------------- Métodos adicionales ------------------------

    /**
     * Devuelve un array de objetos Amigo asociado a la persona actual o un array vacío en
     * caso de no tenér amigos
     */
    public function getInformacionAmigos(): array {
        // si no tengo id todavía, no puedo tener amigos
        $amigos = [];
        if (!$this->id)
            return [];
        $listaAmigos = Amigo::buscarPorParametros(['id_persona' => $this->id]);
//        if (count($listaAmigos) === 0) {
//            throw new NullObjectError('Objeto inexistente');
//        }
        foreach ($listaAmigos as $amigo) {
            $amigos[] = Amigo::crearDesdeParametros($amigo);
        }
        // como la búsqueda no es 0, es seguro devolver la posición 0
        return $amigos;
    }

    /**
     * Devuelve un de objeto Compania asociado a la persona actual o null en caso de no tener
     * completa la información
     */
    public function getCompania(): Compania {
        // si no tengo id todavía, no puedo tener compañia
        if (!$this->id)
            return null;
        // obtengo un array y devuelvo la primer ocurrencia
        $arregloCompania = Compania::buscarPorParametros(['id_persona' => $this->id]);
        // si la búsqueda no tiene resultados
        if (count($arregloCompania) === 0) {
            throw new NullObjectError('Objeto inexistente');
        }
        $compObj = Compania::crearDesdeParametros($arregloCompania[0]);
        // como la búsqueda no es 0, es seguro devolver la posición 0
        return $compObj;
    }

    public function getApellidoYNombre(): string {
        return $this->getApellido() . ', ' . $this->getNombre();
    }

    public function getResumen(): string {
        return $this->getApellidoYNombre() . ' - ' . $this->getDireccion();
    }

}

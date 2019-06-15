<?php
declare(strict_types=1);

namespace app\clases;

interface IRegistro {
    
    public function insertar(): bool;
    public function actualizar(): bool;
    public function eliminar(): bool;
    // por un problema de PHP no podemos declarar el tipo de retorno  :self
    // podría utilizarse IRegistro como tipo de retorno sin embargo
    public static function buscarPorId(int $id);
    public static function buscarPorParametros(array $parametros, string $tipo='AND'):array;
    // por un problema de PHP no podemos declarar el tipo de retorno  :self
    // podría utilizarse IRegistro como tipo de retorno sin embargo
    public static function crearDesdeParametros(array $parametros);

}
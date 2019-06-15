<?php
declare(strict_types=1);

namespace app\clases;
require_once 'Db.php';
require_once 'IRegistro.php';

use \PDO;

/**
 * Description of Usuario
 *
 * @author mariano
 */
class Usuario {
    // conexión
    /**
     *
     * @var \PDO 
     */
    protected $bd;
        
    public function __construct() {
        $this->bd = Db::getConexion();
    }
    
    public function esLoginValido(string $usuario, string $password): bool{
        $sql = 'select * from usuarios where usuario = :usuario';
        $pst = $this->bd->prepare($sql);
        $pst->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $pst->execute();
        $resultados = $pst->fetchAll();
        if(count($resultados)===1){
            return password_verify($password, $resultados[0]['password']);
        }else{
            return false;
        }
    }
    
    public function registrarUsuario(string $usuario, string $password): bool {
        $sql = 'insert into usuarios (usuario, password) values (:usuario, :password)';
        $pst = $this->bd->prepare($sql);
        $pst->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $hashPass = password_hash($password, PASSWORD_DEFAULT);
        $pst->bindValue(':password', $hashPass, PDO::PARAM_STR);
        $pst->execute();
        if($pst->rowCount()===1){
            return true;
        }else{
            return false;
        }
        
    }
    
    
}

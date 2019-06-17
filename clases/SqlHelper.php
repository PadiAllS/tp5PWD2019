<?php


namespace app\clases;

/**
 * Description of WhereHelper
 *
 * @author mariano
 */
class SqlHelper {
    
    public static function construirConsulta(string $tabla, array $parametros, string $operador): string{
        $where = '';
        
        $cantParametros = count($parametros);
        foreach($parametros as $clave => $valor){
            $where .= "`{$clave}` = :{$clave}";
            $cantParametros--;
            if($cantParametros){
                $where .= " {$operador} ";
            }
        }
        
        $sql= "SELECT * FROM {$tabla}";
        $sql = ($where)?($sql.' WHERE '.$where):$sql;
        
        return $sql;

    }
}

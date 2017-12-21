<?php
namespace app\models;

class Utilidades {

        // Método estático para no tener que crear una instancia
        public static function sum($a, $B){
                return $a + $b;
        }
        
          /********************************************************************* VERIFICACION DE ACCESOS*********************************************/      
    public static function verificar_acceso($r, $rt)
    {                
        $rol = $r;
        $ruta = $rt;
        
        $query_ruta = \app\models\Ruta::find()->where(['ruta'=>$ruta])->asArray()->one();
        $ruta_id=$query_ruta['id'];
        $query= \app\models\Asignacion::find()->where(['role_id'=>$rol, 'ruta_id'=>$ruta_id])->asArray()->one();
        
//        echo('Rol: ');print_r($rol); echo('<br>');
//        echo('Ruta actual: ');print_r($ruta); echo('<br>');
//        echo('Ruta_id: ');print_r($ruta_id); echo('<br>');
//        echo('Query: ');print_r($query); echo('<br>');
//        die();
        
        if(!empty($query)){            
            return 1;
        }
        else{
            return 0;
        }        
    }
        
}
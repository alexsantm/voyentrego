<?php
namespace app\modules\api\models;

class Auth {
    public static function strip_tags_deep($value) {
//        return is_array($value) ?  array_map('strip_tags_deep', $value) : strip_tags($value);
        return is_array($value) ?  array_map( array( '__CLASS__', 'methodName' ), $value ) : strip_tags($value);
    }
    
public static function array_map_r( $func, $arr )
{
    $newArr = array();
    foreach( $arr as $key => $value )
    {
        $newArr[ $key ] = ( is_array( $value ) ? array_map_r( $func, $value ) : ( is_array($func) ? call_user_func_array($func, $value) : $func( $value ) ) );
    }
    return $newArr;
}

public static function strip($string, $allowed_tags = NULL)
{
    if (is_array($string))
    {
        foreach ($string as $k => $v)
        {
            $string[$k] = strip($v, $allowed_tags);
        }
        return $string;
    }

    return strip_tags($string, $allowed_tags);
}

    public static function getUser()
    {
        // get and store user
        if ($this->user === false) {
            $user = $this->module->model("User");
            $this->user = $user::findOne(["email" => $this->email]);
        }
        return $this->user;
    }
    
    public static function validateEmail()
    {
        // check for valid user
        $this->user = $this->getUser();
        if (!$this->user) {
            $this->addError("email", Yii::t("user", "Email not found"));
        }
    }
    
    public static function validatoken($user_id, $token)
    {
        // check for valid user
        $token_id = $token;
        $user_id_validar = $user_id;
        $query = \app\models\ApiToken::find()->where(['token'=>$token_id])->andWhere(['user_id'=>$user_id_validar])->asArray()->count();        
        if ($query>0) {
            return 1;
        }
        else{
            return 0;
        }
    }
    
        public static function calificacionultimoenvio($user_id)
    {
        // check for valid user
        
        $user_id = $user_id;
        $connection = \Yii::$app->getDb();
        $command = $connection->createCommand('select calificacion from calificacion where envio_id = (SELECT id FROM envio '
                . 'WHERE fecha_registro = (SELECT MAX(fecha_registro) from envio where mensajero_id ='.$user_id.')'
                . ' and  mensajero_id = '.$user_id.')');
        $result = $command->queryScalar();
        //print_r($result); die();       
        return $result;
    }
    
         public static function calificacionultimasemana($user_id)
    {
        // check for valid user
        
        $user_id = $user_id;
        $connection = \Yii::$app->getDb();
        $week = date("W");
    for($i=0; $i<7; $i++){
        $fechas []= date('Y-m-d', strtotime('01/01 +' . ($week - 1) . ' weeks first day +' . $i . ' day'));
    }
    $fecha_inicio = array_shift($fechas);
    $fecha_final = array_pop($fechas);

     $command1 = $connection->createCommand('select
                avg(c.calificacion)
                from
                calificacion c, envio e
                where
                c.envio_id = e.id
                and e.fecha_registro between '."'".$fecha_inicio."'".' and '."'".$fecha_final."'".'
                and c.mensajero_id = '.$user_id.'');
        $resultado = $command1->queryScalar();
        return $resultado;
//        print_r($resultado); die();
    }
    
        public static function calificacionultimomes($user_id)
    {
        // check for valid user        
        $user_id = $user_id;
        $connection = \Yii::$app->getDb();
        $mes = date("m");
        $command = $connection->createCommand('select
                avg(c.calificacion)
                from
                calificacion c, envio e
                where
                c.envio_id = e.id
                and month(e.fecha_registro) = '.$mes.'
                and c.mensajero_id = '.$user_id.'');
        $resultado = $command->queryScalar();
        return $resultado;
    }
    
            public static function calificaciontotal($user_id)
    {
        // check for valid user        
        $user_id = $user_id;
        $connection = \Yii::$app->getDb();
//        $mes = date("m");
        $command = $connection->createCommand('select
                avg(c.calificacion)
                from
                calificacion c, envio e
                where
                c.mensajero_id = '.$user_id.'');
        $resultado = $command->queryScalar();
        return $resultado;
    }
    
    
    
//    public static function desencriptar($cadena){
//     $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
//     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
//    return $decrypted;  //Devuelve el string desencriptado
//}

}

//array_map( array( 'ClassName', 'methodName' ), $array );
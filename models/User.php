<?php

namespace app\models;

//class User extends \yii\base\Object implements \yii\web\IdentityInterface
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    
    /**************************************************************************************************************************/
    
    
    
    /*************************************************** MENSAJERO ***********************************************************************/
    public function calificacion_mensual_mensajero($id_mens){
        $id_mensajero = $id_mens;
        $mes_actual = date("m");
        $sql = "SELECT avg(c.calificacion) as calificacion, count(c.calificacion) as contador
                    from calificacion c, envio e
                    where
                    e.id = c.envio_id and
                    c.mensajero_id = $id_mensajero and
                    month(e.fecha_fin_envio)=$mes_actual";
                    $data = \Yii::$app->getDb()
                    ->createCommand($sql)
                    ->queryOne();
                    $suma_calificacion = $data['calificacion'];
                    $contador = $data['contador'];
                    if(!empty($suma_calificacion)){
                        //return $calificacion_mes = $suma_calificacion/$contador;
                        return $calificacion_mes = $suma_calificacion;
                    }
                    else{
                        return $calificacion_mes = 0;
                    }        
    }
    
      public function calificacion_mes_anterior_mensajero($id_mens){
        $id_mensajero = $id_mens;
        $mes_anterior = date("m") -1;
        $sql = "SELECT avg(c.calificacion) as calificacion, count(c.calificacion) as contador
                    from calificacion c, envio e
                    where
                    e.id = c.envio_id and
                    c.mensajero_id = $id_mensajero and
                    month(e.fecha_fin_envio)=$mes_anterior";
                    $data = \Yii::$app->getDb()
                    ->createCommand($sql)
                    ->queryOne();
                    $suma_calificacion = $data['calificacion'];
                    $contador = $data['contador'];
                    if(!empty($suma_calificacion)){
                        //return $calificacion_mes = $suma_calificacion/$contador;
                        return $calificacion_mes = $suma_calificacion;
                    }
                    else{
                        return $calificacion_mes = 0;
                    }        
    }
    
        public function envios_asignados_hoy_mensajero($id_mens){
        $id_mensajero = $id_mens;    
        $hoy = date("Y-m-d");
        $query = Envio::find()
                ->where(['mensajero_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>2])
                ->andWhere(['DATE_FORMAT(fecha_registro, "%Y-%m-%d")'=>$hoy])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
    public function envios_asignados_mes_mensajero($id_mens){
        $id_mensajero = $id_mens;    
        $mes_actual = date("m");
        $query = Envio::find()
                ->where(['mensajero_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>2])
                ->andWhere(['month(fecha_registro)'=>$mes_actual])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
    public function envios_exitosos_mes_mensajero($id_mens){
        $id_mensajero = $id_mens;    
        $mes_actual = date("m");
        $query = Envio::find()
                ->where(['mensajero_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>3])
                ->andWhere(['month(fecha_registro)'=>$mes_actual])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
       public function favoritismo($id_mens){
        $id_mensajero = $id_mens;    
        $query = Favoritos::find()
                ->where(['mensajero_id'=> $id_mensajero])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
    
    /*************************************************** USUARIO ***********************************************************************/
    
    public function envios_inicializados_hoy_usuario($id_mens){
        $id_mensajero = $id_mens;    
        $hoy = date("Y-m-d");
        $query = Envio::find()
                ->where(['user_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>1])
                ->andWhere(['DATE_FORMAT(fecha_registro, "%Y-%m-%d")'=>$hoy])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
    
    public function envios_pendientes_hoy_usuario($id_mens){
        $id_mensajero = $id_mens;    
        $hoy = date("Y-m-d");
        $query = Envio::find()
                ->where(['user_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>2])
                ->andWhere(['DATE_FORMAT(fecha_registro, "%Y-%m-%d")'=>$hoy])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
    public function envios_finalizados_hoy_usuario($id_mens){
        $id_mensajero = $id_mens;    
        $hoy = date("Y-m-d");
        $query = Envio::find()
                ->where(['user_id'=> $id_mensajero])
                ->andWhere(['estado_envio_id'=>3])
                ->andWhere(['DATE_FORMAT(fecha_registro, "%Y-%m-%d")'=>$hoy])
                ->count();

                    if(!empty($query)){
                        return $query;
                    }
                    else{
                        return $query = 0;
                    }        
    }
    
}

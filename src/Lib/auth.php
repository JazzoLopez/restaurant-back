<?php

namespace App\Lib;
use Exception;

class Auth {
    private $db=null;
    private static $secret_key='';
    private static $encrypt=array('');
    private static $aud=null;
    private static $minutes=172800;

    private static function Aud(){
        $aud='';
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $aud=$_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $aud=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $aud=$_SERVER['REMOTE_ADDR'];
        }
        $aud.=@$_SERVER['HTTP_USER_AGENT'];
        $aud.=gethostname();

        return sha1($aud);
    }

    public static function addToken($user_id){
        $time=time();
        $tokeninf=[
            'exp' => $time+(60*self::$minutes),
            'aud' => self::Aud(),
            'user_id' => $user_id
        ];
        $token=json_encode($tokeninf);
        return base64_encode($token);
    }
    public static function tokRecPass($data){
        $time=time();

        $tokeninf=array(
            'exp'=>$time+((60*60)*24),
            'aud'=>self::Aud(),
            'data'=>$data
        );
        $token=json_encode($tokeninf);
        return base64_encode($token);
    }

    public static function TokReg($data){
        $time=time();
        $tokeninf=array(
            'exp'=>$time+(60*60),
            'aud'=>self::Aud(),
            'data'=>$data
        );

        $token=json_encode($tokeninf);
        return base64_encode($token);

    }

   

    public static function decData($token){
        $data=self::decode64($token);
        if($data){
            return $data->data;
        }else{
            return null;
        }
    }

    public static function validateToken($token){
        if(empty($token)||$token == NULL) {
            //throw new Exception("Invalid token supplied.");
            return false;
        }
        $decode = self::decode64($token);
        // var_dump($decode);
        if ($decode === NULL) {
            //throw new Exception("Token no exist");
            return false;
        }
        // var_dump($validate);
        if ($decode->exp <= time()) {
            //throw new Exception("Token Expired");
            return false;
        }
        //if($decode->aud !== self::Aud()) {
           // throw new Exception("Invalid user logged in.");
        //}
        return true;
    }

   

    private static function decode64($token){
        $data=base64_decode($token);
        $data=json_decode($data);
        return $data;
    }

    public static function obtenerIP() {
        $ip = '';
    
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    
        return $ip;
    }

}
<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Doctrine\ORM\EntityManagerInterface;

class JwtAuth{
    public $manager;
    public $key;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
        $this->key = 'holaquetalsoylaclavesecreta987654321';
    }

    public function signup($email,$password,$getHash = null){
        $user = $this->manager->getRepository('BackBundle:Users')->findOneBy([
            "email"    => $email,
            "password" => $password
            ]);
        
        $signup = false;
        if(is_object($user)){
            $signup = true;
        }
        
        if($signup == true){
            //GENERAR TOKEN JWT
            
            $token = [
                "sub"     => $user->getId(),
                "email"   => $user->getEmail(),
                "name"    => $user->getName(),
                "surname" => $user->getSurname(),
                "iat"     => time(),
                "exp"     => time() + (7 * 24 * 60 * 60)
                ];
            
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            $decoded_array = (array) $decoded;
            
            if($getHash != null){
                $data = $jwt;
            }else{
                $data = $decoded_array;
            }          
        }else{
            $data = [
                "status" => 'Error',
                "data"   => 'Login fallido'
                ];
        }
        
        return $data;
    }
    
    public function checkToken($jwt,$getIdentity = false){
        $auth = false;
        
        try{
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch (\DomainException $e){
            $auth = false;
        }
        
        if(isset($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }
        
        if($getIdentity == false){
            return $auth;
        }else{
            return $decoded;
        }
    }
}

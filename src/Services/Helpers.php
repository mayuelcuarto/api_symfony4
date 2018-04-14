<?php

namespace App\Services;

class Helpers{
    public $manager;
    
    public function __construct(\Doctrine\ORM\EntityManagerInterface $manager) {
        $this->manager = $manager;
    }
    
    public function json($data){
        $normalizers = [new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer()];
        $encoders = ["json" => new \Symfony\Component\Serializer\Encoder\JsonEncoder];
        
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers,$encoders);
        $json = $serializer->serialize($data, 'json');
        
        $response = new \Symfony\Component\HttpFoundation\Response;
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}

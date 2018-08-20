<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class Helpers{
    public $manager;
    
    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }
    
    public function json($data){
        $normalizers = [new Normalizer\GetSetMethodNormalizer()];
        $encoders = ["json" => new JsonEncoder()];
        
        $serializer = new Serializer($normalizers,$encoders);
        $json = $serializer->serialize($data, 'json');
        
        $response = new Response;
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}

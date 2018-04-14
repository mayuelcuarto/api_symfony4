<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Helpers;
use App\Services\JwtAuth;

class DefaultController extends Controller {

    /**
     * @Route("/index", name="index")
     */
    
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/login", name="login")
     */

    public function loginAction(Request $request) {
        $helpers = $this->container->get(Helpers::class);

        // Recibir json por POST
        $json = $request->get('json', null);

        //Array a devolver por defecto
        $data = [
            'status' => 'Error',
            'data' => 'Send json via POST'
        ];

        if ($json != null) {
            // Me haces el login
            //Convertimos un json a un objeto de PHP
            $params = json_decode($json);

            $email = (isset($params->email)) ? $params->email : null;
            $password = (isset($params->password)) ? $params->password : null;
            $getHash = (isset($params->getHash)) ? $params->getHash : null;

            $emailConstraint = new Assert\Email();
            $emailConstraint->message = "Este email no es válido";
            $validate_email = $this->get("validator")->validate($email, $emailConstraint);

            //Cifrar password
            $pwd = hash('sha256', $password);

            if (count($validate_email) == 0 && $password != null) {

                $jwt_auth = $this->container->get(JwtAuth::class);

                if ($getHash == null || $getHash == false) {
                    $signup = $jwt_auth->signup($email, $pwd);
                } else {
                    $signup = $jwt_auth->signup($email, $pwd, true);
                }

                return $this->json($signup);
            } else {
                $data = ['status' => 'Error',
                    'data' => 'Email o Password incorrecto'
                    ];
            }
        }
        return $helpers->json($data);
    }
    
    /**
     * @Route("/pruebas", name="pruebas")
     */

    public function pruebasAction(Request $request) {
        $helpers = $this->container->get(Helpers::class);
        $jwt_auth = $this->container->get(JwtAuth::class);
        $token = $request->get('authorization', null);

        if ($token && $jwt_auth->checkToken($token) == true) {
            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository('BackBundle:Users');
            $users = $userRepo->findAll();

            return $helpers->json([
                        'status' => 'Success',
                        'users' => $users
            ]);
        } else {
            return $helpers->json([
                        'status' => 'Error',
                        'code' => 400,
                        'users' => 'Autorización no válida'
            ]);
        }
    }
    
    /**
     * @Route("/usuario/{id}", name="usuario")
     */

    public function usuarioAction(Request $request, $id = null) {
        $helpers = $this->container->get(Helpers::class);
        $jwt_auth = $this->container->get(JwtAuth::class);
        $token = $request->get('authorization', null);

        if ($token && $jwt_auth->checkToken($token) == true) {
            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository('BackBundle:Users');
            $user = $userRepo->findOneBy(array(
                "id" => $id
            ));

            return $helpers->json([
                        'status' => 'Success',
                        'user' => $user
            ]);
        } else {
            return $helpers->json([
                        'status' => 'Error',
                        'code' => 400,
                        'users' => 'Autorización no válida'
            ]);
        }
    }

}

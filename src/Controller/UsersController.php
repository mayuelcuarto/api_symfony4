<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Annotation\Route;
use App\BackBundle\Entity\Users;
use App\Services\Helpers;
use App\Services\JwtAuth;

class UsersController extends Controller {

    /**
     * @Route("/user/new", name="userNew")
     */
    public function newAction(Request $request) {
        $helpers = $this->container->get(Helpers::class);

        $json = $request->get('json', null);
        $params = json_decode($json);

        $data = [
            "status" => "Error",
            "code" => 400,
            "msg" => "Usuario no creado !!"
        ];

        if ($json != null) {
            $createdAt = new \DateTime("now");
            $role = "user";

            $email = (isset($params->email)) ? $params->email : null;
            $name = (isset($params->name)) ? $params->name : null;
            $surname = (isset($params->surname)) ? $params->surname : null;
            $password = (isset($params->password)) ? $params->password : null;

            $emailConstraint = new Assert\Email;
            $emailConstraint->message = "Este email no es válido!!";
            $validate_email = $this->get("validator")->validate($email, $emailConstraint);

            if ($email != null && count($validate_email) == 0 && $password != null && $name != null & $surname != null) {
                $user = new Users();
                $user->setCreatedAt($createdAt);
                $user->setRole($role);
                $user->setEmail($email);
                $user->setName($name);
                $user->setSurname($surname);

                //Cifrar password
                $pwd = hash('sha256', $password);

                $user->setPassword($pwd);

                $em = $this->getDoctrine()->getManager();
                $isset_user = $em->getRepository('BackBundle:Users')->findBy(["email" => $email]);

                if (count($isset_user) == 0) {
                    $em->persist($user);
                    $em->flush();

                    $data = [
                        "status" => "Success",
                        "code" => 200,
                        "msg" => "Nuevo Usuario creado !!",
                        "user" => $user
                    ];
                } else {
                    $data = [
                        "status" => "Error",
                        "code" => 400,
                        "msg" => "Usuario no creado, duplicado !!"
                    ];
                }
            }
        }

        return $helpers->json($data);
    }

    /**
     * @Route("/user/edit", name="userEdit")
     */
    public function editAction(Request $request) {
        $helpers = $this->container->get(Helpers::class);
        $jwt_auth = $this->container->get(JwtAuth::class);

        $token = $request->get('authorization', null);
        $authCheck = $jwt_auth->checkToken($token);

        if ($authCheck == true) {
            //Entity manager
            $em = $this->getDoctrine()->getManager();

            //Conseguir los datos del usuario identificado via token
            $identity = $jwt_auth->checkToken($token, true);

            //Conseguir el objeto a actualizar
            $user = $em->getRepository('BackBundle:Users')->findOneBy(array(
                "id" => $identity->sub
            ));

            //Recoger datos post
            $json = $request->get('json', null);
            $params = json_decode($json);

            //Array de error por defecto
            $data = [
                "status" => "Error",
                "code" => 400,
                "msg" => "Usuario no actualizado !!"
                ];

            if ($json != null) {
                //$createdAt = new \DateTime("now");
                $role = "user";

                $email = (isset($params->email)) ? $params->email : null;
                $name = (isset($params->name)) ? $params->name : null;
                $surname = (isset($params->surname)) ? $params->surname : null;
                $password = (isset($params->password)) ? $params->password : null;

                $emailConstraint = new Assert\Email;
                $emailConstraint->message = "Este email no es válido!!";
                $validate_email = $this->get("validator")->validate($email, $emailConstraint);

                if ($email != null && count($validate_email) == 0 && $name != null & $surname != null) {
                    //$user->setCreatedAt($createdAt);
                    $user->setRole($role);
                    $user->setEmail($email);
                    $user->setName($name);
                    $user->setSurname($surname);

                    //Cifrar password
                    if ($password != null) {
                        $pwd = hash('sha256', $password);
                        $user->setPassword($pwd);
                    }

                    $isset_user = $em->getRepository('BackBundle:Users')->findBy(array(
                        "email" => $email
                    ));

                    if (count($isset_user) == 0 || $identity->email == $email) {
                        $em->persist($user);
                        $em->flush();

                        $data = [
                            "status" => "Success",
                            "code" => 200,
                            "msg" => "Usuario actualizado !!",
                            "user" => $user
                            ];
                    } else {
                        $data = [
                            "status" => "Error",
                            "code" => 400,
                            "msg" => "Usuario no actualizado, duplicado !!"
                            ];
                    }
                }
            }
        } else {
            $data = [
                "status" => "Error",
                "code" => 400,
                "msg" => "Autorización no Válida !!"
                ];
        }

        return $helpers->json($data);
    }

}

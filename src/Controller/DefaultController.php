<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/admin/login", name="login" )
     * @Template("default/login.html.twig")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return array
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return [
            'error' => $error,
            'last_username' => $lastUsername
        ];
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {

        $texto = "Esse usuário não é admin.";

        if ($this->isGranted('ROLE_ADMIN')) {
            $texto = "Esse usuário é um Administrador!";
        }
        return [
            'texto' => $texto
        ];
    }

    /**
     * @param Request $request
     * @Route("/insert")
     * @return Response
     */
    public function insert(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername("carlos");
        $user->setRoles("Role_ADMINISTRADOR");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "aaa");
        $user->setPassword($pass);
        $em->persist($user);

        $user = new User();
        $user->setUsername("Roberto");
        $user->setRoles("Role_GERENTE");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "bbb");
        $user->setPassword($pass);
        $em->persist($user);

        $user = new User();
        $user->setUsername("Mario");
        $user->setRoles("Role_OPERADOR");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "ccc");
        $user->setPassword($pass);
        $em->persist($user);

        $em->flush();

        return new Response("<h1>Inserido com sucesso!</h1>");
    }
}



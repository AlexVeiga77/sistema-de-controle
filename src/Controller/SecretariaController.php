<?php

namespace App\Controller;

use App\Entity\Secretaria;
use App\Form\SecretariaType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecretariaController extends Controller
{
    /**
     * @Route("/secretaria", name="listar_secretaria")
     * @Template ("secretaria/index.html.twig")
     *
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $secretarias = $em->getRepository(Secretaria::class)->findAll();
        return [
            'secretarias' => $secretarias
        ];
    }
    /**
     * @param Request $request
     * @Route ("/secretaria/cadastrar", name="cadastrar_secretaria")
     * @Template ("secretaria/create.html.twig")
     * @return Response
     */
    public function create(Request $request)
    {
        $secretaria = new Secretaria();
        $form = $this->createForm(SecretariaType::class, $secretaria);
        $form->handleRequest($request); //para fazer a validação pelo validator tem q tratar da requisição
        //processo para salvar. Veja abaixo - persistência
        if ($form->isSubmitted() && $form->isValid()) { //enviado e válido
            $em = $this->getDoctrine()->getManager();
            $em->persist($secretaria);
            $em->flush();
            //$this->get('session')->getFlashBag()->set('success', 'produto foi salvo com sucesso'); //passar no index
            $this->addFlash('success', 'secretaria foi salvo com sucesso');
            return $this->redirectToRoute('listar_secretaria');
        }
        return [
            'form' => $form->createView()
        ];
    }
    /**
     * @param Request $request
     * @Route ("/secretaria/editar/{id}", name="editar_secretaria")
     * @Template("secretaria/update.html.twig")
     * @return array
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $secretaria = $em->getRepository(Secretaria::class)->find($id);
        $form = $this->createForm(SecretariaType::class, $secretaria);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($secretaria);
            $em->flush();
            $this->addFlash('success', 'cadastro feito com sucesso');
            return $this->redirectToRoute('listar_secretaria');
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @Route ("secretaria/visualizar/{id}", name="visualizar_secretaria")
     * @Template ("secretaria/view.html.twig")
     * @return Response
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $secretaria = $em->getRepository(Secretaria::class)->find($id);
        return [
            'secretaria' => $secretaria
        ];
    }
}

<?php

namespace App\Controller;

use App\Entity\Funcionario;
use App\Entity\Secretaria;
use App\Form\CreateFuncType;
use App\Form\FuncionarioType;
use Symfony\Component\HttpFoundation;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\FuncionarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class FuncionarioController extends Controller
{
    /**
     * @Route("/funcional", name="listar_funcionario")
     * @Template("funcional/index.html.twig")
     */
    public function index(Request $request)
    {
        $funcionarios = new Funcionario();
        $form = $this->createForm(FuncionarioType::class, $funcionarios);
        $em = $this->getDoctrine()->getManager();
        $funcionarios = $em->getRepository(Funcionario::class)->findAll();
        $form->handleRequest($request);
        return [
            'funcionarios' => $funcionarios,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @Route ("/funcional/cadastrar", name="cadastrar_funcionario")
     * @Template("funcional/create.html.twig")
     * @return array
     */
    public function create(Request $request)
    {
        $funcionario = new Funcionario();
        $form = $this->createForm(CreateFuncType::class, $funcionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $funcionario->getImagemDocumento();
            $fileName = md5(time()) . "." . $file->guessExtension(); //gerando um nome único
            $file->move(
                $this->getParameter('caminho_file'),
                $fileName);
            $funcionario->setImagemDocumento($fileName);
            $funcionario->calculoLiquido();
            $em = $this->getDoctrine()->getManager();
            $em->persist($funcionario);
            $em->flush();


            $this->addFlash('success', 'cadastro feito com sucesso');

            return $this->redirectToRoute('listar_funcionario');
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @Route ("funcionario/visualizar/{id}", name="visualizar_funcionario")
     * @Template ("funcional/view.html.twig")
     * @return Response
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $funcionario = $em->getRepository(Funcionario::class)->find($id);
        return [
            'funcionario' => $funcionario
        ];
    }

    /**
     * @param Request $request
     * @Route ("/funcional/editar/{id}", name="editar_funcionario")
     * @Template("funcional/update.html.twig")
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $funcionario = new Funcionario();
        $em = $this->getDoctrine()->getManager();
        $funcionario = $em->getRepository(Funcionario::class)->find($id);
        $form = $this->createForm(FuncionarioType::class, $funcionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $funcionario->getImagemDocumento();
            $fileName = md5(time()) . "." . $file->guessExtension(); //gerando um nome único
            $file->move(
                $this->getParameter('caminho_file'),
                $fileName);
            $funcionario->setImagemDocumento($fileName);
            //$em = $this->getDoctrine()->getManager();
            $funcionario->calculoLiquido();
            $em->persist($funcionario);
            $em->flush();

            $this->addFlash('success', 'alteração feita com sucesso');
            return $this->redirectToRoute('listar_funcionario');
        }
        return [
            'funcionario' => $funcionario,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @Route ("funcionario/apagar/{id}", name="deletar_funcionario")
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $funcionario = $em->getRepository(Funcionario::class)->find($id);
        if (!$funcionario) {
            $mensagem = "Funcionario não foi encontrado";
            $tipo = "warning";
        } else {
            $em->remove($funcionario);
            $em->flush();
            $mensagem = "Funcionario excluído com sucesso!!!";
            $tipo = "success";
        }
        $this->get('session')->getFlashBag()->set($tipo, $mensagem);
        return $this->redirectToRoute("listar_funcionario");
    }

}


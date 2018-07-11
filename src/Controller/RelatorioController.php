<?php

namespace App\Controller;

use App\Entity\Secretaria;
use App\Enum\FuncionarioStatusEnum;
use App\Form\RelatorioSecretariaType;
use App\Form\RelatorioType;
use App\Repository\FuncionarioRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;


require __DIR__ . '/../../vendor/autoload.php';


class RelatorioController extends Controller
{
    /**
     * @Route("/relatorio", name="relatorio")
     */
    public function index()
    {
        return $this->render('relatorio/index.html.twig', [
            'controller_name' => 'RelatorioController',
        ]);
    }

    /**
     * @param Request $request
     * @Route("/relatorio/funcional", name="relatorio_funcionario")
     * @return Response
     */
    public function relatorioFuncionario(Request $request, FuncionarioRepository $funcionarioRepository)
    {

        $funcionarios = [];
        $form = $this->createForm(RelatorioType::class, $funcionarios);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $funcionarios = $funcionarioRepository->getFuncionarioPorData(
                $data['data_inicio'],
                $data['data_fim'],
                $data['status']
            );

            $pdfClicked = $form->get('pdf')->isClicked();

            if ($pdfClicked) {
                return $this->funcionarioPdf($funcionarios);
            }

            $excelClicked = $form->get('excel')->isClicked();

            if ($excelClicked) {
                $plan = $this->funcionarioXls($funcionarios);

                return new Response(
                    $plan, 200,
                    array(
                        'Content-Type' => 'application/vnd.ms-excel',
                        'Content-Disposition'
                        => 'attachment; filename="myfile.xlsx"',
                    )
                );

            }

        }

        return $this->render('relatorio/funcional.html.twig',
            ['funcionarios' => $funcionarios,
                'form' => $form->createView()]
        );
    }

    /**
     * @param $funcionarios
     * @return mixed
     * @Route ("relatorio/funcional_pdf" , name="funcionario_pdf")
     * @Template ("relatorio/funcional_pdf.html.twig")
     */
    private function funcionarioPdf($funcionarios)
    {
        $view = $this->renderView('relatorio/funcional_pdf.html.twig', [
            'funcionarios' => $funcionarios
        ]);

        $domPdf = new Dompdf();
        $domPdf->loadHtml($view);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();
        return $domPdf->stream('relatorio_funcionario');
    }

    /**
     * @Route("/relatorio/funcional_xls", name="relatorio_xls")
     *
     */
    private function funcionarioXls($funcionarios)
    {
        $spreadsheet = new Spreadsheet(); //instanciando uma nova planilha

        $total = $funcionarios;

        $plan = $spreadsheet->getActiveSheet(); //retornando a aba ativa

        $plan->setCellValue('A1', 'Mat.');
        $plan->setCellValue('B1', 'Nome');
        $plan->setCellValue('C1', 'Cargo');
        $plan->setCellValue('D1', 'Status');
        $plan->setCellValue('E1', 'Data de admissao');
        $plan->setCellValue('F1', 'Data de exoneração');

        $contador = 1;

        foreach ($total as $linha) {

            $contador++;

            $plan->setCellValue('A' . $contador, $linha->getId());
            $plan->setCellValue('B' . $contador, $linha->getNome());
            $plan->setCellValue('C' . $contador, $linha->getCargo());
            $plan->setCellValue('D' . $contador, $linha->getStatus());
            $plan->setCellValue('E' . $contador, $linha->getDataAdmissao());
            $plan->setCellValue('F' . $contador, $linha->getDataExoneracao());

        }

        $writer = new Xlsx ($spreadsheet);
        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
    }

    /**
     * @param Request $request
     *
     * @Route("/relatorio/secretaria",name="relatorio_secretaria")
     * @Template("relatorio/secretaria.html.twig")
     * @return Response
     */
    public function relatorioSecretaria(Request $request, FuncionarioRepository $funcionarioRepository)
    {
        return $this->render(
            'relatorio/secretaria.html.twig',
            ['totalSalariosLiquido' => $funcionarioRepository->salarioTotal()]
        );
    }

    /**
     * @Route("/relatorio/secretaria_pdf", name="secretaria_pdf")
     */
    public function secretariaPdf(Request $request, FuncionarioRepository $funcionarioRepository)
    {

        $view = $this->renderView(
            'relatorio/secretaria_pdf.html.twig',
            ['totalSalariosLiquido' => $funcionarioRepository->salarioTotal()]
        );
        $domPdf = new Dompdf();
        $domPdf->loadHtml($view);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();
        return $domPdf->stream("Relatório_Secretaria.pdf");
    }

}
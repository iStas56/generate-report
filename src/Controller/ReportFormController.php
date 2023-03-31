<?php

namespace App\Controller;

use App\Service\EvoTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ReportForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportFormController extends AbstractController
{
    private $evoTaskService;
    public function __construct(EvoTaskService $evoTaskService)
    {
        $this->evoTaskService = $evoTaskService;
    }
    public function handleForm(Request $request): Response
    {
        $form = $this->createForm(ReportForm::class);
        $form->handleRequest($request);

        // при успешной отправки формы загружет страницу с отчетом
        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();

            $taskData = $this->evoTaskService->getTasksData($formData);

            return $this->render('report/report.html.twig', [
                'data' => $taskData
            ]);
        }

        // изначально отрисовывается страница с формой для заполнения
        return $this->render('report/report-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
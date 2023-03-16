<?php

namespace App\Controller;

use App\Service\EvoTaskService;
use App\Service\GenerateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends AbstractController
{
    private $evoTaskService;
    public function __construct(EvoTaskService $evoTaskService)
    {
        $this->evoTaskService = $evoTaskService;
    }

    public function createReport(int $userId, int $bet)
    {
        $data = $this->evoTaskService->getTasksData($userId, $bet);

        return $this->render('report/report.html.twig', [
            'data' => $data
        ]);
    }
}
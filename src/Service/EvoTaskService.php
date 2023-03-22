<?php

namespace App\Service;

use morphos\Gender;
use morphos\Russian\CardinalNumeralGenerator;
use Symfony\Component\HttpClient\HttpClient;

class EvoTaskService
{
    private $apiHttpService;
    private $startDate;
    private $emdDate;
    private $userId;
    private $token;
    private $bet;

    private array $params;

    public function __construct(ApiHttpService $apiHttpService)
    {
        $this->apiHttpService = $apiHttpService;
    }

    public function init(array $formData)
    {
        $this->userId = $formData['userId'];
        $this->startDate = $formData['startDate'];
        $this->emdDate = $formData['endDate'];
        $this->token = $formData['token'];
        $this->bet = $formData['bet'];
        
        $this->prepareParams();

        return $this->getTasksData();
    }

    private function prepareParams()
    {
        $this->params = [
            'token' => $this->token,
            'filter[employer_id]' => $this->userId,
            'filter[date][from]' => $this->startDate,
            'filter[date][to]' => $this->emdDate,
            'sort' => 'date',
            'dir' => 'ASC',
            'limit' => 5000
        ];
    }

    private function getTasksData()
    {
        $content = $this->apiHttpService->getTasks($this->params);

        $result = [];
        $countHours = 0;
        if (!empty($content)) {
            foreach ($content['data'] as $task) {

                $countHours += (int)$task['time'];

                if (!isset($result[$task['task_id']]['hours']))
                    $result[$task['task_id']]['hours'] = 0;

                if (!isset($result[$task['task_id']]['comment']))
                    $result[$task['task_id']]['comment'] = [];

                $result[$task['task_id']]['project_name'] = $task['project_name'];
                $result[$task['task_id']]['title'] = $task['title'];
                $result[$task['task_id']]['comment'][] = $task['comment'];
                $result[$task['task_id']]['hours'] += $task['time'];
            }
        }

        return [
            'hours' => $countHours,
            'date' => date("d.m.Y"),
            'firstDay' => $this->startDate,
            'lastDay' => $this->emdDate,
            'sumString' => CardinalNumeralGenerator::getCase($countHours * $this->bet, 'именительный'),
            'sum' => $countHours * $this->bet,
            'report' => $result
        ];
    }
}
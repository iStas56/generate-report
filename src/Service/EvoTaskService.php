<?php

namespace App\Service;

use morphos\Cases;
use morphos\Russian\CardinalNumeralGenerator;

class EvoTaskService
{
    private $apiHttpService;
    private $params = [];

    public function __construct(ApiHttpService $apiHttpService)
    {
        $this->apiHttpService = $apiHttpService;
    }

    public function getTasksData(array $formData)
    {
        $this->params['token'] = $formData['token'];
        $this->params['filter[employer_id]'] = $formData['userId'];
        $this->params['filter[date][from]'] = $formData['startDate'];
        $this->params['filter[date][to]'] = $formData['endDate'];
        $this->params['limit'] = 5000;
        $this->params['sort'] = 'date';
        $this->params['dir'] = 'ASC';

        return $this->getDataFromApi($formData['bet']);
    }

    private function getDataFromApi($bet)
    {
        $content = $this->apiHttpService->getTasks($this->params);

        if (empty($content)) {
            return [];
        }

        $result = [];
        $countHours = 0;

        foreach ($content['data'] as $task) {
            $countHours += (int)$task['time'];

            $result[$task['task_id']]['project_name'] = $task['project_name'];
            $result[$task['task_id']]['title'] = $task['title'];
            $result[$task['task_id']]['comment'][] = $task['comment'];
            $result[$task['task_id']]['hours'] ??= 0;
            $result[$task['task_id']]['hours'] += $task['time'];
        }

        return [
            'hours' => $countHours,
            'date' => date("d.m.Y"),
            'firstDay' => $this->params['filter[date][from]'],
            'lastDay' => $this->params['filter[date][to]'],
            'sumString' => CardinalNumeralGenerator::getCase($countHours * $bet, Cases::NOMINATIVE),
            'sum' => $countHours * $bet,
            'report' => $result
        ];
    }
}

<?php

namespace App\Service;

use morphos\Cases;
use morphos\Russian\CardinalNumeralGenerator;

class EvoTaskService
{
    private $apiHttpService;
    private $countService;
    private $params = [];

    public function __construct(ApiHttpService $apiHttpService, CountService $countService)
    {
        $this->apiHttpService = $apiHttpService;
        $this->countService = $countService;
    }

    public function getTasksData(array $formData)
    {
        $this->params['token'] = $formData['token'];
        $this->params['filter[employer_id]'] = $formData['userId'];
        $this->params['filter[date][from]'] = $formData['startDate']->format('d.m.Y');
        $this->params['filter[date][to]'] = $formData['endDate']->format('d.m.Y');
        $this->params['limit'] = 5000;
        $this->params['sort'] = 'date';
        $this->params['dir'] = 'ASC';

        return $this->getDataFromApi($formData);
    }

    private function getDataFromApi($formData)
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

        $arDate = [
            'curDate' => date("d.m.Y"),
            'firstDay' => $formData['startDate']->format('d.m.Y'),
            'lastDay' => $formData['endDate']->format('d.m.Y'),
            'startDateExtend' => isset($formData['startDateExtend']) ? $formData['startDateExtend']->format('d.m.Y') : '',
            'endDateExtend' => isset($formData['endDateExtend']) ? $formData['endDateExtend']->format('d.m.Y') : '',
        ];

        $strName = explode(' ', $formData['fio']);
        $shortName = $strName[0] . ' ' . mb_substr($strName[1], 0, 1) . '.' . mb_substr($strName[2], 0, 1) . '.';

        $userDate = [
            'contract' => $formData['contract'],
            'fullUserName' => $formData['fio'],
            'shortUserName' => $shortName,
        ];

        return [
            'user' => $userDate,
            'calculate' => $this->countService->calculateHoursAndSum($formData, $countHours),
            'date' => $arDate,
            'report' => $result
        ];
    }
}

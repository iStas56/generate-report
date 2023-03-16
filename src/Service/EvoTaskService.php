<?php

namespace App\Service;

use morphos\Gender;
use morphos\Russian\CardinalNumeralGenerator;
use Symfony\Component\HttpClient\HttpClient;

class EvoTaskService
{
    public function getTasksData(int $userId, int $bet)
    {
        $first_day_last_month = date('01.m.Y', strtotime('last month'));
        $last_day_last_month = date('t.m.Y', strtotime('last month'));

        $params = [
            'token' => 'infeidp15dspkvbmzroevarten8650k8',
            'filter[employer_id]' => $userId,
            'filter[date][from]' => $first_day_last_month,
            'filter[date][to]' => $last_day_last_month,
            'sort' => 'date',
            'dir' => 'ASC',
            'limit' => 5000
        ];

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://evo.skillum.ru/api/task', [
            'query' => $params,
        ]);

        $status = $response->getStatusCode();
        $content = json_decode($response->getContent(), true);

        $result = [];
        $countHours = 0;
        if ($status === 200) {
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
            'firstDay' => $first_day_last_month,
            'lastDay' => $last_day_last_month,
            'sumString' => CardinalNumeralGenerator::getCase($countHours * $bet, 'именительный'),
            'sum' => $countHours * $bet,
            'report' => $result
        ];
    }
}
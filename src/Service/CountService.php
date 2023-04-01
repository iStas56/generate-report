<?php

namespace App\Service;

use morphos\Cases;
use morphos\Russian\CardinalNumeralGenerator;

class CountService
{
    public function calculateHoursAndSum($formData, $hours)
    {
        $result = [];
        $result['isShowExtendedData'] = false;

        $result['mainSum'] = $formData['bet'] * $hours;
        $result['mainHours'] = $hours;
        $result['stringSum'] = CardinalNumeralGenerator::getCase($result['mainSum'], Cases::NOMINATIVE);
        $result['totalSum'] = $result['mainSum'];

        if (isset($formData['extendSum']) && $formData['extendSum'] > 0) {
            $result['extendSum'] = $formData['extendSum'];
            $result['extendHours'] = round($formData['extendSum'] / $formData['bet'], 2);
            $result['totalSum'] += $result['extendSum'];
            $result['stringSum'] = CardinalNumeralGenerator::getCase($result['totalSum'], Cases::NOMINATIVE);
            $result['isShowExtendedData'] = true;
        }

        return $result;
    }
}
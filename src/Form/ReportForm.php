<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ReportForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', IntegerType::class, ['data' => 599])
            ->add('bet', IntegerType::class, ['data' => 850])
            ->add('fio', TextType::class, ['data' => 'Ардашев Станислав Витальевич'])
            ->add('contract', TextType::class, ['data' => '№ ВИ-01012023-1 от 01.01.2023 г'])
            ->add('startDate', TextType::class, ['data' => '01.03.2023'])
            ->add('endDate', TextType::class, ['data' => '31.03.2023'])
            ->add('token', TextType::class, ['data' => 'infeidp15dspkvbmzroevarten8650k8'])
            ->add('extendSum', IntegerType::class, ['required' => false])
            ->add('startDateExtend', TextType::class, ['required' => false])
            ->add('endDateExtend', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class);

    }
}
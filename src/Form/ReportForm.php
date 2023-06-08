<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('token', TextType::class)
            ->add('extendSum', IntegerType::class, ['required' => false])
            ->add('startDateExtend', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('endDateExtend', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('submit', SubmitType::class);

    }
}
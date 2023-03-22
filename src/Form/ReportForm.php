<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ReportForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', IntegerType::class)
            ->add('bet', IntegerType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('token', TextType::class)
            ->add('submit', SubmitType::class)
        ;
    }

}
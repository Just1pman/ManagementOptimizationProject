<?php

namespace App\Form;

use App\Entity\PersonalData;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfBirth', DateType::class, [
                'empty_data' => '',
                'widget' => 'single_text'
            ])
            ->add('maritalStatus', ChoiceType::class, [
                'choices' => [
                    'Married' => 'married',
                    'Single' => 'single',
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female'
                ],
            ])
            ->add('phone', TelType::class)
            ->add('about', TextareaType::class, [
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'empty_data' => ''
            ])
            ->add('surname', TextType::class, [
                'empty_data' => ''
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalData::class,
        ]);
    }
}

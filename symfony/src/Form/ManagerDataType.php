<?php

namespace App\Form;

use App\Entity\ManagerData;
use App\Entity\ProjectRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManagerDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userRole', EntityType::class, [
                'class' => ProjectRole::class
            ])
            ->add('userSalary', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ManagerData::class,
        ]);
    }
}

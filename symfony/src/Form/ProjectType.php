<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use App\Service\SkillService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{

    /**
     * @var SkillService
     */
    private SkillService $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('internalTitle')
            ->add('externalTitle')
            ->add('periodStart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('periodEnd', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Project;
use App\Service\SkillService;
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
            ->add('technologies', CollectionType::class, [
                    'entry_type' => TechnologyType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
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

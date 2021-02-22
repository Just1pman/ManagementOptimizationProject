<?php

namespace App\Form;

use App\Entity\TechnicalExperience;
use App\Service\SkillService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicalExperienceType extends AbstractType
{

    /**
     * @var TechnicalExperience
     */
    private TechnicalExperience $experience;
    /**
     * @var SkillService
     */
    private SkillService $skillService;

    public function __construct(TechnicalExperience $experience, SkillService $skillService)
    {

        $this->experience = $experience;
        $this->skillService = $skillService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', ChoiceType::class, [
                'choices' => $this->experience::LEVEL
            ])
            ->add('skills', ChoiceType::class, [
                'choices' => $this->skillService->getSkillCategory(),
            ]);
    }

    private function getYears($min, $max='current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TechnicalExperience::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\TechnicalExperience;
use App\Repository\CategoryRepository;
use App\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicalExperienceType extends AbstractType
{

    /**
     * @var TechnicalExperience
     */
    private TechnicalExperience $experience;

    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;
    /**
     * @var SkillRepository
     */
    private SkillRepository $skillRepository;

    public function __construct(TechnicalExperience $experience, CategoryRepository $categoryRepository, SkillRepository $skillRepository)
    {

        $this->experience = $experience;
        $this->categoryRepository = $categoryRepository;
        $this->skillRepository = $skillRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('experienceTerm', ChoiceType::class, [
                'choices' => $this->getYears(1990),
            ])
            ->add('level', ChoiceType::class, [
                'choices' => $this->experience::LEVEL
            ])
            ->add('lastYearUsed', ChoiceType::class, [
                'choices' => $this->getYears(1990),
            ])
            ->add('skills', ChoiceType::class, [
                'choices' => $this->skillCategory(),
            ]);
    }

    private function getYears($min, $max='current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }

    public function skillCategory(): array
    {
        $skills = [];
        foreach ($this->categoryRepository->getAllTitle() as $item) {
            $category = $this->categoryRepository->findOneBy(['title' => $item]);
            $categoryId = $category->getId();
            $skillsCategory = $this->skillRepository->findBy(['category' => $categoryId]);
            $skillsCollection = [];
            foreach ($skillsCategory as $skill) {
                $skillsCollection[$skill->getTitle()] = $skill->getTitle();
            }
            $skills[$item] = $skillsCollection;
        }
        return $skills;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TechnicalExperience::class,
        ]);
    }
}

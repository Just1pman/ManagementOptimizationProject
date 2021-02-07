<?php

namespace App\Form;

use App\Entity\SpokenLanguage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpokenLanguageType extends AbstractType
{

    private $language;

    /**
     * @param $language
     */
    public function __construct(SpokenLanguage $language)
    {
        $this->language = $language;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', ChoiceType::class, [
                    'choices' => $this->language::LANGUAGE,
                ])
            ->add('level', ChoiceType::class, [
                'choices' => $this->language::LEVEL
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpokenLanguage::class,
        ]);
    }
}

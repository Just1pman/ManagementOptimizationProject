<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\TechnicalExperience;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicalExperienceType extends AbstractType
{

    /**
     * @var TechnicalExperience
     */
    private TechnicalExperience $experience;

    public function __construct(TechnicalExperience $experience)
    {

        $this->experience = $experience;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('experienceTerm', IntegerType::class)
            ->add('level', ChoiceType::class, [
//                'choices' =>

            ])
            ->add('skill', ChoiceType::class, [
                'choices' => $this->experience::LEVEL
            ])
            ->add('lastYearUsed', IntegerType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
//                'placeholder' => ''
            ]);
    }

//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function (FormEvent $event) {
//                $form = $event->getForm();
//
//                // это будет ваша сущность, т.е. TechnicalExperienceType
//                $data = $event->getData();
//                /** @var TechnicalExperience $data */
//                $category = $data->getCategory();
//
//                $choices = null === $category ? array() : $category->getSkills();
//
//                $form->add('skill', ChoiceType::class, [
//                'choices' => $choices
//                ]);
//            }

//                $form->add('position', EntityType::class, array(
//                    'class' => 'App\Entity\Position',
//                    'placeholder' => '',
//                    'choices' => $positions,
//                ));
//            }
//        );



//            ->add('user')
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TechnicalExperience::class,
        ]);
    }
}

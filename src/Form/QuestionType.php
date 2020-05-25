<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [

            ])
            ->add('content', TextareaType::class, [

            ])
            ->add('tags', ChoiceType::class, [
                'required' => false,
                'expanded' => false,
                'multiple' => true,
            ])
        ;

        $builder
            ->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsString) {
                    return explode(', ', $tagsAsString);
                },
                function ($tagsAsArray) {
                    return implode(', ', $tagsAsArray);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'attr'       => [
                'class' => 'form',
            ],
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class AnswerType extends AbstractType
{
    /** @var Security $security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr'  => [
                    'class'       => 'answer-form__message',
                    'placeholder' => 'Lorem ipsum dolor sit amet...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
            'disabled'   => !$this->security->isGranted('IS_AUTHENTICATED_FULLY'),
            'attr'       => [
                'novalidate' => true,
                'class' => 'answer-form clear',
            ],
        ]);
    }
}

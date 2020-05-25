<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class QuestionType extends AbstractType
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
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('tags', EntityType::class, [
                'class'    => Tag::class,
                'required' => false,
                'expanded' => false,
                'multiple' => true,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPreSubmit'])
        ;
    }

    public function onPreSubmit(FormEvent $event)
    {
        /** @var Question $question */
        $question = $event->getData();
        $question->setUser($this->security->getUser());
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

<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'John',
                ],
                'constraints' => [
                    new Length([
                        'min'        => 3,
                        'max'        => 20,
                        'minMessage' => 'The firstname should contain at least {{ limit }} characters',
                        'maxMessage' => 'The firstname should contain a maximum of {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'Doe',
                ],
                'constraints' => [
                    new Length([
                        'min'        => 3,
                        'max'        => 20,
                        'minMessage' => 'The lastname should contain at least {{ limit }} characters',
                        'maxMessage' => 'The lastname should contain a maximum of {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr'        => [
                    'placeholder' => 'john.doe@email.com',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'The email could not be blank',
                    ]),
                    new Email([
                        'message' => 'The email is not valid',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr'        => [
                    'placeholder' => 'Your comment here...',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'The message could not be blank',
                    ]),
                    new Length([
                        'min'        => 10,
                        'max'        => 2500,
                        'minMessage' => 'The message should contain at least {{ limit }} characters',
                        'maxMessage' => 'The message should contain a maximum of {{ limit }} characters',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => true,
            ],
        ]);
    }
}

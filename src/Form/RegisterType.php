<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    /** @var UrlGeneratorInterface $router */
    private $router;

    /** @var PasswordEncoderInterface $encoder */
    private $encoder;

    public function __construct(UrlGeneratorInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'empty_data' => '',
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped'      => false,
                'label'       => 'Password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'The password could not be blank',
                    ]),
                    new Length([
                        'min'        => 5,
                        'max'        => 18,
                        'minMessage' => 'The password should contain at least {{ limit }} characters',
                        'maxMessage' => 'The password should contain a maximum of {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped'      => false,
                'label'       => 'I agree to the AnsFrame <a href="' . $this->router->generate('legalMentions') . '">Terms of Service</a> and <a href="' . $this->router->generate('legalMentions') . '">Privacy Policy</a>',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You must accept the conditions to create an account',
                    ])
                ],
            ])
            ->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit'])
        ;
    }

    public function onSubmit(FormEvent $event)
    {
        /** @var User $user */
        $user = $event->getData();
        $data = $event->getForm();

        if (null !== $data->get('agreeTerms')->getViewData()) {
            $user->setAgreeTerms(new \DateTime());
        }

        $plainPassword = $data->get('plainPassword')->getViewData();

        if (!empty($plainPassword)) {
            $encoded = $this->encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

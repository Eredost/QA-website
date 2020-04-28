<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterType extends AbstractType
{
    /** @var UrlGeneratorInterface $router */
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     *
     * @required
     */
    public function setRouter(UrlGeneratorInterface $router)
    {
        $this->router = $router;
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
            ->add('password', PasswordType::class, [
                'empty_data' => '',
            ])
            ->add('termsAgree', CheckboxType::class, [
                'invalid_message' => 'You must accept the conditions to create an account',
                'mapped' => false,
                'label'  => 'I agree to the AnsFrame <a href="' . $this->router->generate('legalMentions') . '">Terms of Service</a> and <a href="' . $this->router->generate('legalMentions') . '">Privacy Policy</a>',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr'       => [
                'novalidate' => true,
            ],
        ]);
    }
}

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
use Symfony\Component\Validator\Constraints\IsTrue;

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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'  => 'I agree to the AnsFrame <a href="' . $this->router->generate('legalMentions') . '">Terms of Service</a> and <a href="' . $this->router->generate('legalMentions') . '">Privacy Policy</a>',
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
        $data = $event->getForm()->get('agreeTerms')->getViewData();

        if (null !== $data) {
            $user->setAgreeTerms(new \DateTime());
        }
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

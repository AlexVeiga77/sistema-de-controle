<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nome',
                'attr' => [
                    'placeholder' => "Informe o nome",
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Senha',
                'attr' => [
                    'placeholder' => 'digite sua senha',
                ]
            ])
            ->add('roles', ChoiceType::class, [
                    'attr' => [
                        'placeholder' => 'Escolher o acesso de usuário',
                    ],
                    'choices' => [
                        'Administrador' => 'ROLE_ADMINISTRADOR',
                        'Gerente' => 'ROLE_GERENTE',
                        'Operador' => 'ROLE_OPERADOR'
                    ],
                    'multiple' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

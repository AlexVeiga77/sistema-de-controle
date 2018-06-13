<?php

namespace App\Form;

use App\Entity\Secretaria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SecretariaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => "Nome",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Informe seu nome",
                ]
            ])
            ->add('enviar', SubmitType::class, ['label' => "salvar",
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->add('voltar', SubmitType::class, ['label' => "voltar",
                'attr' => [
                    'class' => 'btn bt-primary'
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Secretaria::class,
        ])
        ;
    }


}

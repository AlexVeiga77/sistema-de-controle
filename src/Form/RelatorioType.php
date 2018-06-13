<?php

namespace App\Form;

use App\Entity\Funcionario;
use App\Enum\FuncionarioStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelatorioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('data_inicio', DateType::class, [
                'widget' => 'single_text',

            ])
            ->add('data_fim', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => array_flip(FuncionarioStatusEnum::getStatus())
            ])
            ->add('pdf', SubmitType::class, [
                'label' => 'Gerar PDF'
            ])
            ->add('excel', SubmitType::class, [
                'label' => 'Gerar excel'
            ])
            ->add('pesquisar', SubmitType::class, [
                'label' => 'Pesquisar'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

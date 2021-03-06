<?php

namespace App\Form;


use App\Entity\Funcionario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FuncionarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secretaria', EntityType::class, [
                'label' => "Secretaria",
                'class' => 'App\Entity\Secretaria',
                'choice_label' => 'nome',
                'multiple' => false,
            ])
            ->
            add('nome', TextType::class, [
                'label' => "Nome",
                'attr' => [
                    'placeholder' => "Informe seu nome",
                ]
            ])
            ->add('idade', IntegerType::class, [
                'label' => "idade",
                'attr' => [
                    'min' => 0,
                    'max' => 65,
                    'step' => 2,
                    'placeholder' => "informa sua idade",
                ]
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => "sexo",
                'choices' => [
                    'selecione' => "",
                    'masculino' => "M",
                    'feminino' => "F",
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => "status",
                'choices' => [
                    'selecione' => "",
                    'Ativo' => "A",
                    'Exonerado' => "E",
                ]
            ])
            ->add('data_nascimento', BirthdayType::class, [
                'label' => "Data de Nascimento",
                'format' => 'dd-MM-yyyy',
                'widget' => 'choice'
            ])
            ->add('endereco', EnderecoType::class, [
                'label' => "Dados de Endereço"
            ])
            ->add('cargo', ChoiceType::class, [
                'label' => 'Cargo:',
                'choices' => [
                    'Cargo_Efetivo' => 'Efetivo',
                    'Cargo_Comissionado' => 'Comissionado'
                ]
            ])
            ->add('cpf', TextType::class, [
                'required' => false,
                'attr' => ['data-mask' => '000.000.000-00',
                    'placeholder' => "_ _ _ . _ _ _ . _ _ _ - _ _"
                ]
            ])
            ->add('imagem_documento', FileType::class, array('data_class' => null), [
                'label' => 'imagem_documento (PDF file)'

            ])
            ->add('data_admissao', DateType::class, [
                'widget' => 'single_text',

            ])
            ->add('data_exoneracao', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('sal_base', MoneyType::class, [
                'label' => "Salário Base",
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => "Informe seu salário",
                ]
            ])
            ->add('gratif', MoneyType::class, [
                'label' => "Gratificação",
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => "Informe sua gratificação",
                ]
            ])
            ->add('desconto', MoneyType::class, [
                'label' => "Desconto",
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => "Informe sua gratificação",
                ]
            ])
            ->add('liquido', MoneyType::class, [
                'label' => "Salário Líquido",
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => "Valor do líquido",
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
            // uncomment if you want to bind to a class
            'data_class' => Funcionario::class,
        ]);
    }
}


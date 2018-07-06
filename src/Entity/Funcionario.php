<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FuncionarioRepository")
 */
class Funcionario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /** @var Secretaria
     * @ORM\ManyToOne(targetEntity="App\Entity\Secretaria")
     * @Assert\NotBlank()
     */
    private $secretaria;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nome;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\Notblank()
     * @Assert\Range(min="0", max="70")
     */
    private $idade;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     * @Assert\Choice(choices={"M","F"})
     */
    private $sexo;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $data_nascimento;

    /**
     * @var Endereco
     * @ORM\ManyToOne(targetEntity="App\Entity\Endereco", cascade={"persist"})
     * @Assert\Valid()
     */
    private $endereco;

    /**
     * @var string
     * @ORM\Column(type="string", length=16, unique=true)
     * @Assert\NotBlank(message="O campo nome não pode ser vazio!")
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={"application/pdf"}, mimeTypesMessage="arquivo invalido")
     * @Assert\NotBlank(message = "selecione um pdf para esse campo")
     */
    private $imagem_documento;

    /**
     * @var string
     * @ORM\Column(type="string", length=14)
     * @Assert\Notblank()
     * @Assert\Choice(choices={"Efetivo", "Comissionado"})
     */
    private $cargo;

    /** @var \Date
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\Notblank()
     *
     */
    private $data_admissao;

    /**
     * @var \Date
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     * @Assert\Expression(
     *     "this.getStatus() == 'A' && value == '' || this.getStatus() == 'E' && value != '' ",
     *     message=" verificar o campo."
     *)
     */
    private $data_exoneracao;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     * @Assert\Choice(choices={"A", "E"})
     */
    private $status = "A";

    /** @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="100000")
     */
    private $sal_base;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Range(min="0", max="100000")
     * @Assert\Expression(
     *     "this.getCargo() == 'Comissionado' && value == '' || this.getCargo() == 'Efetivo' && value != '' ",
     *    message="não preencher")
     */
    private $gratif;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="100000")
     *
     */
    private $desconto;

    /** @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Range(min="0", max="100000")
     */
    private $liquido;

    public function calculoLiquido()
    {
        $result_liquido = ($this->getSalBase() + $this->getGratif()) - $this->getDesconto();
        $this->setLiquido($result_liquido);
    }


    public function getId()
    {
        return $this->id;
    }


    public function getSecretaria()
    {
        return $this->secretaria;
    }


    public function setSecretaria($secretaria)
    {
        $this->secretaria = $secretaria;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }


    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }


    public function getIdade()
    {
        return $this->idade;
    }


    public function setIdade($idade)
    {
        $this->idade = $idade;
        return $this;
    }


    public function getSexo()
    {
        return $this->sexo;
    }


    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }


    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }


    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;
        return $this;
    }


    public function getEndereco()
    {
        return $this->endereco;
    }


    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }


    public function getCpf()
    {
        return $this->cpf;
    }


    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagemDocumento()
    {
        return $this->imagem_documento;
    }

    /**
     * @param string $imagem_documento
     * @return Funcionario
     */
    public function setImagemDocumento($imagem_documento)
    {
        $this->imagem_documento = $imagem_documento;
        return $this;
    }

    public function getCargo()
    {
        return $this->cargo;
    }


    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }


    public function getDataAdmissao()
    {
        return $this->data_admissao;
    }


    public function setDataAdmissao($data_admissao)
    {
        $this->data_admissao = $data_admissao;
        return $this;
    }


    public function getDataExoneracao()
    {
        return $this->data_exoneracao;
    }


    public function setDataExoneracao($data_exoneracao)
    {
        $this->data_exoneracao = $data_exoneracao;
        return $this;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return float
     */
    public function getSalBase()
    {
        return $this->sal_base;
    }

    /**
     * @param float $sal_base
     * @return Funcionario
     */
    public function setSalBase(float $sal_base): Funcionario
    {
        $this->sal_base = $sal_base;
        return $this;
    }

    /**
     * @return float
     */
    public function getGratif()
    {
        return $this->gratif;
    }

    /**
     * @param float $gratif
     * @return Funcionario
     */
    public function setGratif(?float $gratif): Funcionario
    {
        $this->gratif = $gratif;
        return $this;
    }

    /**
     * @return float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * @param float $desconto
     * @return Funcionario
     */
    public function setDesconto(float $desconto): Funcionario
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * @return float
     */
    public function getLiquido()
    {
        return $this->liquido;
    }

    /**
     * @param float $liquido
     * @return Funcionario
     */
    public function setLiquido(float $liquido): Funcionario
    {
        $this->liquido = $liquido;
        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecretariaRepository")
 */
class Secretaria
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private $nome;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Secretaria
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }
    public function __toString ()
    {
        return $this->getNome();
    }

}



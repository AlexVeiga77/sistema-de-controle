<?php

use App\Entity\Funcionario;
use Doctrine\Bundle\FixturesBundle\Fixtures;
use Doctrine\Common\Persistence\ObjectManager;

class faker extends Fixture
{
    public function load(objectManager $manager)
    {
        for ($i = 0; $i < 50; $i++){
            $funcionario = new Funcionario();
            $funcionario->setNome('funcionario' . $i);
            $funcionario->setCargo('funcionario' . $i);
            $funcionario->setIdade('funcionario'.$i);
            $funcionario->setEndereco('endereco'.$i);
            $funcionario->setCpf('funcionario'.$i);
            $funcionario->setExonerado('secretaria'.$i);
            $funcionario->setDataAdmissao('funcionario'.$i);
            $funcionario->setDataNascimento('funcionario'.$i);
            $funcionario->setNormalEmFolha('secretaria', $i);
            $funcionario->setSalBase('funcionario', $i);
            $funcionario->setGratif('funcionario'.$i);
            $funcionario->setDesconto('funcionario', $i);
            $funcionario->setSecretaria('funcionario', $i);
            $manager->persist($funcionario);
        }
        $manager->flush();
    }
}

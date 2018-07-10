<?php


namespace App\Tests;

use App\Entity\Funcionario;
use PHPUnit\Framework\TestCase;


class FuncionarioTest extends TestCase
{
    /**
     * public function testSetAndGetNome()
     * {
     * $funcionario = new Funcionario();
     * $this->assertNull($funcionario->getNome());
     * $this->assertInstanceOf(Funcionario::class, $funcionario->setNome("carlos"));
     * $this->assertEquals("carlos", $funcionario->getNome());
     * }
     *
     * public function testSetAndGetIdade()
     * {
     * $funcionario = new Funcionario();
     * $this->assertNull($funcionario->getIdade());
     * $this->assertInstanceOf(Funcionario::class, $funcionario->setIdade("50"));
     * $this->assertEquals("50", $funcionario->getIdade());
     * }
     *
     * public function testSetAndGetCpf()
     * {
     * $funcionario = new Funcionario();
     * $this->assertNull($funcionario->getCpf());
     * $this->assertInstanceOf(Funcionario::class, $funcionario->setCpf("5054564333"));
     * $this->assertEquals("5054564333", $funcionario->getCpf());
     * }
     *
     * public function testSetAndGetDataAdmissao()
     * {
     * $funcionario = new Funcionario();
     * $this->assertNull($funcionario->getDataAdmissao());
     * $this->assertInstanceOf(Funcionario::class, $funcionario->setDataAdmissao("22-06-2018"));
     * $this->assertEquals("22-06-2018", $funcionario->getDataAdmissao());
     * }
     *
     **/

    public function testIfIdsNull()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->getId());
    }

    public function testIfCalculoLiquidosNull()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->calculoLiquido());
    }

    /**
     * @param $sexo
     * @dataProvider collectionDados
     */
    public function testEncapsulamento($propriedade, $esperado, $atual)
    {
        $funcionario = new Funcionario();

        $null = $funcionario->{'get' . ucfirst($propriedade)}();
        $this->assertNull($null);

        $resultado = $funcionario->{'set' . ucfirst($propriedade)}($atual);
        $this->assertInstanceOf(Funcionario::class, $resultado);

        $atual = $funcionario->{'get' . ucfirst($propriedade)}();
        $this->assertEquals($esperado, $atual);
    }

    public function collectionDados()
    {
        return [
            ['nome', 'renan', 'renan'],
            ['idade', 20, 20],
            ['cpf', 76767676, 76767676],
            ['dataAdmissao', '1981-07-02', '1981-07-02'],
        ];
    }
}
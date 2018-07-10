<?php


namespace App\Tests;

use App\Entity\Funcionario;
use PHPUnit\Framework\TestCase;


class FuncionarioTest extends TestCase
{

    public function testIfIdsNull()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->getId());
    }

    /**
     * @param $sexo
     * @dataProvider collectionDados
     */
    public function testEncapsulamento($propriedade, $esperado, $atual)
    {
        $funcionario = new Funcionario();

        $null = $funcionario->{'get' . ucfirst($propriedade)}();
        if (!is_float($esperado)) {
            $this->assertNull($null);
        } else {
            if (is_float($esperado)) {
                $this->assertEquals(0.0, $null);
            } else {
                $this->assertEquals(0, $null);
            }
        }

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
            ['salBase', '2000.00', '2000.00'],
            ['gratif', '1000.00', '1000.00'],
            ['desconto', '200.00', '200.00']
        ];
    }

    public function testIfCalculoLiquidosNull()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->calculoLiquido());
    }

    public function testSetAndGetLiquido()
    {
        $funcionario = new Funcionario();
        $this->assertNull($funcionario->getLiquido());
        $this->assertInstanceOf(Funcionario::class, $funcionario->setLiquido("2345.00"));
        $this->assertEquals('2345.00', $funcionario->getLiquido());
    }


}
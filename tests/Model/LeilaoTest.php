<?php

namespace Tests\Model;

use PHPUnitAlura\Model\Usuario;
use PHPUnitAlura\Model\Leilao;
use PHPUnitAlura\Model\Lance;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances($qtdLances, $leilao, $valores)
    {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($leilao as $i => $oLeilao) {
            static::assertEquals($valores[$i], $oLeilao->getLances()[$i]->getValor());
        }
    }

    // Dados
    public function geraLances()
    {
        $joao = new Usuario("João");
        $maria = new Usuario("Maria");

        $leilaoCom2Lances = new Leilao("Fiat 147 0Km");
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lance = new Leilao("Volante Logitec G27");
        $leilaoCom1Lance->recebeLance(new Lance($maria, 5000));

        return [
            "com dois lances" => [2, $leilaoCom2Lances, [1000, 2000]],
            "com um lance" => [1, $leilaoCom1Lance, [1000]]
        ];
    }
}
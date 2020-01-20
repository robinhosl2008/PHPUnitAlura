<?php

namespace PHPUnitAlura\Tests\Service;

use PHPUnit\Framework\TestCase;
use PHPUnitAlura\Model\Lance;
use PHPUnitAlura\Model\Leilao;
use PHPUnitAlura\Model\Usuario;
use PHPUnitAlura\Service\Avaliador;

class AvaliadorTest extends TestCase
{
    private $avaliador;

    protected function setUp() : void
    {
        $this->avaliador = new Avaliador();
    }

    /**
     * @dataProvider entregaLeiloes
     */
    public function testAvaliadorDeveEncontrarOMaiorLance(Leilao $leilao)
    {
        $this->avaliador->avaliaLeilao($leilao);

        $maiorValor = $this->avaliador->getMaiorValor();

        self::assertEquals(2000, $maiorValor);
    }

    /**
     * @dataProvider entregaLeiloes
     */
    public function testAvaliadorDeveEncontrarOMenorLance(Leilao $leilao)
    {
        $this->avaliador->avaliaLeilao($leilao);

        $menorValor = $this->avaliador->getMenorValor();

        self::assertEquals(1000, $menorValor);
    }

    /**
     * @dataProvider entregaLeiloes
     */
    public function testBuscaOsTresMaioresValores(Leilao $leilao)
    {
        $this->avaliador->avaliaLeilao($leilao);

        $maioresLances = $this->avaliador->getMaioresLances();

        static::assertCount(3, $maioresLances);
        static::assertEquals(2000, $maioresLances[0]->getValor());
        static::assertEquals(1700, $maioresLances[1]->getValor());
        static::assertEquals(1500, $maioresLances[2]->getValor());
    }

    public function criaLeilao($ordem = null)
    {
        $leilao = new Leilao('Fiat 147 0km');
        $lances = $this->criaUsuario($ordem);

        foreach ($lances as $lance) {
            $leilao->recebeLance($lance);
        }

        return $leilao;
    }

    public function criaUsuario($ordem)
    {
        $lances;
        if($ordem = 'asc'){
            $usuarios = array(['Maria', 1000], ['João', 1500], ['Jorge', 1700], ['Ana', 2000]);
        }else if($ordem = 'desc'){
            $usuarios = array(['Ana', 2000], ['Jorge', 1700], ['João', 1500], ['Maria', 1000]);
        }else if($ordem = null){
            $usuarios = array(['Jorge', 1700], ['Ana', 2000], ['Maria', 1000], ['João', 1500]);
        }
        
        foreach ($usuarios as $key => $usuario) {
            $objUsuario = new Usuario($usuario[0]);
            $lances[] = $this->criaLance($objUsuario, $usuario[1]);
        }
        return $lances;
    }

    public function criaLance(Usuario $objUsuario, Int $valorLance)
    {
        return new Lance($objUsuario, $valorLance);
    }

    public function entregaLeiloes()
    {
        return [
            'ordem-crescente' => [$this->criaLeilao('asc')],
            'ordem-decrescente' => [$this->criaLeilao('desc')],
            'ordem-aleatória' => [$this->criaLeilao()]
        ];
    }
}

<?php

namespace PHPUnitAlura\Service;

use PHPUnitAlura\Model\Leilao;
use PHPUnitAlura\Model\Lance;

class Avaliador
{
    private $maiorValor = -INF;
    private $menorValor = INF;
    private $maioresLances;

    public function avaliaLeilao(Leilao $leilao) : void
    {
        foreach ($leilao->getLances() as $key => $lance) {
            if($lance->getValor() > $this->maiorValor){
                $this->maiorValor = $lance->getValor();
            }
            if($lance->getValor() < $this->menorValor){
                $this->menorValor = $lance->getValor();
            }
        }

        $lances = $leilao->getLances();
        usort($lances, function(Lance $lance1, Lance $lance2){
            return $lance2->getValor() - $lance1->getValor();
        });
        $this->maioresLances = array_slice($lances, 0, 3);
    }

    public function getMaiorValor() : float
    {
        return $this->maiorValor;
    }

    public function getMenorValor() : float
    {
        return $this->menorValor;
    }

    public function getMaioresLances() : array
    {
        return $this->maioresLances;
    }
}

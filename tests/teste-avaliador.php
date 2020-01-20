<?php
namespace PHPUnitAlura\Tests;

use PHPUnitAlura\Model\Lance;
use PHPUnitAlura\Model\Leilao;
use PHPUnitAlura\Model\Usuario;
use PHPUnitAlura\Service\Avaliador;

require __DIR__.'/../vendor/autoload.php';

// Arrange Act Assert - Given When Then
// Cria o cenário. Arrange or Given.
$leilao = new Leilao( 'Fiat 147 0km' );
$joao = new Usuario( 'João' );
$maria = new Usuario( 'Maria');

$lance = new Lance( $joao, 2000 );
$leilao->recebeLance($lance);
$lance = new Lance( $maria, 2500 );
$leilao->recebeLance($lance);

// Executar o teste. Act or When.
$leiloeiro = new Avaliador();
$leiloeiro->avaliaLeilao($leilao);

$maiorValor = $leiloeiro->getMaiorValor();
$valorEsperado = 2500;

// Exibe o resultado. Assert or Then.
if ($maiorValor == $valorEsperado) {
    echo "Teste OK!";
} else {
    echo "Teste falhou";
}
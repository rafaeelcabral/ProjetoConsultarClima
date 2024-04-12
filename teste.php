<?php

use \App\WebService\WorldTimeAPI;

require __DIR__.'/vendor/autoload.php';

$obWorldTimeAPI = new WorldTimeAPI();

$consultaHora = $obWorldTimeAPI->ConsultarHora('Asia', 'Seoul');

//echo'<pre>';
//print_r($consultaHora);
//echo'</pre>';

//----------------CONFIGURANDO OS DADOS DO ARRAY PARA EXTRAIR A DATA E A HORA----------------------//

// Obtém a hora e o offset UTC do array
$utc_datetime = new DateTime($consultaHora['utc_datetime']);

// Obtém o offset UTC do array
$utc_offset = $consultaHora['utc_offset'];

// Extrai as horas do offset
$sinal = substr($utc_offset, 0, 1); // Extrai o primeiro caractere
$horas = abs((int) substr($utc_offset, 1, 2)); // Extrai o 3º e 4º caractere e garante um número positivo

// Formata o offset para o formato correto do DateInterval
$offset_formatado = sprintf("PT%dH", $horas);

// Cria o DateInterval
$utc_offset_interval = new DateInterval($offset_formatado);

// Adiciona ou Subtrai o offset da hora para obter a hora correta
if ($sinal == '+') {
    $hora_correta = $utc_datetime->add($utc_offset_interval);
} else {
    $hora_correta = $utc_datetime->sub($utc_offset_interval);
}

echo 'Hora correta: ' . $hora_correta->format('H:i:s') . "\n";

// -----------------------------------------------------------------------------------------------//

?>
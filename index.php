<?php

use \App\WebService\OpenWeadherMap;
use \App\WebService\WorldTimeAPI;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $continente = $_POST['continente'];
    $cidade = $_POST['cidade'];

    //echo'<pre>';
    //print_r($continente);
    //echo'</pre>'; exit;

    require __DIR__.'/vendor/autoload.php';

    $obOpenWeadherMap = new OpenWeadherMap('8a85fddd8be674738a25e8bec27e31cc');
    $obWorldTimeAPI = new WorldTimeAPI();

    $consulta = $obOpenWeadherMap->ConsultarClima($cidade);
    $consultaHora = $obWorldTimeAPI->ConsultarHora($continente, $cidade);

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

    // -----------------------------------------------------------------------------------------------//

    //echo'<pre>';
    //    print_r($hora_correta->format('H:i:s'));
    //echo'</pre>'; exit;

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ConsultarClima</title>
</head>

<body>
    
    <form action="index.php" method="POST" id="form_exibir">

        <?php

            /* ------------- Lógica das figuras de acordo com o tempo ----------------*/

            /*
              - Algumas Nuvens -> ok;
              - Céu Limpo / Ensolarado -> ok;
              - Chuva / Chuva Leve / Chuva Forte -> ok;
              - Neve -> ok;
              - Nublado -> ok;
            */

            if(($consulta['weather']['0']['description']) == 'algumas nuvens' || ($consulta['weather']['0']['description']) == 'nuvens dispersas'){

                echo '
                    <img src="img/algumasnuvens.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'céu limpo' || ($consulta['weather']['0']['description']) == 'ensolarado'){

                echo '
                    <img src="img/ceulimpo.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'chuva' || ($consulta['weather']['0']['description']) == 'chuva moderada' ||($consulta['weather']['0']['description']) == 'chuva leve' || ($consulta['weather']['0']['description']) == 'chuva forte'){

                echo '
                    <img src="img/chuva.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'neve'){

                echo '
                    <img src="img/neve.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'nublado'){

                echo '
                    <img src="img/nublado.png" class="imagedescription"></img>
                ';

            }

            /* ------------------------------------------------------------------------*/

            echo '<h2>' . ($cidade) . '</h2>';
            echo'<p>Hora => ' . ($hora_correta->format('H:i:s')) . '</p>'; 
            echo'<p>Clima => ' . ($consulta['weather']['0']['description']) . '</p>';
            echo'<p>Temperatura => ' . ($consulta['main']['temp']) . '°C</p>';
            echo'<p>Sensação Térmica => ' . ($consulta['main']['feels_like']) . '°C</p>';

        ?>

    </form>

</body>

</html>
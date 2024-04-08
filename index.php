<?php

use \App\WebService\OpenWeadherMap;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $cidade = $_POST['cidade'];

    require __DIR__.'/vendor/autoload.php';

    $obOpenWeadherMap = new OpenWeadherMap('8a85fddd8be674738a25e8bec27e31cc');

    $consulta = $obOpenWeadherMap->ConsultarClima($cidade);

    //echo'<pre>';
        //echo'Nuvens => '; print_r($consulta['weather']['0']['description']); echo'<br>';
        //echo'Temperatura => '; print_r($consulta['main']['temp']); echo'<br>';
        //echo'Sensação Térmica => '; print_r($consulta['main']['feels_like']); echo'<br>';
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
              - Neve -> * ;
              - Nublado -> * ;
            */

            if(($consulta['weather']['0']['description']) == 'algumas nuvens'){

                echo '
                    <img src="img/algumasnuvens.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'céu limpo' || ($consulta['weather']['0']['description']) == 'ensolarado'){

                echo '
                    <img src="img/ceulimpo.png" class="imagedescription"></img>
                ';

            }

            if(($consulta['weather']['0']['description']) == 'chuva' || ($consulta['weather']['0']['description']) == 'chuva leve' || ($consulta['weather']['0']['description']) == 'chuva forte'){

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
            echo'<p>Nuvens => ' . ($consulta['weather']['0']['description']) . '</p><br>';
            echo'<p>Temperatura => ' . ($consulta['main']['temp']) . '°C</p><br>';
            echo'<p>Sensação Térmica => ' . ($consulta['main']['feels_like']) . '°C</p><br>';

        ?>

    </form>

</body>

</html>
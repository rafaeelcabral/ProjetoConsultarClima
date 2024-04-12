<?php

namespace App\WebService;

class WorldTimeAPI{

    const BASE_URL = 'http://worldtimeapi.org/api/timezone/';

    public function ConsultarHora($continente, $cidade){

        return $this->get($continente, $cidade);

    }

    private function get($par1, $par2){

        $endpoint = self :: BASE_URL . $par1 . '/' . $par2;

        //echo'<pre>';
        //printf($endpoint);
        //echo'</pre>';

        // ------ CONFIGURANDO CURL -------

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        // --------------------------------

        return json_decode($response,true);

    }

}

?>
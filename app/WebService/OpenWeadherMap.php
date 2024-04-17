<?php

namespace App\WebService;

class OpenWeadherMap{

    const BASE_URL = 'https://api.openweathermap.org/data/2.5/weather';

    public function ConsultarClima($cidade){
        return $this->get(['q' => $cidade]);
    }

    private function get($params = []){

        $params['units'] = 'metric';
        $params['lang'] = 'pt_br';
        $params['appid'] = '8a85fddd8be674738a25e8bec27e31cc';

        $endpoint = self :: BASE_URL . '?' . http_build_query($params);

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
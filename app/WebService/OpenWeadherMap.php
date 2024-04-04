<?php

namespace App\WebService;

class OpenWeadherMap{

    const BASE_URL = 'https://api.openweathermap.org';

    private $apiKey;

    public function __construct($apiKey){
        $this->apiKey = $apiKey;
    }

    public function ConsultarClima($cidade){
        return $this->get('/data/2.5/weather',[
            'q' => $cidade
        ]);
    }

    private function get($resources, $params = []){

        $params['units'] = 'metric';
        $params['lang'] = 'pt_br';
        $params['appid'] = $this->apiKey;

        $endpoint = self :: BASE_URL . $resources . '?' . http_build_query($params);

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
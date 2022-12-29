<?php

namespace Igj\Inc\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

trait ConsumeExternalService
{

    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $isJsonRequest = true)
    {
        try{
            $client = new Client([
                'base_uri' => 'https://mycompas.com',
                'verify' => false
            ]);

            $response = $client->request($method, $requestUrl, [
                $isJsonRequest ?  'json'  : 'form_params' => $formParams,
                'headers' => $headers,
                'query' => $queryParams
            ]);

            $response = $response->getBody()->getContents();

            $response = json_decode($response, true);

            return $response;
        }catch (ClientException $e){
            return $e->getMessage();
        }
    }

}
?>

<?php
namespace App\Helper;

class ViaCep{
    const URL = "https://viacep.com.br/ws/";
    const RETURN_TYPE = "json";

    private $zipcode;

    public function __construct($zipcode) {
        if(!empty($zipcode)) {
            // Verificando se o CEP é um número válido
            if(ctype_digit($zipcode)) {
                $this->zipcode = $zipcode;
            } else {
                throw new \Exception('O CEP informado contém caracteres não numéricos. Informe somente os números.');
            }
        } else {
            throw new \Exception('Informe um CEP válido.');
        }
    }

    public function findZipcode() {
        $url = self::URL . $this->zipcode . "/" . self::RETURN_TYPE;

        try {
            $ch = curl_init($url);

            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false
            );

            curl_setopt_array($ch, $options);
            $response = curl_exec($ch);
            curl_close($ch);

            $aResponse = json_decode($response, true);

            if(!empty($aResponse)){
                if(!array_key_exists('erro', $aResponse)){
                    $aResponse['isValid'] = true;

                    return $aResponse;
                }

                throw new \Exception($aResponse['erro']);
            }

        } catch(\Exception $ex ){
            $aResponse['isValid'] = false;

            return $aResponse;
        }
    }
}

<?php
namespace App\Helper;

class ViaCep{
    const URL = "https://viacep.com.br/ws/";
    const RETURN_TYPE = "json";

    private $zipcode;

    public function __construct($zipcode){
        $this->zipcode = $zipcode;
    }

    public function findZipcode() {
        if(!empty($this->zipcode)) {

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
}

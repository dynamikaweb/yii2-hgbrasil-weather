<?php

namespace dynamikaweb\weather\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\base\InvalidConfigException;
use yii\base\Exception;

class WeatherApi extends \yii\base\Component
{

    /**
     * Url inicial da API
     */
    public $url = 'https://api.hgbrasil.com/weather/';

    /**
     * Chave de acesso a API
     * Consulte https://console.hgbrasil.com/documentation/weather#autenticacao-e-chave
     * 
     * @var string
     */
    public $key;

    /**
     * Parâmetros para a consulta da cidade
     * Consulte https://console.hgbrasil.com/documentation/weather
     *
     * @var array
     */
    public $parameters = [];

    /**
     * Função para consultar e salvar o resultado da API em cache
     *
     * @return object
     */
    public function getApi()
    {
        if(!isset($this->key) || !$this->parameters){
            throw new InvalidConfigException('Configuration parameters not found!');;
        }

        $api_instance = Yii::$app->cache->get('weather_api_instance');
        if($api_instance && ($api_instance->results->city_name === "" || !$api_instance->results->city_name)){
            Yii::$app->cache->delete('weather_api_instance');
            $api_instance = false;
        }

        if(!$api_instance){

            //Une os parâmetros e cria a Url para consulta
            $parameters = ArrayHelper::merge(
                [$this->url, 'key' => $this->key, 'format' => 'json'],
                $this->parameters
            );

            $urlRoute = Url::toRoute($parameters, 'https');

            // Obtem os dados da API e salva em cache por 30 minutos
            try{
                $api_instance = file_get_contents($urlRoute);
                $api_instance = Json::decode($api_instance, false);
            } catch (Exception $e){
                throw new Exception('API connection not made, see https://hgbrasil.com/ , erro: '. $e);
            }

            if(!$api_instance->valid_key){
                throw new InvalidConfigException('Access key not found, check it!');
            }

            Yii::$app->cache->set('weather_api_instance', $api_instance, 1800);
        }

        return $api_instance;
    }

}

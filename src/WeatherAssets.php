<?php

namespace dynamikaweb\weather;

use Yii;
use yii\web\AssetBundle;

class WeatherAssets extends AssetBundle
{
    public $sourcePath = '@vendor/dynamikaweb/yii2-hgbrasil-weather/assets';

    public $css = [
        'css/estilos.css'
    ];

    public $js = [];

    public $depends = [];

    public static function getBaseUrlPublished()
    {
        $bundle = Yii::$app->assetManager->getBundle('\dynamikaweb\weather\WeatherAssets');

        if(isset($bundle->baseUrl)){
            return '@web'.$bundle->baseUrl;
        }

        return null;
    }

}
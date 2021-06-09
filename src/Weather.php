<?php

namespace dynamikaweb\weather;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Weather extends \yii\base\Widget
{

    const ICONS_DEFAULT = 'icons-1';
    const ICONS_SECONDARY = 'icons-2';

    public $api;
    public $component = 'weather';
    public $icons = self::ICONS_DEFAULT;
    public $template;
    public $days = 1;

    public $options = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $component = $this->component;
        if(!Yii::$app->$component){
            throw new InvalidConfigException('Component não localizado');
        }

        
        $this->api = Yii::$app->$component->api->results;
        //var_dump($this->api);die;
        WeatherAssets::register(Yii::$app->view);
        
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = Html::beginTag('div', ['class' => 'weather-container']);
        $html .= Html::tag('div', $this->api->temp.' <span>ºC</span>',['class' => 'weather-temp']);
        $html .= $this->renderDays();
        $html .= Html::endTag('div');

        return $html;
    }

    public function getImage($condition)
    {
        $base = WeatherAssets::getBaseUrlPublished();
        return Html::img($base.'/images/'.$this->icons.'/'.$condition.'.svg');
    }

    public function renderDays()
    {
        $results = $this->api->forecast;
        $html = '';
        for ($i=0; $i < $this->days; $i++) { 
            $condition = $i == 0? $this->api->condition_slug: $results[$i]->condition;
            $weekday = $i == 0? 'Hoje': $results[$i]->weekday;

            $html .= Html::beginTag('div', ['class' => 'weather-day'])
                .Html::tag('span', $weekday)
                .Html::tag('div',
                    $this->getImage($condition)
                    .Html::tag('div', 
                        Html::tag('span', $results[$i]->max.'º')
                        .Html::tag('span', $results[$i]->min.'º')
                    ,['class' => 'weather-max-min'])
                , ['class' => 'weather-image'])
                .Html::endTag('div');
        }

        return $html;
    }
}

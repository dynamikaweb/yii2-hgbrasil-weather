dynamikaweb/yii2-hgbrasil-weather
=========================
![php version](https://img.shields.io/packagist/php-v/dynamikaweb/yii2-hgbrasil-weather)
![pkg version](https://img.shields.io/packagist/v/dynamikaweb/yii2-hgbrasil-weather)
![license](https://img.shields.io/packagist/l/dynamikaweb/yii2-hgbrasil-weather)
![quality](https://img.shields.io/scrutinizer/quality/g/dynamikaweb/yii2-hgbrasil-weather)
![build](https://img.shields.io/scrutinizer/build/g/dynamikaweb/yii2-hgbrasil-weather)


Descripton
----------
This Widget was based on the [HG Weather API](https://hgbrasil.com/status/weather), to generate your access key and check the query parameters, see the [API documentation](https://console.hgbrasil.com/documentation/weather)

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```SHELL
$ composer require dynamikaweb/yii2-hgbrasil-weather "*"
```

or add

```JSON
"dynamikaweb/yii2-hgbrasil-weather": "*"
```

to the `require` section of your `composer.json` file.

--------------------------------------------------------------------------------------------------------------
[![dynamika soluções web](https://avatars.githubusercontent.com/dynamikaweb?size=12)](https://dynamika.com.br)
This project is under [BSD-3-Clause](https://opensource.org/licenses/BSD-3-Clause) license.


Usage
-----

Add it to your components

```PHP
'components' => [
    ...
    'weather' => [
        'class' => \dynamikaweb\weather\components\WeatherApi::className(),
        'key' => 'Your key, you can get it from HG Brasil',
        'parameters' => [
            'city_name' => 'Canoas,RS',
        ] 
    ],
    ...
]
```

for different parameters, see [API documentation](https://console.hgbrasil.com/documentation/weather)


create widget

```PHP
    use dynamikaweb\weather\Weather;
    ...
    echo Weather::widget([
        'days' = 2,
        'icons' = Weather::ICONS_DEFAULT, 
    ]);
```
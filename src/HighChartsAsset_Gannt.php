<?php

namespace saddinamo\highcharts_gannt;

use yii\web\AssetBundle;

class HighChartsAsset_gannt extends AssetBundle
{
    // public $sourcePath = '@bower/highcharts-release/';
    public $sourcePath = '@vendor/saddinamo/highcharts-gannt/code';

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $js = [
        'highcharts.src.js',
        'highcharts-gannt.src.js',
    ];
}

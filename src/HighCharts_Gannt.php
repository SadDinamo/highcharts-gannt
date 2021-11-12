<?php
namespace saddinamo\highcharts_gannt;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * HighCharts widget renders a HighCharts JS chart
 *
 */
class HighCharts_Gannt extends Widget
{

    public $ChartOptions = [];
    public $HtmlOptions = [];

    public $RenderMore;
    public $Render3D;

    public $Modules = [];

    public $_renderTo;

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
        if (!isset($this->HtmlOptions['id'])) {
            $this->HtmlOptions['id'] = $this->getId();
        }

        $this->ChartOptions = ArrayHelper::merge(
            [
                'exporting' => [
                    'enabled' => true
                ]
            ],
            $this->ChartOptions
        );

        if (ArrayHelper::getValue($this->ChartOptions, 'exporting.enabled')) {
            $this->Modules[] = 'exporting.js';
        }

        $this->_renderTo = ArrayHelper::getValue($this->ChartOptions, 'chart.renderTo');
    }

    /**
     * @inheritdoc
     */
    public function run(){
        if (empty($this->_renderTo)) {
            echo Html::tag('div', '', $this->HtmlOptions);
            $this->ChartOptions['chart']['renderTo'] = $this->HtmlOptions['id'];
        }
        $this->script_register();
    }

    private function script_register() {
        $view = $this->getView();
        $bundle = HighChartsAsset_Gannt::register($view);
        $id = str_replace('-', '_', $this->HtmlOptions['id']);

        // if ($this->Render3D) {
        //     $bundle->js[] = YII_DEBUG ? 'highcharts-3d.src.js' : 'highcharts-3d.js';
        // }

        // if ($this->RenderMore) {
        //     $bundle->js[] = YII_DEBUG ? 'highcharts-more.src.js' : 'highcharts-more.js';
        // }

        foreach ($this->Modules as $module) {
            $bundle->js[] = "modules/{$module}";
        }

        if ($theme = ArrayHelper::getValue($this->ChartOptions, 'theme')) {
            $bundle->js[] = "themes/{$theme}.js";
        }

        $options = Json::encode($this->ChartOptions);
        // Var_dump($options);

        $view->registerJs(";var highChart_{$id} = new Highcharts.Chart({$options});");
    }
}

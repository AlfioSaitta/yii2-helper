<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\MorrisJsAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Widget;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * This is the Morris Js widget class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class MorrisJs extends Widget
{
    /**
     * @var string
     */
    public $xkey = '';

    /**
     * @var string
     */
    public $ykeys = '';

    /**
     * @var string
     */
    public $labels = '';

    /**
     * @var string
     */
    public $url = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        MorrisJsAsset::register($this->getView());
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('div', '', ['id' => 'morrisjs-chart', 'class' => 'portlet-body-morris-fit morris-chart', 'style' => 'height: 260px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);']);
        $this->getView()->registerJs($this->js);
    }

    /**
     * @return string
     */
    public function getJs()
    {
        return <<< JS
        $(document).ready(function() {
            $.ajax({
                 url: '$this->url',
                 type: 'GET',
                 cache: false,
                 success: function (response) {
                     new Morris.Area({
                         element: 'morrisjs-chart',
                         padding: 0,
                         behaveLikeLine: false,
                         gridEnabled: false,
                         gridLineColor: false,
                         axes: false,
                         fillOpacity: 1,
                         data: response.data,
                         lineColors: ['#399a8c', '#92e9dc'],
                         xkey: $this->xkey,
                         ykeys: $this->ykeys,
                         labels: $this->labels,
                         pointSize: 0,
                         lineWidth: 0,
                         hideHover: 'auto',
                         resize: true,
                         parseTime: false
                     });
                 }
            });
        });
JS;
    }
}

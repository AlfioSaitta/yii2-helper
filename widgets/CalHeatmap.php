<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\CalHeatmapAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Widget;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * This is the cal-heatmap widget class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class CalHeatmap extends Widget
{
    /**
     * @param mixed
     */
    public $url = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        CalHeatmapAsset::register($this->getView());
        $this->url =  Url::to($this->url);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('div', '', ['id' => 'cal-heatmap', 'align' => 'center']);
        echo $this->js;
    }

    /**
     * @return string
     */
    public function getJs()
    {
        return '
        <script type="text/javascript">
            now = new Date();
            now.setMonth(now.getMonth() - 1);

            var cal = new CalHeatMap();
        	cal.init({
            	domain: "month",
            	subDomain: "x_day",
                data: "' . $this->url . '",
            	start: now,
            	cellSize: 20,
            	cellPadding: 5,
            	domainGutter: 20,
            	range: 2,
            	domainDynamicDimension: false,
            	//subDomainTextFormat: "%d",
                highlight: "now",
                tooltip: false,
            	legend: [2, 4, 6, 8]
            });
        </script>';
    }
}

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
     * @param string
     */
    public $id = 'cal-heatmap';

    /**
     * @param mixed
     */
    public $url = '';

    /**
     * @param string
     */
    public $legend = '[1]';

    /**
     * @param string
     */
    public $legendColors = 'null';

    /**
     * @param string
     */
    public $onClickUrl = '';

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
        echo Html::tag('div', '', ['id' => $this->id, 'align' => 'center']);
        $this->getView()->registerJs($this->js);
    }

    /**
     * @return string
     */
    public function getJs()
    {
        return <<< JS
        $(document).ready(function() {
            now = new Date();
            now.setMonth(now.getMonth() - 1);

            var cal = new CalHeatMap();
        	cal.init({
                itemSelector: "#$this->id",
                itemName: ["hour", "hours"],
                subDomainTextFormat: function(date) {
            		return moment(date).format("dd"); // Use the moment library to format the Date
            	},
            	domain: "month",
            	subDomain: "x_day",
                data: "$this->url",
            	start: now,
            	cellSize: 20,
            	cellPadding: 5,
            	domainGutter: 20,
            	range: 2,
            	domainDynamicDimension: false,
                highlight: "now",
                tooltip: false,
            	legend: $this->legend,
                onClick: function(date, value) {
                    $this->onClickJs;
            	},
                legendColors: $this->legendColors,
            });
        });
JS;
    }

    public function getOnClickJs()
    {
        return <<< JS
            var myDate = new moment(date);
            var url = "$this->onClickUrl";
            var url = url.concat("&date=", myDate.format("YYYY-MM-DD"));

            $('#modal').modal('show')
                    .find('#modalContent')
                    .load(url);
            $('#modal').on('shown.bs.modal', function () {
                $('textarea:visible:first').focus();
                $('input:visible:first').focus();
            })
JS;
    }
}

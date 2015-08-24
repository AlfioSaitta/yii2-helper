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
     * @param string
     */
    public $legend = '[8,12,16,20]';

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
        $url = Url::to(['timesheet/list', 'userId' => Yii::$app->user->id]);

        return "
        <script type=\"text/javascript\">
            now = new Date();
            now.setMonth(now.getMonth() - 1);

            var cal = new CalHeatMap();
        	cal.init({
            	domain: \"month\",
            	subDomain: \"x_day\",
                data: \"$this->url\",
            	start: now,
            	cellSize: 20,
            	cellPadding: 5,
            	domainGutter: 20,
            	range: 2,
            	domainDynamicDimension: false,
                highlight: \"now\",
                tooltip: false,
            	legend: $this->legend,
                onClick: function(date, value) {
                    $this->onClickJs;
            	},
            });
        </script>";
    }

    public function getOnClickJs()
    {
        $url = Url::to(['timesheet/list', 'userId' => Yii::$app->user->id]);

        return "
            var myDate = new moment(date);
            var url = \"$url\";
            var url = url.concat(\"&timesheetDate=\", myDate.format(\"YYYY-MM-DD\"));
            console.log(url);

            $('#modal').modal('show')
                    .find('#modalContent')
                    .load(url);
            $('#modal').on('shown.bs.modal', function () {
                $('textarea:visible:first').focus();
                $('input:visible:first').focus();
            })
        ";
    }
}

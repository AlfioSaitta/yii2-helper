<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\DatePaginatorAsset;
use Closure;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Widget;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * This is the DatePaginator widget class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class DatePaginator extends Widget
{
    /**
     * @var string
     */
    public $id = 'date-paginator';

    /**
     * @var string
     */
    public $selectedDate = '';

    /**
     * @var string
     */
    public $queryUrl = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        DatePaginatorAsset::register($this->getView());
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('div', '', ['id' => $this->id]);
        echo Html::a('test', '#', ['style' => 'display: none;', 'id' => 'date-paginator-pjax-button', 'date-paginator-url' => $this->queryUrl]);
        $this->getView()->registerJs($this->js);
    }

    /**
     * @return string
     */
    public function getJs()
    {
        return <<< JS
            $(function(){
                var options = {
                    selectedDate: "$this->selectedDate",
                    selectedDateFormat: 'YYYY-MM-DD',
                    showCalendar: false,
                    endDate: moment(),
                }
                $("#$this->id").datepaginator(options);
                $("#$this->id").on('selectedDateChanged', function(event, date) {
                  var ctl = document.getElementById('date-paginator-pjax-button');
                  ctl.href = ctl.getAttribute('date-paginator-url') + date._i;
                  ctl.click();
                });
            });
JS;
    }


}

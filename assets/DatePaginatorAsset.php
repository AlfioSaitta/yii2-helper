<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * This is the Bootstrap Date Paginator asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class DatePaginatorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot/metronic/theme/';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web/metronic/theme/';

    /**
     * @inheritdoc
     */
    public $css = [
        'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'assets/global/plugins/moment.min.js',
        'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        'assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

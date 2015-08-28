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
 * This is the ajax update asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class CalHeatmapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/anli/yii2-helper/';

    /**
     * @inheritdoc
     */
    public $css = [
        '//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js',
        '//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];
}

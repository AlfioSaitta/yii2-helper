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
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /**
     * @inheritdoc
     */
    public $css = [
        '/cal-heatmap/cal-heatmap.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js',
        '/cal-heatmap/cal-heatmap.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];
}

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
 * This is the Morris Js asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class MorrisJsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = null;

    /**
     * @inheritdoc
     */
    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css',

    ];

    /**
     * @inheritdoc
     */
    public $js = [

        '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',

    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the sweet alert asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class SweetAlertAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/sweetalert/';

    /**
     * @inheritdoc
     */
    public $css = [
        'dist/sweetalert.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dist/sweetalert.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];
}

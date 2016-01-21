<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the show modal button asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class ShowModalButtonAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/anli/yii2-helper/';

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/show-modal-button.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'anli\helper\assets\SweetAlertAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

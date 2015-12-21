<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the ajax delete asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class AjaxDeleteAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/js/';

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'ajax-delete.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\SweetAlertAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

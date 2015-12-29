<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\GridViewAsset;
use Yii;
use yii\bootstrap\Widget;

/**
 * This renders a HTML component for grid view
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class GridView extends \yii\grid\GridView
{
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        GridViewAsset::register($this->getView());
    }
}

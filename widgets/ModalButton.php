<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\ShowModalButtonAsset;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the modal button widget class.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class ModalButton extends Widget
{
    /**
     * @var string
     */
    public $modalId;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $options = [];

    /**
     * Renders the widget.
     */
    public function run()
    {
        $buttonOptions = [
            'class' => 'showModalButton',
            'value' => $this->url,
            'data-modal-id' => $this->modalId,
        ];

        ShowModalButtonAsset::register(Yii::$app->controller->getView());
        Html::addCssClass($buttonOptions, $this->options);

        echo Html::button($this->label, $buttonOptions);
    }

}

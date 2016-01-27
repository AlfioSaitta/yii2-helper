<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\ModalButtonAsset;
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
     * @var string
     */
    public $type = 'button';

    /**
     * Renders the widget.
     */
    public function run()
    {
        $options = array_merge([
            'value' => $this->url,
            'data-modal-id' => $this->modalId,
        ], $this->options);

        ModalButtonAsset::register(Yii::$app->controller->getView());
        Html::addCssClass($options, ['class' => 'show-modal-button']);

        if ('button' == $this->type) {
            return Html::button($this->label, $options);
        }

        if ('link' == $this->type) {
            return Html::a($this->label, false, $options);
        }
    }

}

<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\ModalActiveFormAsset;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/**
 * This is the modal active form widget class.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class ModalActiveForm extends ActiveForm
{
    /**
     * @var string
     */
    public $modalId = 'secondary-modal';

    /**
     * @var string
     */
    public $selectId;

    /**
     * Renders the widget.
     */
    public function init()
    {
        $this->getView()->registerJs(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/js/modal-active-form.js')));
        $this->getView()->registerJs(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/js/modal-hint.js')));

        $this->getView()->registerCss(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/css/hint.css')));
        $this->getView()->registerCss(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/css/select2.css')));

        $this->options = ['class' => 'modal-form', 'data-modal-id' => $this->modalId, 'data-select-id' => $this->selectId];
        $this->enableClientValidation = true;

        parent::init();
    }
}

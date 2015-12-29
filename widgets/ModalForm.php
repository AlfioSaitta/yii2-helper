<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\widgets\ActiveForm;

/**
 * This renders a HTML component for pop up modal form.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class ModalForm extends Widget
{
    /**
     * @var boolean
     */
    public $hasHint = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if ($this->hasHint) {
            $this->getView()->registerJs(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/js/modal-hint.js')));
            $this->getView()->registerCss(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/css/hint.css')));
        }

        $this->getView()->registerJs(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/js/modal-submit.js')));
        $this->getView()->registerCss(file_get_contents(Yii::getAlias('@vendor/anli/yii2-helper/css/select2.css')));
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
    }
}

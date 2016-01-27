<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\widgets;

use anli\helper\assets\ToastrAsset;
use Yii;
use yii\bootstrap\Widget;
use yii\widgets\Pjax;

/**
 * This renders a HTML component for toastr.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class Toastr extends Widget
{
    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $content = '';

    /**
     * @var string
     */
    public $type = '';

    /**
     * @var boolean
     */
    public $useSessionFlash = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        ToastrAsset::register($this->getView());

        parent::init();
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
        if ($this->useSessionFlash)  {
            return $this->getView()->registerJs($this->sessionFlashJs);
        }

        $this->getView()->registerJs($this->getJs(
            $this->type,
            $this->content,
            $this->title
        ));

    }

    /**
     * @param $type string
     * @param $content string
     * @param $title string
     * @return string
     */
    public function getJs($type, $content, $title = '')
    {

        return <<< JS
                toastr.{$type}("$content", "$title");
JS;
    }

    /**
     * @return string
     */
    public function getSessionFlashJs()
    {
        $js = '';
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            $js .= $this->getJs($key, $message);
        }

        Yii::$app->session->removeAllFlashes();

        return $js;
    }

}

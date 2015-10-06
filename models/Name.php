<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\models;

use yii\base\model;
use Yii;

/**
 * This is the model class for Name.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class Name extends model
{
    /**
     * @var string
     */
    public $controllerUrl;

    /**
     * @return string
     */
    public function getProperName()
    {
        return str_replace('-', ' ', $this->controllerUrl);
    }

    public function getTitle()
    {
        return ucwords($this->properName) . 's';
    }
}

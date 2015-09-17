<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\models;

use app\models\Payment;
use yii\base\model;
use Yii;

/**
 * This is the model class for Gravatar.
 * @author Su Anli <anli@euqol.com>
 * @since 1.6.0
 */
class Gravatar extends model
{
    const URL_PREFIX = 'https://www.gravatar.com/avatar/';

    /**
     * @return string
     */
    public $email;

    /**
     * @return integer
     */
    public $size = 100;

    /**
     * @return string
     */
    public $default;

    /**
     * @return string
     */
    public function getImageUrl()
    {
        if (isset($this->email)) {
            return self::URL_PREFIX
                . $this->hash
                . $this->sizeParam
                . $this->defaultParam;
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getHash()
    {
        return md5(strtolower(trim($this->email)));
    }

    /**
     * @return string
     */
    protected function getSizeParam()
    {
        return "?s={$this->size}";
    }

    /**
     * @return string
     */
    protected function getDefaultParam()
    {
        if (isset($this->default)) {
            return '&d=' . urlencode($this->default);
        }

        return '';
    }
}

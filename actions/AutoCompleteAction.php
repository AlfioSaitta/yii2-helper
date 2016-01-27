<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\actions;

use Yii;
use yii\base\Action;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * This is the auto complete action class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.10.0
 */
class AutoCompleteAction extends Action
{
    /**
     * @var string
     */
    public $term;

    /**
     * @var mixed
     */
    public $query;

    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        $data = [];

        if ($this->term) {
            $data = $this->query->asArray()->all();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }
}

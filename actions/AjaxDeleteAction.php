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
 * This is the ajax delete action class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class AjaxDeleteAction extends Action
{
    /**
     * @var mixed
     */
    public $model;

    /**
     * @var string
     */
    public $successMsg = 'You have deleted a record';

    /**
     * @var string
     */
    public $errorMsg = 'You have failed to delete a record';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Runs the action
     *
     * @return string Return the result
     */
    public function run()
    {
        $model = $this->model;

        if ($model->delete()) {

            Yii::$app->getSession()->setFlash('success', $this->successMsg);

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => true,
            ];
        }

        Yii::$app->getSession()->setFlash('error', $this->errorMsg);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => false,
            'error' => print_r($model->getErrors()),
        ];
    }
}

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
use yii\helpers\Json;

/**
 * This is the update action class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class UpdateAction extends Action
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var mixed
     */
    public $model;

    /**
     * @var string
     */
    public $successMsg = 'You have updated a record';

    /**
     * @var string
     */
    public $errorMsg = 'You have failed to update a record';

    /**
     * @var string
     */
    public $view = 'update';

    /**
     * @var boolean
     */
    public $isSaveAndNew = false;

    /**
     * @var string
     */
    public $saveAndNewUrl = '';

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
     * @return string result content
     */
    public function run()
    {

        $model = $this->model;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                if ($this->isSaveAndNew) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return [
                        'message' => 'saveAndNew',
                        'saveAndNewUrl' => $this->saveAndNewUrl,
                    ];
                }

                //Yii::$app->getSession()->setFlash('success', $this->successMsg);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'message' => 'success',
                    'success' => true,
                ];
            }

            //Yii::$app->getSession()->setFlash('error', $this->errorMsg);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'error',
                'success' => false,
                'error' => Json::encode($model->getErrors()),
            ];
        }

        return $this->controller->renderAjax($this->view, array_merge([
            'model' => $model,
        ], $this->params));
    }
}

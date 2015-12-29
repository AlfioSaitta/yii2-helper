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
 * This is the list action class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class ListAction extends Action
{
    /**
     * @var mixed
     */
    public $view = 'list';

    /**
     * @var mixed
     */
    public $query;

    /**
     * @var mixed
     */
    public $searchModel;

    /**
     * @var array
     */
    public $params = [];

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
        $dataProvider = $this->searchModel->singleSearch(Yii::$app->request->queryParams, $this->query);

        return $this->controller->render($this->view, array_merge([
            'searchModel' => $this->searchModel,
            'dataProvider' => $dataProvider,
        ], $this->params));
    }
}

<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2014 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;

/**
 * DeleteAll delete all records for the model.
 *
 * To use DeleteAllAction, you need to do the following steps:
 *
 * First, declare an action of DeleteAllAction type in the `actions()` method of your `SiteController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * use anli\helper\actions\DeleteAll;
 *
 * public function actions()
 *     {
 *         return [
 *             'delete-all' => [
 *                'class' => 'sual0001\helper\actions\DeleteAllAction'
 *                'modelFullName' => self::MODEL_FULL_NAME(),
 *             ],
 *         ];
 *     }
 * ```
 *
 * Add the button to the view file:
 *
 * ```
 *
 * ```
 */
class DeleteAll extends Action
{
    /**
     * @var string
     */
    public $modelFullName;

    /**
     * @var string
     */
    public $tenantId;

    /**
     * @var boolean
     */
    public $noTenant = false;

    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        $model = $this->modelFullName;

        if (!$this->noTenant) {
            $model::deleteAll(['tenant_id' => $this->tenantId]);

            Yii::$app->getSession()->setFlash('success', 'You have deleted all selected records!');
            return $this->controller->goBack();

        } else {
            $model::deleteAll();

            Yii::$app->getSession()->setFlash('success', 'You have deleted all selected records!');
            return $this->controller->goBack();
            
        }

        Yii::$app->getSession()->setFlash('error', 'Delate All Action configuration error!');
		return $this->controller->goBack();
    }
}

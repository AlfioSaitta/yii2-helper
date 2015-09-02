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
use yii\web\UploadedFile;

/**
 * ImportAction import all records for the model.
 *
 * To use ImportAction, you need to do the following steps:
 *
 * First, declare an action of ImportAction type in the `actions()` method of your `SiteController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *        'import' => [
 *           'class' => 'anli\helpers\actions\ImportAction',
 *           'importModelName' => '\anli\rbac\models\UserRole',
 *           'syncField' => 'code',
 *           'attributes' => [
 *               'role' => [
 *                  'name' => 'role_id',
 *                  'model' => '\anli\rbac\models\Role',
 *                  'matchField' => 'name',
 *               ],
 *               'user' => [
 *                   'name' => 'user_id',
 *                   'model' => '\anli\user\models\User',
 *                   'matchField' => 'username',
 *                   'isApiModel' => true,
 *               ],
 *          ],
 *        ],
 *    ];
 * }
 * ```
 */
class ImportAction extends Action
{
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $defaultAttributes = [];

    /**
     * @var string
     */
    public $formModelName = '\anli\helper\models\ExcelImportForm';

    /**
     * @var string
     */
    public $importModelName = '';

    /**
     * @var string
     */
    public $importFormViewPath = '@vendor/anli/yii2-helper/views/excel/import-form';

    /**
     * @var string
     */
    public $syncField = '';

    /**
     * @var array
     */
    public $defaultValues = [];

    /**
     * @var string
     */
    protected $msg = '';

    /**
     * @var array
     */
    protected $header = [];

    /**
     * Runs the action
     *
     * @param string $defaultValuesJson The default values in JSON format
     * @return string result content
     */
    public function run($defaultValuesJson = '')
    {
        $modelName = $this->formModelName;
        $model = new $modelName;

        if ('' != $defaultValuesJson) {
            $this->defaultValues = $this->getDefaultValuesFromJson($defaultValuesJson);
        }

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($model, 'file');

            if ($this->import($this->getArrayFromExcel($file->tempName), $this->importModelName)) {
                Yii::$app->getSession()->setFlash('success', 'You have imported the excel!');
                return $this->controller->goBack();
            };

            Yii::$app->getSession()->setFlash('error', "You have failed to import the excel!\n{$this->msg}");
            return $this->controller->goBack();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        return $this->controller->renderAjax($this->importFormViewPath, [
            'model'=>$model,
            'importSafeAttributes' => $this->attributes
        ]);
    }

    /**
     * @return boolean
     */
    protected function import($data, $attributes)
    {
        $isSuccessful = true;
		$this->header = array_shift($data);
        $modelName = $this->importModelName;

		foreach ($data as $record) {

            $model = $this->getModelToImport($record);

			foreach ($this->header as $columnId => $attributeKey){ // i.e ['A' => 'role', 'B' => 'user']

				if (array_key_exists($attributeKey, $this->attributes)) {

                    $attributeName = $this->getAttributeName($attributeKey);
                    $model->$attributeName = $this->getAttributeValue($attributeKey, $record[$columnId]);
				}

                if (!empty($this->defaultValues)) {
                    foreach ($this->defaultValues as $key => $value) {
                        if (in_array($key, $this->defaultAttributes)) {
                            $model->$key = $value;
                        }
                    }
                }

			}

			if (!$model->save()) {
				$isSuccessful = false;
			};
		}

		return $isSuccessful;
    }

    /**
	 * @param string
     * @return array Return the array from the excel object
	 */
	protected function getArrayFromExcel($filePath)
	{
		$objPHPExcel = \PHPExcel_IOFactory::load($filePath);
		return $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	}

    /**
     * @param string $attributeKey
     * @return string
     */
    protected function getAttributeName($attributeKey)
    {
        $attribute = $this->attributes[$attributeKey];

        if (isset($attribute['name'])) {
            return $attribute['name'];
        }

        return $attribute;
    }

    /**
     * @param string $attributeKey
     * @param string $cellValue
     * @return mixed
     */
    protected function getAttributeValue($attributeKey, $cellValue)
    {
        $attribute = $this->attributes[$attributeKey];

        if (isset($attribute['model']) && (isset($cellValue))) {

            if (isset($attribute['isApiModel']) && $attribute['isApiModel']) {
                return $attribute['model']::findOne([$attribute['matchField'] => $cellValue])
                ->id;
            }

            return $attribute['model']::find()
            ->andWhere([$attribute['matchField'] => $cellValue])
            ->one()
            ->id;
        }

        return str_replace('_x000D_', '', $cellValue);
    }

    /**
     * @param string $json
     * @return array
     */
    protected function getDefaultValuesFromJson($json)
    {
        return \yii\helpers\Json::decode($json);
    }

    /**
     * @param array $record
     * @return mixed
     */
    protected function getModelToImport($record)
    {
        if ('' != $this->syncField) {
            $codeColumnId = array_search($this->syncField, $this->header);
            $codeFieldValue = $record[$codeColumnId];

            if (isset($codeFieldValue)) {

                $model = $this->importModelName;
                $query = $model::find()->andWhere([$this->syncField => $codeFieldValue]);

                if ($query->exists()) {
                    return $query->one();
                }
            }

            return new $this->importModelName;
        }

        return new $this->importModelName;
    }
}

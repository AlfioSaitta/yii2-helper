<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2014 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\models;

use yii\base\model;
use Yii;

/**
 * This is the model class for excel import form for any model
 *
 * @property string $start_date
 */
class ExcelImportForm extends model
{
	/**
	* @var The temporary file path of the excel on the server
	*/
	public $filePath;

	/**
	* @var import excel file
	*/
	public $file;

	/**
	* @var excel import form view path
	*/
	public $importFormViewPath = '@vendor/anli/yii2-helper/views/excel/import-form';


	/**
	 * @var array
	 */
	public $header = [];

    /**
     * @inheritdoc
     */
    public static function fontIcon()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['file'], 'safe'],
			[['file'], 'file', 'extensions'=>'xls, xlsx'],
		];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Import',
        ];
    }


	/**
	 * Return an array of tooltips for the table fields
	 * @return array
	 */
	public function toolTips()
	{
		return [];
	}

	/**
	 * Generate the tool tip template to use in form.
	 *
	 * @param string $field The table field name.
	 * @return string Return the tool tip template.
	 */
	public function getToolTipTemplate($field)
	{
		if (array_key_exists($field, $this->toolTips())) {
			$toolTip = Html::tag('span', "{label}", [
				'data-content'=> $this->toolTips()[$field],
				'data-toggle'=>'popover',
				'data-trigger'=>'hover',
				'style'=>'cursor:help; border-bottom: 1px dashed #888'
			]);

			return "$toolTip \n{input}\n{hint}\n{error}";
		}

		return "{label}\n{input}\n{hint}\n{error}";
	}

	/**
	 * Import the excel to the model using active record
	 * @param string $model The model name to save the excel rows into
	 * @param array $defaultValues The default values to be assigned
	 * @return Return true if all records is saved
	 */
	public function import($modelName, $defaultValues = [], $updateMultipleModel = false, $queryConfigs = [])
	{
		$isSuccessful = true;

		$sheetData = $this->arrayFromExcel;
		$this->header = array_shift($sheetData);

		foreach ($sheetData as $record) {

			if ($updateMultipleModel) {

				$parentId = $this->getParentId($queryConfigs['parentModel'], $queryConfigs['parentKey'],
				$record, $modelName, $defaultValues);

				$childModel = new $queryConfigs['childModel'];
				foreach ($queryConfigs['childModelArray'] as $key=>$value) {
					if (!is_array($value)) {
						$childModel->$value = $this->getCellValue($value, $childModel, $record, $key, false);
					} else {
						$childModel->$value['attribute'] = $this->getCellValue($value, $childModel, $record, $key, false);
					}
				}

				$childModel->$queryConfigs['childForeignKey'] = $parentId;
				$childModel->save();
			} else {

				$isSuccessful = $this->createModel($modelName, $defaultValues, $record);
			}
		}
		return $isSuccessful;
	}

	/**
	 * Get excel cell value. If the import safe attributes has the model declared, it will grab the id from that model instead of the cell value
	 * @param string $model The model name to save the excel rows into
	 * @param array $value The values to be assigned
	 * @param string $record The model name to save the excel rows into
	 * @param string $key The key
	 * @return Return true if all records is saved
	 */
	public function getCellValue($value, $model, $record, $key, $isParent = true)
	{
		if ($isParent) {
			if(isset($model->importSafeAttributes()[$value]) && is_array($model->importSafeAttributes()[$value])) {
				$array = $model->importSafeAttributes()[$value];

				return $array['model']::find()
				->andWhere([$array['fieldName'] => $record[$key]])
				->one()
				->id;
			}

			return isset($record[$key]) ? $record[$key] : '';
		}

		if (!is_array($value)) {
			return $record[array_search($key, $this->header)];
		}

		return $value['model']::find()
		->andWhere([$value['fieldName'] => $record[array_search($key, $this->header)]])
		->one()
		->id;
	}

	/**
	 * @return the array from the excel object
	 */
	protected function getArrayFromExcel()
	{
		$objPHPExcel = \PHPExcel_IOFactory::load($this->filePath);
		return $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	}

	/**
	 * @return mixed Return model id if creation is successful. Return false on error.
	 */
	protected function createModel($modelName, $defaultValues, $record)
	{
		$model = new $modelName;

		foreach ($this->header as $key => $value){
			if ($model->isImportSafeAttribute($value)) {
				$model->$value = $this->getCellValue($value, $model, $record, $key);
			}
		}

		$model->assignDefaultValues($defaultValues);

		if (!$model->save()) {
			return false;
		}

		return $model->id;
	}

	/**
	 * @return mixed Return parent id if parent model exists, else return boolean
	 */
	protected function getParentId($parentModel, $parentKey, $record, $modelName, $defaultValues)
	{
		//parent model
		$query = $parentModel::find()->andWhere([$parentKey => $record[array_search($parentKey, $this->header)]]);

		if ($query->exists()) {
			return $query->one()->id;
		}

		$isSuccessful = $this->createModel($modelName, $defaultValues, $record);
		return (0 == $isSuccessful) ? null : $isSuccessful;
	}
}

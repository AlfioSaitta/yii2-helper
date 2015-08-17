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
 * ExportAction export all records for the model.
 *
 * To use ExportAction, you need to do the following steps:
 *
 * First, declare an action of ExportAction type in the `actions()` method of your `SiteController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *        'export' => [
 *           'class' => 'sual0001\helpers\actions\ExportAction',
 *           'query' => UserRole::find(),
 *           'attributes' => [
 *               'user' => [
 *                   'relationship' => 'user',
 *                   'attribute' => 'username',
 *                   'header' => 'role.name',
 *               ],
 *               'role' => [
 *                   'relationship' => 'role',
 *                   'attribute' => 'name',
 *               ],
 *               'role_id' => 'role_id',
 *          ],
 *        ],
 *    ];
 * }
 * ```
 */
class ExportAction extends Action
{

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var mixed
     */
    public $query;

    /**
     * @var string The exported file name
     */
    public $file = 'export.xls';

    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getActiveSheet()->fromArray($this->excelData, null, 'A1');

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->file . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

        return true;
    }

    /**
     * @return array
     */
    protected function getExcelData()
    {
        $data[] = $this->header;

        $i = 1;
        foreach ($this->query->all() as $record) {
            foreach ($this->attributes as $key => $value) {
                $data[$i][$key] = $this->getAttributeValue($record, $key, $value);
            }

			$i++;
        }

		return $data;
    }

    /**
     * @return array Return the excel header
     */
    protected function getHeader()
    {
        $array = [];

        foreach ($this->attributes as $key => $value) {
            if (isset($value['header'])) {
                $array[] = $value['header'];
            } else {
                $array[] = $key;
            }
        }

        return $array;
    }

    /**
     * @param array $record
     * @param string $key
     * @param string $value
     * @return mixed
     */
    protected function getAttributeValue($record, $key, $value)
    {
        if (isset($value['key'])) {
            $key = $value['key'];
        }

        if (isset($record->$key)) {
            if (isset($value['relationship'])) {
                $relationship = $value['relationship'];
                $attribute = $value['attribute'];

                return $record->$relationship->$attribute;
            }

            return $record->$value;
        }

        return '';
    }
}

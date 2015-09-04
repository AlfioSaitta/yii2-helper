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
 * This is the excel export form model class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class ExcelExportForm extends model
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
    public function export()
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

<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\actions;

use mPDF;
use Yii;
use yii\base\Action;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * This is the envelope action class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.6.0
 */
class EnvelopeAction extends Action
{
    /**
     * Expect a value of:
     * [
     *      ['imageUrl' => '', 'principal' => '', 'principalDetail' => '', 'name' => '', 'address' => '', 'attn' => '']
     *      ['imageUrl' => '', 'principal' => '', 'principalDetail' => '', 'name' => '', 'address' => '', 'attn' => '']
     * ]
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $envelopeSize = 'DL';

    /**
     * @var string
     */
    public $envelopeViewPath = '@vendor/anli/yii2-helper/views/envelope/print';

    /**
     * @var string
     */
    public $adjustment = '';

    /**
     * @var string
     */
    public $adjustmentPadding = '';

    /**
     * @var string
     */
    public $adjustmentFont = '';

    /**
     * @var string
     */
    public $adjustmentLabelFont = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!empty($this->data)) {
            $this->data = call_user_func($this->data);
        }
    }

    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        $mpdf = $this->mpdf;
        foreach ($this->data as $record) {
			$mpdf->AddPage();

			$mpdf->WriteHTML($this->controller->renderPartial(
				$this->envelopeViewPath,
				[
					'data' => $record,
                    'adjustment' => $this->adjustment,
                    'adjustmentPadding' => $this->adjustmentPadding,
                    'adjustmentFont' => $this->adjustmentFont,
                    'adjustmentLabelFont' => $this->adjustmentLabelFont,
				]
			),2);
		}

		$mpdf->Output();
    }

    /**
     * @return mixed
     */
    protected function getMpdf()
    {
        switch ($this->envelopeSize) {
			case 'DL':
				$format=['220','99'];
				$this->adjustment='padding-top: 2%; font-size: 14pt;';
				$this->adjustmentPadding='padding-top: 0%;';
				$this->adjustmentFont='font-size: 8pt;';
				$this->adjustmentLabelFont='font-size: 6pt;';
				break;
			case 'C5':
				$format='C5-L';
				$this->adjustment='padding-top: 15%; font-size: 18pt;';
				$this->adjustmentPadding='padding-top: 10%;';
				$this->adjustmentFont='font-size: 15pt;';
				$this->adjustmentLabelFont='font-size: 12pt;';
				break;
			case 'C4':
				$format='C4-L';
				$this->adjustment='padding-top: 20%; padding-left: 10%; font-size: 20pt;';
				$this->adjustmentPadding='padding-top: 15%;';
				$this->adjustmentFont='font-size: 16pt;';
				$this->adjustmentLabelFont='font-size: 12pt;';
				break;
		}

		$mpdf = new mPDF('', $format, 0, '', 9, 9, 25, 9, 9, 9);
		$url = Yii::getAlias('@vendor/anli/yii2-helper/css/mpdf.css');
		$stylesheet = file_get_contents($url);
		$mpdf->WriteHTML($stylesheet, 1);

		return $mpdf;
    }
}

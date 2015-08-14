<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2014 Su Anli
 * @license http://www.euqol.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\widgets\AlertBlock;
use anli\metronic\widgets\Portlet;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model sual0001\claim\models\Claim */

$this->title = 'Import From Excel';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- BEGIN ROW 1 -->
<div class="row">
<!-- BEGIN Column 1 -->
<div class="col-md-12">

<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
    'options'=>['enctype'=>'multipart/form-data']
]); ?>

<!-- BEGIN Portlet -->
<?php Portlet::begin([
    'title' => $this->title,
    'fontIcon' => $model->fontIcon(),
    'buttons' => [
        Html::submitButton('<i class="fa fa-check"></i> <u>U</u>pload', [
            'name' => 'excel-import-btn',
            'class' => 'btn green-haze btn-circle',
            'accesskey' => 'u',
        ]),
    ],
]); ?>
    <div class="alert alert-warning">
        <p>
            <strong>Note: </strong> The excel should have the following headers:<br/>
            <?php foreach($importSafeAttributes as $key => $value): ?>
                <?php if (is_array($value)): ?>
                    * <?= Html::encode($key);?><br/>
                <?php endif; ?>
                <?php if (!is_array($value)): ?>
                    * <?= Html::encode($value);?><br/>
                <?php endif; ?>
            <?php endforeach;?>
        </p>

    </div>

    <!-- BEGIN file -->
    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
        'options'=>[],
        'pluginOptions'=>['allowedFileExtensions'=>['xls','xlsx']
    ]]);  ?>
    <!-- END file -->

<?php Portlet::end(); ?>
<!-- END Portlet -->

<?php ActiveForm::end(); ?>
<!-- END Column 1 -->
</div>
<!-- END ROW 1 -->
</div>

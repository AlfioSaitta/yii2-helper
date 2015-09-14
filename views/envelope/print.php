<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $array anli\helper\actions\EnvelopeAction */

?>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%">
	<tr>
		<?php if('' != $data['imageUrl']): ?>
		<td width="10%" style="text-align: right; padding-right: 2mm">
			<?= Html::img($data['imageUrl'], ['width' => '50px', 'alt' => '']);?>
		</td>
		<?php endif; ?>
		<td width="90%">
			<span style="font-weight: bold"><?= Html::encode($data['principal']); ?></span><br />
			<small><?= Html::encode($data['principalDetail']); ?>
			</small>
		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td style="text-align: right;">

		</td>
	</tr>
</table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<table width="100%">
	<tr>
		<td style="text-align: right;">
			Private and confidential
		</td>
	</tr>
</table>
<div style="font-size: 20pt; text-align: right; font-weight: bold; ">

</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%">
	<tr>
		<td width="25%">
		</td>
		<td width="75%" style="<?php echo $adjustment ?>">
			<span>
				<?= Html::encode($data['name']);?><br/><br/>
				<?= (isset($data['address']) ? Yii::$app->formatter->asNText($data['address']) : ''); ?>
			</span>
			<?php
				if ('' != $data['attn'])
				{
					echo '<br/><br/>';
					echo '<span style="text-decoration: underline">';
					echo 'Attn: ' . Html::encode($data['attn']);
					echo '</span>';
				}
			?>
		</td>
	</tr>
</table>

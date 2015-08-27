anli\helper
===========
Helper for Yii 2.0

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist anli/yii2-helper "*"
```

or add

```
"anli/yii2-helper": "*"
```

to the require section of your `composer.json` file.


Copy the contents of the `js` folder to the `@web/js/` folder.

Modal
-----

Add to your layout file:

    use anli\helper\assets\ModalAsset;
    ...
    <!-- BEGIN MODAL -->
    <?php Modal::begin(['id' => 'modal', 'size' => 'modal-lg',]);
        echo "<div id='modalContent'><div style=\"text-align:center\">" . Html::img('@web/images/ajax-loader.gif') . "</div></div>";
    Modal::end();?>
    <!-- END MODAL -->

To create a button to open a modal, update its `value` to the controller url and `class` to `showModalButton`. For example:

    Html::a('<i class="fa fa-plus"></i>', false, ['value' => Url::to(['tenant/create']), 'title' => 'Create Tenant', 'class' => 'showModalButton btn btn-circle green-haze btn-sm'])

To use ajax validation and submit:

Update the controller action with:

```
$model = new Tenant();

if ($model->load(Yii::$app->request->post()) && $model->save()) {
     Yii::$app->response->format = Response::FORMAT_JSON;
     return [
        'message' => 'successful',
     ];
}

if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
    Yii::$app->response->format = Response::FORMAT_JSON;
    return \yii\widgets\ActiveForm::validate($model);
}

return $this->renderAjax('create', [
    'model' => $model
]);
```

Update the view `_form` with:

    <?php $form = ActiveForm::begin(['id' => $model->formName(),
        'options' => ['class' => 'modalSubmit'],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>

Import Action
-----

Add the button in the view page:

    Html::a('<i class="fa fa-download"></i>', false, ['value' => Url::to(['tenant/import']), 'title' => 'Import Tenant', 'class' => 'showModalButton btn btn-circle blue btn-sm']),

Add to the `actions` function in your controller:

    'import' => [
        'class' => 'anli\helper\actions\ImportAction',
        'importModelName' => '\anli\auth0\models\Tenant',
        'attributes' => [
            'name' => 'name',
        ],
    ],

Export Action
-----

Add the button in the view page:

    Html::a('<i class="fa fa-cloud-download"></i>', ['tenant/export'], ['title' => 'Export Tenant', 'class' => 'btn btn-circle yellow btn-sm', 'data-pjax' => 0]),

Add to the `actions` function in your controller:

    'export' => [
        'class' => 'anli\helper\actions\ExportAction',
        'query' => Tenant::find(),
        'attributes' => [
            'name' => 'name',
        ],
    ],

Checkbox column in Gridview
-----

In the view page, add to the `columns` section in the GridView widget with:

    ...
    ->checkbox()
    ...

Add `checkbox()` function to the model Column file with:

```
/**
 * @return mixed
 */
public function checkbox()
{
    $this->columns = array_merge($this->columns, [
        [
            'class' => 'yii\grid\CheckboxColumn',
        ],
    ]);
    return $this;
}
```

Add the button to the view page with:

    Html::a('<i class="fa fa-trash"></i> Delete selected', '#', ['title' => 'Delete Selected Tenant', 'class' => 'selectCheckboxButton', 'value-url' => 'http://url/to/controller/action', 'value-id' => 'my-gridview-id',]);

Add the `action` to the controller with:

```
/**
 * @param string
 * @return string
 */
public function actionDeleteCheckbox($keylist)
{
    $keylist = explode(",", $keylist);

    $count = count($keylist);

    foreach ($keylist as $id) {
        $this->findModel($id)->delete();
    }

    Yii::$app->getSession()->setFlash('success', "You have deleted $count tenant!");

    return $this->goBack();

    Yii::$app->response->format = Response::FORMAT_JSON;
    return [
       'message' => $keylist,
    ];
}
```

Button Group
-----

Add to view page with:

    use anli\metronic\widgets\ButtonGroup;
    ...

    ButtonGroup::widget(['buttons' => [$button1, $button2, $button3]])

Delete All Action
-----

Add to your controller `actions` function with:

    use anli\helper\actions\DeleteAll;
    ...
    return [
        'delete-all' => [
        'class' => 'sual0001\helper\actions\DeleteAllAction'
        'modelFullName' => self::MODEL_FULL_NAME(),
        'conditions' => ['tenant_id' => Yii::$app->tenant->identity->id, 'user_id' => Yii::$app->user->id],
    ],

Calendar Heatmap
-----

Download the heatmap files from [here](https://github.com/kamisama/cal-heatmap/archive/master.zip) and unzip the contents to your `@web/cal-heatmap/`.

Add to your view file with:

    anli\helper\assets\CalHeatmapAsset::register($this);
    ...
    <div id="cal-heatmap" align="center"></div>
    <script type="text/javascript">
        now = new Date();
        now.setMonth(now.getMonth() - 1);

        var cal = new CalHeatMap();
    	cal.init({
        	domain: "month",
        	subDomain: "x_day",
            data: "http://localhost:8100/user/get-timesheet-heatmap-data",
        	start: now,
        	cellSize: 20,
        	cellPadding: 5,
        	domainGutter: 20,
        	range: 2,
        	domainDynamicDimension: false,
        	//subDomainTextFormat: "%d",
            highlight: "now",
            tooltip: false,
        	legend: [2, 4, 6, 8]
        });
    </script>

Add to your controller file with:

```
/**
 * @param mixed $id
 * @return string
 */
public function actionGetTimesheetHeatmapData($id = null)
{
    if (!isset($id)) {
        $id = Yii::$app->user->id;
    }

    $query = $this->findModel($id)
    ->getTimesheets()
    ->select('timesheet_date, sum(work_hour) AS work_hour')
    ->groupBy('timesheet_date');

    $data = [];
    foreach ($query->all() as $record) {
        $date = new \DateTime($record->timesheet_date);
        $data[$date->getTimestamp()] = (float)$record->work_hour;
    }

    Yii::$app->response->format = Response::FORMAT_JSON;
    return $data;
}
```

Cal Heatmap
-----

Add your view file with:

    use anli\helper\widgets\CalHeatmap;
    ...
    <?= CalHeatmap::widget(['url' => ['user/get-timesheet-heatmap-data']]); ?>

Add your controller with:

```
/**
 * @param mixed $id
 * @return string
 */
public function actionGetTimesheetHeatmapData($id = null)
{
    if (!isset($id)) {
        $id = Yii::$app->user->id;
    }

    $query = $this->findModel($id)
    ->getTimesheets()
    ->select('timesheet_date, sum(work_hour) AS work_hour')
    ->groupBy('timesheet_date');

    $data = [];
    foreach ($query->all() as $record) {
        $date = new \DateTime($record->timesheet_date);
        $data[$date->getTimestamp()] = (float)$record->work_hour;
    }

    Yii::$app->response->format = Response::FORMAT_JSON;
    return $data;
}
```

Morris Js
-----

Add to your view with:

    use anli\helper\widgets\MorrisJs;
    ...
    <?= MorrisJs::widget(['url' => Url::to(['timesheet/get-morris-js', 'userId' => $user->id]), 'xkey' => "'period'", 'ykeys' => "['worked']", 'labels' => "['Hours']"]); ?>

Add to your controller with:

```
/**
 * @return string
 */
public function actionGetMorrisJs($userId = null)
{
    $user = User::findOne($userId);

    $array = [];
    $x = 0;
    for ($i = 6; $i >= 0 ; $i--) {
        $date = new \DateTime("today -$i months");
        $array[$x]['period'] = $date->format('F Y');
        $array[$x]['worked'] = (float)$user->getTimesheets()->byTimesheetMonth($date->format('Y-m-01'))->sum('work_hour');
        $x++;
    }

    Yii::$app->response->format = Response::FORMAT_JSON;
    return [
        'data' => $array,
        'xkey' => "'period'",
        'ykeys' => "['worked']",
        'labels' => "['Hours']",
    ];
}
```

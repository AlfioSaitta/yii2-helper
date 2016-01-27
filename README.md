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

    ...
    return [
        'delete-all' => [
            'class' => 'anli\helper\actions\DeleteAllAction',
            'modelFullName' => self::MODEL_FULL_NAME,
            'conditions' => ['tenant_id' => Yii::$app->tenant->identity->id, 'user_id' => Yii::$app->user->id],
        ],

Cal Heatmap
-----

Add your view file with:

    use anli\helper\widgets\CalHeatmap;
    ...
    <?= CalHeatmap::widget(['url' => ['timesheet/get-timeslip-heatmap-data'], 'id' => 'timeslip-heatmap', 'legend' => '[1]', 'legendColors' => '["#efefef", "maroon"]', 'onClickUrl' => Url::to(['timesheet/list', 'userId' => Yii::$app->user->id])]); ?>

For the heatmap data add your controller with:

```
/**
 * @param mixed $id
 * @return string
 */
public function actionGetTimeslipHeatmapData($id = null)
{
    if (!isset($id)) {
        $id = Yii::$app->user->id;
    }

    $data = [];
    foreach (User::findOne($id)->timeslips as $record) {
        $date = new \DateTime($record['timesheet_date']);
        $data[$date->getTimestamp()] = (float)1;
    }

    Yii::$app->response->format = Response::FORMAT_JSON;
    return $data;
}
```

For the `onClickJs` event, add your controller with:

```
/**
 * @param integer $userId
 * @param integer $timesheetDate
 * @return mixed
 */
 public function actionList($userId, $date)
 {
     return $this->renderAjax('list', [
         'query' => Timesheet::find()
            ->byUser($userId)
            ->byTimesheetDate(strtotime($date))
     ]);
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

Date Paginator
-----

Add to your view file with:

    use anli\helper\widgets\DatePaginator;
    ...
    <?php
        $selectedDate = (0 < $dataProvider->totalCount) ? $dataProvider->getModels()[0]['timesheet_date'] : Yii::$app->getRequest()->getQueryParam('TimesheetSearch')['timesheet_date'];

        echo DatePaginator::widget(['id' => 'timesheet-date-paginator', 'selectedDate' => $selectedDate,
            'queryUrl' => Url::to(['/user/dashboard']) . '?TimesheetSearch%5Btimesheet_date%5D=',
        ]);
    ?>

Change your controller with:

```
/**
 * Logout a user with auth0
 * @return mixed
 */
public function actionDashboard()
{
    Yii::$app->user->setReturnUrl(['/' . $this->getRoute()]);

    $query = Timesheet::find()
    ->byUser()
    ->orderBy('timesheet_date DESC, start_time DESC');

    if (null === (Yii::$app->getRequest()->getQueryParam('TimesheetSearch')['timesheet_date'])) {
        $query->byTimesheetDate(strtotime(User::LoginUser()->getTimesheets()->max('timesheet_date')));
    }

    $searchModel = new TimesheetSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

    return $this->render('dashboard', [
        'user' => User::LoginUser(),
        'timesheetQuery' => $query,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]);
}
```

Create Action
-----

Add to the `action` section of your controller with:

```
'copy' => [
    'class' => 'anli\helper\actions\CreateAction',
    'model' => new Timesheet,
    'defaultValues' => function () {
        $model = Timesheet::findOne(Yii::$app->getRequest()->getQueryParam('id'));
        return [
            'timesheet_date' => date('Y-m-d'),
            'start_time' => Timesheet::find()->byUser()->byTimesheetDate('now')->max('end_time'),
            'customer_id' => $model->customer_id,
            'is_chargeable' => $model->is_chargeable,
            'period_start_date' => $model->period_start_date,
            'period_end_date' => $model->period_end_date,
            'name' => $model->name,
        ];
    }
    'isSaveAndNew' => (isset($_POST['save-and-new'])),
    'saveAndNewUrl' => Url::to(['timesheet/create']),
],
```

Update Action
-----

Add to the `action` section of your controller with:
```
'update' => [
    'class' => 'anli\helper\actions\UpdateAction',
    'model' => Timesheet::findOne(Yii::$app->getRequest()->getQueryParam('id')),
    'isSaveAndNew' => (isset($_POST['save-and-new'])),
    'saveAndNewUrl' => Url::to(['timesheet/create']),
],
```

Toastr
-----

Add to your layout:

```
<?php Pjax::begin(['id' => 'pjax-message']); ?>
<?php anli\helper\widgets\Toastr::widget(); ?>
<?php Pjax::end(); ?>
```

Auto Complete
-----

Add to your form:

```
<?= $form->field($model, 'name')->widget(AutoComplete::classname(), [
    'clientOptions' => [
        'source'=> new JsExpression("function(request, response) {
            $.getJSON('" . Url::to(['/invoice/name-auto-complete']) . "', {
                term: request.term,
                supplierId: $(\"#invoice-supplier_id\").val(),
            }, response);
        }"),
        'minLength' => 2,
    ],
    'options' => ['class' => 'form-control', 'placeholder' => 'Filter as you type ...'],
]); ?>
```

Add to the action section of your controller:

```
'name-auto-complete' => [
    'class' => 'anli\helper\actions\AutoCompleteAction',
    'query' => Invoice::find()
        ->select(['name as label'])
        ->andWhere(['supplier_id' => Yii::$app->getRequest()->getQueryParam('supplierId')])
        ->andWhere(['like', 'name', Yii::$app->getRequest()->getQueryParam('term')])
        ->limit(20)
        ->distinct(),
    'term' => Yii::$app->getRequest()->getQueryParam('term'),
],
```

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

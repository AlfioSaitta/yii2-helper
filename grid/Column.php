<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\grid;

use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the base column class.
 *
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class Column
{
    public $controller = '';

    /**
     * @var array
     */
    public $columns = [];

    /**
     * @return array
     */
    public function all()
    {
        return $this->columns;
    }

    /**
     * @return string $template
     * @return mixed
     */
    public function actions($template = '{update} {delete}')
    {
        $this->columns = array_merge($this->columns, [
            [
                'class' => ActionColumn::className(),
                'controller' => $this->controller,
                'template' => $template,
                'buttons' => [
                    'ajax-update' => function ($url, $model) {
                        return Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']),
                            false,
                            [
                                'value' => Url::to(["$this->controller/ajax-update", 'id' => $model->id, 'pjaxId' => 'list-pjax']),
                                'data-toggle' => 'tooltip',
                                'title' => 'Update',
                                'class' => 'showModalButton'
                            ]
                        );
                    },
                    'ajax-delete' => function ($url, $model) {
                        return  Html::a('<span  class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'ajaxDelete',
                            'delete-url' => Url::to(["$this->controller/ajax-delete", 'id' => $model->id]),
                            'pjax-container' => 'list-pjax',
                        ]);
                    },
                ],
                'contentOptions' => ['class' => 'text-right'],
            ]
        ]);
        return $this;
    }

    /**
     * @param boolean
     * @return mixed
     */
    public function checkbox($show = true)
    {
        if ($show) {
            $this->columns = array_merge($this->columns, [['class' => '\yii\grid\CheckboxColumn']]);
            return $this;
        }
        return $this;
    }

    /**
     * @param mixed
     * @return mixed
     */
    public function raw($value = '')
    {
        $this->columns = array_merge($this->columns, $value);
        return $this;
    }
}

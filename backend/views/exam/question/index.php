<?php

use yii\grid\GridView;
use common\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = '试题管理';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

?>

<div class="row">
    <div class="col-12 col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::create(['create']); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'type',
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map($types, 'id', 'name'), [
                                'class' => 'form-control',
                                'prompt' => '全部',
                            ]),
                            'value' => function ($model) use ($types) {
                                $typeList = ArrayHelper::map($types, 'id', 'name');
                                return $typeList[$model->type] ?? $model->type;
                            },
                        ],
                        [
                            'attribute' => 'content',
                            'format' => 'ntext',
                            'headerOptions' => ['style' => 'max-width: 300px'],
                            'contentOptions' => ['style' => 'max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'],
                        ],
                        [
                            'attribute' => 'course',
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'course', ArrayHelper::map($courses, 'id', 'name'), [
                                'class' => 'form-control',
                                'prompt' => '全部',
                            ]),
                            'value' => function ($model) use ($courses) {
                                $courseList = ArrayHelper::map($courses, 'id', 'name');
                                return $courseList[$model->course] ?? $model->course;
                            },
                        ],
                        [
                            'attribute' => 'period',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'label' => '分类',
                            'attribute' => 'category_ids',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (empty($model->category_ids)) {
                                    return '-';
                                }
                                $ids = explode(',', $model->category_ids);
                                return Html::tag('span', implode(', ', $ids), ['class' => 'label label-outline-info']);
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'status', [
                                '1' => '启用',
                                '0' => '禁用',
                            ], [
                                'class' => 'form-control',
                                'prompt' => '全部',
                            ]),
                            'value' => function ($model) {
                                if ($model->status == 1) {
                                    return Html::tag('span', '启用', ['class' => 'label label-outline-success']);
                                }
                                return Html::tag('span', '禁用', ['class' => 'label label-outline-default']);
                            },
                        ],
                        [
                            'attribute' => 'pubdate',
                            'format' => ['date', 'php:Y-m-d H:i'],
                            'filter' => false,
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', ['view', 'id' => $model->id], [
                                        'class' => 'btn btn-info btn-sm',
                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::edit(['update', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

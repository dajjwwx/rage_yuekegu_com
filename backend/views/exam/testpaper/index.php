<?php

use yii\grid\GridView;
use common\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = '试卷管理';
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
                            'attribute' => 'title',
                            'contentOptions' => ['style' => 'min-width: 200px;'],
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
                            'attribute' => 'type',
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'type', [
                                '' => '全部',
                                '1' => '练习',
                                '2' => '考试',
                                '3' => '模拟',
                            ], [
                                'class' => 'form-control',
                            ]),
                            'value' => function ($model) {
                                $typeMap = [
                                    '1' => '练习',
                                    '2' => '考试',
                                    '3' => '模拟',
                                ];
                                return $typeMap[$model->type] ?? $model->type;
                            },
                        ],
                        [
                            'attribute' => 'grade',
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'created',
                            'format' => ['date', 'php:Y-m-d H:i'],
                            'filter' => false,
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {questions} {update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', ['view', 'id' => $model->id], [
                                        'class' => 'btn btn-info btn-sm',
                                    ]);
                                },
                                'questions' => function ($url, $model, $key) {
                                    return Html::a('题目管理', ['questions', 'id' => $model->id], [
                                        'class' => 'btn btn-success btn-sm',
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

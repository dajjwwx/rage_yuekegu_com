<?php

use common\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = '题目管理 - ' . Html::encode($testpaper->title);
$this->params['breadcrumbs'][] = ['label' => '试卷管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($testpaper->title), 'url' => ['view', 'id' => $testpaper->id]];
$this->params['breadcrumbs'][] = '题目管理';
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::a('添加题目', ['add-question', 'id' => $testpaper->id], ['class' => 'btn btn-primary btn-sm']); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?php if (empty($questions)): ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> 该试卷暂无题目，请点击上方"添加题目"按钮添加。
                </div>
                <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">题号</th>
                            <th class="col-md-1">题目ID</th>
                            <th>题型</th>
                            <th>分值</th>
                            <th class="col-md-2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questions as $q): ?>
                        <tr>
                            <td><?= $q->question_num ?></td>
                            <td>
                                <?= Html::a($q->question_id, ['/exam/question/view', 'id' => $q->question_id], [
                                    'target' => '_blank',
                                    'class' => 'blue',
                                ]) ?>
                            </td>
                            <td>
                                <?php
                                $typeList = ArrayHelper::map($types, 'id', 'name');
                                echo $typeList[$q->question_type] ?? '未知(' . $q->question_type . ')';
                                ?>
                            </td>
                            <td><?= $q->score ?></td>
                            <td>
                                <?= Html::delete(['remove-question', 'id' => $testpaper->id, 'question_id' => $q->question_id], '移除', [
                                    'onclick' => "return confirm('确定要移除此题目吗？');",
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
            <div class="box-footer">
                <?= Html::a('返回试卷', ['view', 'id' => $testpaper->id], ['class' => 'btn btn-white']); ?>
                <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-white']); ?>
            </div>
        </div>
    </div>
</div>

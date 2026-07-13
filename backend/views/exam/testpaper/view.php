<?php

use common\helpers\Html;
use common\helpers\Url;

$this->title = '试卷详情';
$this->params['breadcrumbs'][] = ['label' => '试卷管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::a('题目管理', ['questions', 'id' => $model['id']], ['class' => 'btn btn-success btn-sm']); ?>
                    <?= Html::edit(['update', 'id' => $model['id']]); ?>
                    <?= Html::delete(['delete', 'id' => $model['id']]); ?>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="col-sm-2 text-right" style="background: #f8f9fa;">ID</th>
                        <td><?= $model['id'] ?></td>
                        <th class="col-sm-2 text-right" style="background: #f8f9fa;">标题</th>
                        <td><?= Html::encode($model['title']) ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">学科</th>
                        <td><?= $model['course_name'] ?: $model['course'] ?></td>
                        <th class="text-right" style="background: #f8f9fa;">学段</th>
                        <td><?= $model['period'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">年级</th>
                        <td><?= $model['grade'] ?? '-' ?></td>
                        <th class="text-right" style="background: #f8f9fa;">类型</th>
                        <td>
                            <?php
                            $typeMap = ['1' => '练习', '2' => '考试', '3' => '模拟'];
                            echo $typeMap[$model['type']] ?? $model['type'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">创建时间</th>
                        <td><?= !empty($model['created']) ? date('Y-m-d H:i', $model['created']) : '-' ?></td>
                        <th class="text-right" style="background: #f8f9fa;">用户ID</th>
                        <td><?= $model['user_id'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">允许辅助</th>
                        <td colspan="3">
                            <?php if (($model['allow_assistance'] ?? 0) == 1): ?>
                                <span class="label label-outline-success">允许</span>
                            <?php else: ?>
                                <span class="label label-outline-default">不允许</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if (!empty($model['content'])): ?>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">描述</th>
                        <td colspan="3"><?= nl2br(Html::encode($model['content'])) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php if (!empty($model['questions'])): ?>
                <div class="box-header with-border" style="margin-top: 20px;">
                    <h3 class="box-title">题目列表（共 <?= count($model['questions']) ?> 题）</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>题号</th>
                                <th>题目ID</th>
                                <th>题型</th>
                                <th>分值</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model['questions'] as $q): ?>
                            <tr>
                                <td><?= $q['question_num'] ?></td>
                                <td><?= $q['question_id'] ?></td>
                                <td><?= Html::encode($q['question_type'] ?? '-') ?></td>
                                <td><?= $q['score'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="box-footer">
                <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-white']); ?>
            </div>
        </div>
    </div>
</div>

<?php

use common\helpers\Html;
use common\helpers\Url;

$this->title = '试题详情';
$this->params['breadcrumbs'][] = ['label' => '试题管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::edit(['update', 'id' => $model['id']]); ?>
                    <?= Html::delete(['delete', 'id' => $model['id']]); ?>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="col-sm-2 text-right" style="background: #f8f9fa;">ID</th>
                        <td><?= $model['id'] ?></td>
                        <th class="col-sm-2 text-right" style="background: #f8f9fa;">UUID</th>
                        <td><?= $model['uuid'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">题型</th>
                        <td><?= $model['type_name'] ?: $model['type'] ?></td>
                        <th class="text-right" style="background: #f8f9fa;">学科</th>
                        <td><?= $model['course_name'] ?: $model['course'] ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">学段</th>
                        <td><?= $model['period'] ?? '-' ?></td>
                        <th class="text-right" style="background: #f8f9fa;">分值</th>
                        <td><?= $model['score'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">状态</th>
                        <td>
                            <?php if (($model['status'] ?? 1) == 1): ?>
                                <span class="label label-outline-success">启用</span>
                            <?php else: ?>
                                <span class="label label-outline-default">禁用</span>
                            <?php endif; ?>
                        </td>
                        <th class="text-right" style="background: #f8f9fa;">难度</th>
                        <td><?= $model['rate'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">来源</th>
                        <td><?= $model['source'] ?? '-' ?></td>
                        <th class="text-right" style="background: #f8f9fa;">来源编号</th>
                        <td><?= $model['source_num'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">分类</th>
                        <td colspan="3">
                            <?php if (!empty($model['categories'])): ?>
                                <?php foreach ($model['categories'] as $cat): ?>
                                    <span class="label label-outline-info"><?= Html::encode($cat['name']) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">标签</th>
                        <td colspan="3"><?= $model['tags'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th class="text-right" style="background: #f8f9fa;">发布时间</th>
                        <td><?= !empty($model['pubdate']) ? date('Y-m-d H:i', $model['pubdate']) : '-' ?></td>
                        <th class="text-right" style="background: #f8f9fa;">用户ID</th>
                        <td><?= $model['user_id'] ?? '-' ?></td>
                    </tr>
                </table>

                <?php if (!empty($model['content'])): ?>
                <div class="box-header with-border" style="margin-top: 20px;">
                    <h3 class="box-title">题干内容</h3>
                </div>
                <div class="box-body">
                    <div class="well well-sm">
                        <?= nl2br(Html::encode($model['content']['content'] ?? '')) ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($model['answer'])): ?>
                <div class="box-header with-border" style="margin-top: 20px;">
                    <h3 class="box-title">答案与解析</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="col-sm-2 text-right" style="background: #f8f9fa;">答案</th>
                            <td><?= Html::encode($model['answer']['answer'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th class="text-right" style="background: #f8f9fa;">解析</th>
                            <td><?= Html::encode($model['answer']['analyze'] ?? '-') ?></td>
                        </tr>
                        <?php if (!empty($model['answer']['comment'])): ?>
                        <tr>
                            <th class="text-right" style="background: #f8f9fa;">评语</th>
                            <td><?= Html::encode($model['answer']['comment']) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>

                <?php if (!empty($model['options'])): ?>
                <div class="box-header with-border" style="margin-top: 20px;">
                    <h3 class="box-title">选项列表</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>选项标识</th>
                                <th>选项内容</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model['options'] as $index => $option): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= Html::encode($option['item'] ?? '-') ?></td>
                                <td><?= Html::encode($option['content'] ?? '-') ?></td>
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

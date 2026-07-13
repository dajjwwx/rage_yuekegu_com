<?php

/* @var $this yii\web\View */

$this->title = 'Rage Exam - 在线考试系统';
?>
<div class="site-index">

    <!-- Hero Section -->
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Rage Exam</h1>
        <p class="lead">智能在线考试与组卷系统</p>
    </div>

    <!-- Exam Module Entry -->
    <div class="exam-module-section mb-5">
        <h2 class="text-center mb-4">📖 考试模块</h2>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-center h-100 shadow-sm border-primary">
                    <div class="card-body d-flex flex-column">
                        <div class="card-icon mb-3" style="font-size: 2.5rem;">📝</div>
                        <h5 class="card-title">试题浏览</h5>
                        <p class="card-text text-muted small">浏览、搜索和管理所有考试题目</p>
                        <a href="/exam/question/index" class="btn btn-outline-primary mt-auto stretched-link">进入题库 →</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-center h-100 shadow-sm border-success">
                    <div class="card-body d-flex flex-column">
                        <div class="card-icon mb-3" style="font-size: 2.5rem;">📋</div>
                        <h5 class="card-title">试卷库</h5>
                        <p class="card-text text-muted small">查看已有试卷，支持导出与预览</p>
                        <a href="/exam/testpaper/index" class="btn btn-outline-success mt-auto stretched-link">查看试卷 →</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-center h-100 shadow-sm border-warning">
                    <div class="card-body d-flex flex-column">
                        <div class="card-icon mb-3" style="font-size: 2.5rem;">➕</div>
                        <h5 class="card-title">手动组卷</h5>
                        <p class="card-text text-muted small">从题库中手动选题，灵活组成试卷</p>
                        <a href="/exam/testpaper/create" class="btn btn-outline-warning mt-auto stretched-link">开始组卷 →</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-center h-100 shadow-sm border-info">
                    <div class="card-body d-flex flex-column">
                        <div class="card-icon mb-3" style="font-size: 2.5rem;">🤖</div>
                        <h5 class="card-title">智能组卷</h5>
                        <p class="card-text text-muted small">按题型、数量、难度自动生成试卷</p>
                        <a href="/exam/testpaper/smart" class="btn btn-outline-info mt-auto stretched-link">智能生成 →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Body Content -->
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>关于系统</h2>
                <p>Rage Exam 是一套基于 Yii 框架开发的在线考试与组卷系统，支持手动组卷和智能组卷，满足各类考试场景需求。</p>
                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">了解更多 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>核心功能</h2>
                <ul>
                    <li>多样化试题管理</li>
                    <li>灵活组卷策略</li>
                    <li>智能难度分配</li>
                    <li>试卷导出与预览</li>
                </ul>
                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">查看帮助 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>快速开始</h2>
                <p>选择上方功能卡片进入试题管理或试卷操作，或参考以下资源：</p>
                <ul>
                    <li><a href="http://www.yiiframework.com/extensions/">Yii Extensions</a></li>
                    <li><a href="http://www.yiiframework.com/">Yii Framework</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\models\common\Menu;
use common\models\common\MenuCate;

/**
 * 题库/组卷系统迁移验证
 *
 * php ./yii exam-check/all
 * php ./yii exam-check/models
 * php ./yii exam-check/services
 * php ./yii exam-check/api
 *
 * Class ExamCheckController
 * @package console\controllers
 */
class ExamCheckController extends Controller
{
    /**
     * 全量检查
     */
    public function actionAll()
    {
        $this->stdout("========== 题库/组卷系统迁移验证 ==========\n", Console::FG_YELLOW);

        $this->actionModels();
        $this->actionServices();
        $this->actionApi();

        $this->stdout("\n========== 全部检查完成 ==========\n", Console::FG_GREEN);
    }

    /**
     * 检查数据库模型
     *
     * php ./yii exam-check/models
     */
    public function actionModels()
    {
        $this->stdout("--- 数据库模型检查 ---\n", Console::FG_YELLOW);

        $modelClasses = [
            'common\models\exam\Question',
            'common\models\exam\Answer',
            'common\models\exam\Category',
            'common\models\exam\Testpaper',
            'common\models\exam\Testpaperinfo',
            'common\models\exam\TestpaperScore',
            'common\models\exam\Testbank',
            'common\models\exam\Course',
            'common\models\exam\Subject',
            'common\models\exam\QuestionContent',
            'common\models\exam\QuestionOptions',
            'common\models\exam\QuestionType',
            'common\models\exam\QuestionSplits',
            'common\models\exam\QuestionScoreSet',
            'common\models\exam\QuestionRating',
            'common\models\exam\QuestionVideo',
            'common\models\exam\Collect',
            'common\models\exam\Classpaper',
            'common\models\exam\CourseCombination',
            'common\models\exam\Crawler',
            'common\models\exam\File',
            'common\models\exam\Formula',
            'common\models\exam\Homework',
            'common\models\exam\Mathsign',
            'common\models\exam\Options',
            'common\models\exam\Paperscore',
            'common\models\exam\Profile',
            'common\models\exam\Region',
            'common\models\exam\School',
            'common\models\exam\Scoredetail',
            'common\models\exam\Studentinfo',
            'common\models\exam\Tag',
            'common\models\exam\TestbankPrint',
            'common\models\exam\User',
            'common\models\exam\TestpaperGoal',
            'common\models\exam\TestpaperDiagnostic',
            'common\models\exam\QuestionIds',
        ];

        $success = 0;
        $errors = 0;

        foreach ($modelClasses as $class) {
            if (class_exists($class)) {
                try {
                    $model = new $class;
                    $db = $model->getDb();

                    $dbName = 'default';
                    if ($db === Yii::$app->db_yuekegu) {
                        $dbName = 'db_yuekegu(yuekegu库)';
                    } else {
                        $dbName = '默认库(rage_yuekegu)';
                    }

                    $tableName = $model->tableName();
                    $this->stdout("  [OK] {$class}\n", Console::FG_GREEN);
                    $this->stdout("       表: {$tableName} | 连接: {$dbName}\n", Console::FG_CYAN);
                    $success++;
                } catch (\Exception $e) {
                    $this->stdout("  [FAIL] {$class}: " . $e->getMessage() . "\n", Console::FG_RED);
                    $errors++;
                }
            } else {
                $this->stdout("  [FAIL] {$class}: 类不存在\n", Console::FG_RED);
                $errors++;
            }
        }

        $this->stdout("\n模型检查结果: {$success} 成功, {$errors} 失败\n", $errors > 0 ? Console::FG_RED : Console::FG_GREEN);

        if ($errors > 0) {
            return 1;
        }
        return 0;
    }

    /**
     * 检查服务层
     *
     * php ./yii exam-check/services
     */
    public function actionServices()
    {
        $this->stdout("--- 服务层检查 ---\n", Console::FG_YELLOW);

        $serviceKeys = [
            'examQuestion' => '\services\exam\QuestionService',
            'examTestpaper' => '\services\exam\TestpaperService',
            'examCategory' => '\services\exam\CategoryService',
            'examTestbank' => '\services\exam\TestbankService',
        ];

        $success = 0;
        $errors = 0;

        foreach ($serviceKeys as $key => $class) {
            try {
                $service = Yii::$app->services->$key;
                if ($service instanceof $class) {
                    $this->stdout("  [OK] {$key} => {$class}\n", Console::FG_GREEN);
                    $success++;
                } else {
                    $this->stdout("  [FAIL] {$key}: 类型不匹配, 期望 {$class}, 实际 " . get_class($service) . "\n", Console::FG_RED);
                    $errors++;
                }
            } catch (\Exception $e) {
                $this->stdout("  [FAIL] {$key}: " . $e->getMessage() . "\n", Console::FG_RED);
                $errors++;
            }
        }

        // 服务方法功能测试
        $this->stdout("\n--- 服务方法测试 ---\n", Console::FG_YELLOW);

        $methods = [
            ['examQuestion', 'getTypes', [], 'QuestionService::getTypes()'],
            ['examCategory', 'getTree', [], 'CategoryService::getTree()'],
            ['examTestpaper', 'getList', [[], 5], 'TestpaperService::getList()'],
            ['examTestbank', 'getList', [[], 5], 'TestbankService::getList()'],
        ];

        foreach ($methods as $item) {
            try {
                $result = call_user_func_array([Yii::$app->services->{$item[0]}, $item[1]], $item[2]);
                if (is_array($result) && isset($result['total'])) {
                    $this->stdout("  [OK] {$item[3]} => {$result['total']} 条\n", Console::FG_GREEN);
                } elseif (is_array($result)) {
                    $this->stdout("  [OK] {$item[3]} => " . count($result) . " 条\n", Console::FG_GREEN);
                } else {
                    $this->stdout("  [OK] {$item[3]} 调用成功\n", Console::FG_GREEN);
                }
            } catch (\Exception $e) {
                $this->stdout("  [WARN] {$item[3]}: " . $e->getMessage() . "\n", Console::FG_YELLOW);
            }
        }

        $this->stdout("\n服务层检查结果: {$success} 成功, {$errors} 失败\n", $errors > 0 ? Console::FG_RED : Console::FG_GREEN);

        if ($errors > 0) {
            return 1;
        }
        return 0;
    }

    /**
     * 检查 API 路由
     *
     * php ./yii exam-check/api
     */
    public function actionApi()
    {
        $this->stdout("--- API 路由检查 ---\n", Console::FG_YELLOW);

        $success = 0;
        $errors = 0;

        $this->stdout("  (console 环境通过类名验证路由)\n", Console::FG_YELLOW);

        $classes = [
            '\api\modules\v1\controllers\exam\QuestionController' => 'exam/question',
            '\api\modules\v1\controllers\exam\TestpaperController' => 'exam/testpaper',
            '\api\modules\v1\controllers\exam\CategoryController' => 'exam/category',
        ];

        foreach ($classes as $class => $route) {
            if (class_exists($class)) {
                $methods = get_class_methods($class);
                $actions = array_filter($methods, function($m) {
                    return strpos($m, 'action') === 0;
                });
                $this->stdout("  [OK] {$route} => {$class}\n", Console::FG_GREEN);
                $this->stdout("       actions: " . implode(', ', $actions) . "\n", Console::FG_CYAN);
                $success++;
            } else {
                $this->stdout("  [FAIL] {$class}: 类不存在\n", Console::FG_RED);
                $errors++;
            }
        }

        // 检查 authOptional 配置
        $this->stdout("\n--- 免登录接口检查 ---\n", Console::FG_YELLOW);

        $controllers = [
            '\api\modules\v1\controllers\exam\QuestionController' => 'question',
            '\api\modules\v1\controllers\exam\TestpaperController' => 'testpaper',
            '\api\modules\v1\controllers\exam\CategoryController' => 'category',
        ];

        foreach ($controllers as $class => $id) {
            $controller = new $class($id, Yii::$app->getModule('v1'));
            $ref = new \ReflectionProperty($controller, 'authOptional');
            $ref->setAccessible(true);
            $optional = $ref->getValue($controller);
            $this->stdout("  [OK] {$class}: " . json_encode($optional) . "\n", Console::FG_CYAN);
        }

        $this->stdout("\nAPI 检查结果: {$success} 成功, {$errors} 失败\n", $errors > 0 ? Console::FG_RED : Console::FG_GREEN);

        if ($errors > 0) {
            return 1;
        }
        return 0;
    }

    /**
     * 注册后台菜单
     *
     * php ./yii exam-check/menus
     */
    public function actionMenus()
    {
        $this->stdout("========== 注册题库/组卷后台菜单 ==========\n", Console::FG_YELLOW);

        $appId = 'backend';
        $addonName = '';

        // 查找或创建菜单分类
        $cate = MenuCate::find()->where([
            'app_id' => $appId,
            'title' => '题库管理',
            'is_addon' => 0,
        ])->one();

        if (!$cate) {
            $cate = new MenuCate();
            $cate->title = '题库管理';
            $cate->app_id = $appId;
            $cate->icon = 'fa fa-graduation-cap';
            $cate->is_addon = 0;
            $cate->is_default_show = 0;
            $cate->sort = 98;
            $cate->status = 1;
            $cate->pid = 0;
            $cate->level = 1;
            $cate->tree = '0-';
            if (!$cate->save()) {
                $this->stdout("  创建菜单分类失败: " . json_encode($cate->errors) . "\n", Console::FG_RED);
                return 1;
            }
            $this->stdout("  创建菜单分类: 题库管理 (ID: {$cate->id})\n", Console::FG_GREEN);
        } else {
            $this->stdout("  菜单分类已存在: 题库管理 (ID: {$cate->id})\n", Console::FG_CYAN);
        }

        // 注册菜单项
        $menus = [
            [
                'title' => '试题管理',
                'name' => 'exam/question/index',
                'url' => '/exam/question/index',
                'icon' => 'fa fa-question-circle',
                'sort' => 1,
                'pid' => 0,
                'level' => 2,
            ],
            [
                'title' => '创建试题',
                'name' => 'exam/question/create',
                'url' => '/exam/question/create',
                'sort' => 2,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试题详情',
                'name' => 'exam/question/view',
                'url' => '/exam/question/view',
                'sort' => 3,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '更新试题',
                'name' => 'exam/question/update',
                'url' => '/exam/question/update',
                'sort' => 4,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '删除试题',
                'name' => 'exam/question/delete',
                'url' => '/exam/question/delete',
                'sort' => 5,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试卷管理',
                'name' => 'exam/testpaper/index',
                'url' => '/exam/testpaper/index',
                'icon' => 'fa fa-file-text',
                'sort' => 10,
                'pid' => 0,
                'level' => 2,
            ],
            [
                'title' => '创建试卷',
                'name' => 'exam/testpaper/create',
                'url' => '/exam/testpaper/create',
                'sort' => 11,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试卷详情',
                'name' => 'exam/testpaper/view',
                'url' => '/exam/testpaper/view',
                'sort' => 12,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '更新试卷',
                'name' => 'exam/testpaper/update',
                'url' => '/exam/testpaper/update',
                'sort' => 13,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '删除试卷',
                'name' => 'exam/testpaper/delete',
                'url' => '/exam/testpaper/delete',
                'sort' => 14,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试卷题目管理',
                'name' => 'exam/testpaper/questions',
                'url' => '/exam/testpaper/questions',
                'sort' => 15,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试卷添加题目',
                'name' => 'exam/testpaper/add-question',
                'url' => '/exam/testpaper/add-question',
                'sort' => 16,
                'pid' => 0,
                'level' => 3,
            ],
            [
                'title' => '试卷移除题目',
                'name' => 'exam/testpaper/remove-question',
                'url' => '/exam/testpaper/remove-question',
                'sort' => 17,
                'pid' => 0,
                'level' => 3,
            ],
        ];

        // 先找试题管理菜单获取其ID作为pid
        $questionMenu = Menu::find()->where([
            'cate_id' => $cate->id,
            'name' => 'exam/question/index',
        ])->one();

        $testpaperMenu = Menu::find()->where([
            'cate_id' => $cate->id,
            'name' => 'exam/testpaper/index',
        ])->one();

        $count = 0;
        foreach ($menus as $menuData) {
            $name = $menuData['name'];
            $existing = Menu::find()->where([
                'cate_id' => $cate->id,
                'name' => $name,
            ])->one();

            $pid = 0;
            // 子菜单自动设置父级ID
            if ($menuData['level'] == 3) {
                if (strpos($name, 'exam/question/') === 0 && $questionMenu) {
                    $pid = $questionMenu->id;
                } elseif (strpos($name, 'exam/testpaper/') === 0 && $testpaperMenu) {
                    $pid = $testpaperMenu->id;
                }
            }

            if ($existing) {
                $this->stdout("  菜单已存在: {$menuData['title']} ({$name})\n", Console::FG_CYAN);
                if ($pid > 0 && $existing->pid != $pid) {
                    $existing->pid = $pid;
                    $existing->save();
                }
                continue;
            }

            $menu = new Menu();
            $menu->title = $menuData['title'];
            $menu->name = $name;
            $menu->url = $menuData['url'];
            $menu->icon = $menuData['icon'] ?? '';
            $menu->sort = $menuData['sort'];
            $menu->pid = $pid;
            $menu->level = $menuData['level'];
            $menu->cate_id = $cate->id;
            $menu->app_id = $appId;
            $menu->is_addon = 0;
            $menu->addon_name = $addonName;
            $menu->status = 1;
            $menu->dev = 0;

            if (!$menu->save()) {
                $this->stdout("  创建菜单 [{$menuData['title']}] 失败: " . json_encode($menu->errors) . "\n", Console::FG_RED);
            } else {
                $this->stdout("  创建菜单: {$menuData['title']} (ID: {$menu->id})\n", Console::FG_GREEN);
                $count++;
            }

            // 记录一级菜单ID用于子菜单
            if ($name == 'exam/question/index') {
                $questionMenu = $menu;
            }
            if ($name == 'exam/testpaper/index') {
                $testpaperMenu = $menu;
            }
        }

        $this->stdout("\n菜单注册完成: 新增 {$count} 个, 已存在 " . (count($menus) - $count) . " 个\n", Console::FG_GREEN);
        return 0;
    }

    /**
     * 全量检查 + 后端页面
     *
     * php ./yii exam-check/all
     */
    public function actionBackend()
    {
        $this->stdout("========== 后端页面验证 ==========\n", Console::FG_YELLOW);

        $checks = [
            'backend\controllers\exam\QuestionController' => [
                'path' => '/www/wwwroot/rage.yuekegu.com/backend/controllers/exam/QuestionController.php',
                'views' => [
                    'index', 'create', 'update', 'view',
                ],
                'viewDir' => '/www/wwwroot/rage.yuekegu.com/backend/views/exam/question',
            ],
            'backend\controllers\exam\TestpaperController' => [
                'path' => '/www/wwwroot/rage.yuekegu.com/backend/controllers/exam/TestpaperController.php',
                'views' => [
                    'index', 'create', 'update', 'view', 'questions', 'add-question',
                ],
                'viewDir' => '/www/wwwroot/rage.yuekegu.com/backend/views/exam/testpaper',
            ],
        ];

        $success = 0;
        $errors = 0;

        foreach ($checks as $class => $info) {
            $this->stdout("\n--- 检查 {$class} ---\n", Console::FG_YELLOW);

            // 检查控制器文件
            if (file_exists($info['path'])) {
                $output = shell_exec("/www/server/php/74/bin/php -l {$info['path']} 2>&1");
                if (strpos($output, 'No syntax errors') !== false) {
                    $this->stdout("  [OK] 控制器语法检查通过\n", Console::FG_GREEN);
                    $success++;
                } else {
                    $this->stdout("  [FAIL] 控制器语法错误: {$output}\n", Console::FG_RED);
                    $errors++;
                }
            } else {
                $this->stdout("  [FAIL] 控制器文件不存在: {$info['path']}\n", Console::FG_RED);
                $errors++;
            }

            // 检查视图文件
            foreach ($info['views'] as $view) {
                $viewFile = $info['viewDir'] . '/' . $view . '.php';
                if (file_exists($viewFile)) {
                    $output = shell_exec("/www/server/php/74/bin/php -l {$viewFile} 2>&1");
                    if (strpos($output, 'No syntax errors') !== false) {
                        $this->stdout("  [OK] 视图: {$view}.php\n", Console::FG_GREEN);
                        $success++;
                    } else {
                        $this->stdout("  [FAIL] 视图语法错误 {$view}.php: {$output}\n", Console::FG_RED);
                        $errors++;
                    }
                } else {
                    $this->stdout("  [FAIL] 视图文件不存在: {$view}.php\n", Console::FG_RED);
                    $errors++;
                }
            }

            // 检查 _form.php
            $formFile = $info['viewDir'] . '/_form.php';
            if (file_exists($formFile)) {
                $output = shell_exec("/www/server/php/74/bin/php -l {$formFile} 2>&1");
                if (strpos($output, 'No syntax errors') !== false) {
                    $this->stdout("  [OK] 视图: _form.php\n", Console::FG_GREEN);
                    $success++;
                } else {
                    $this->stdout("  [FAIL] 视图语法错误 _form.php: {$output}\n", Console::FG_RED);
                    $errors++;
                }
            }
        }

        $this->stdout("\n后端页面验证结果: {$success} 通过, {$errors} 失败\n", $errors > 0 ? Console::FG_RED : Console::FG_GREEN);

        if ($errors > 0) {
            return 1;
        }
        return 0;
    }
}

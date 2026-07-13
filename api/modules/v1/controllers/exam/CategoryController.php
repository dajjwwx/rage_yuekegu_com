<?php

namespace api\modules\v1\controllers\exam;

use Yii;
use api\controllers\OnAuthController;
use common\helpers\ResultHelper;
use services\exam\CategoryService;

/**
 * 知识点/章节分类 API
 *
 * Class CategoryController
 * @package api\modules\v1\controllers\exam
 */
class CategoryController extends OnAuthController
{
    public $modelClass = '';
    protected $authOptional = ['index', 'tree', 'by-course', 'flat'];

    /**
     * @var CategoryService
     */
    private $categoryService;

    public function init()
    {
        parent::init();
        $this->categoryService = new CategoryService();
    }

    public function actions()
    {
        return [];
    }

    /**
     * 分类树
     * GET /api/v1/exam/category/tree?type=77
     * type: 77=章节, 73=知识点
     */
    public function actionTree()
    {
        $type = Yii::$app->request->get('type');
        $tree = $this->categoryService->getTree($type);
        return ResultHelper::json(200, '获取成功', $tree);
    }

    /**
     * 根据学科获取知识点
     * GET /api/v1/exam/category/by-course?course=2&period=4
     */
    public function actionByCourse()
    {
        $course = Yii::$app->request->get('course');
        $period = Yii::$app->request->get('period', 4);
        
        if (empty($course)) {
            return ResultHelper::json(422, '缺少学科参数');
        }
        
        $categories = $this->categoryService->getByCourse($course, $period);
        return ResultHelper::json(200, '获取成功', $categories);
    }

    /**
     * 扁平分类列表 (用于树形组件)
     * GET /api/v1/exam/category/flat?type=77
     */
    public function actionFlat()
    {
        $type = Yii::$app->request->get('type');
        $categories = $this->categoryService->getFlat($type);
        return ResultHelper::json(200, '获取成功', $categories);
    }
}

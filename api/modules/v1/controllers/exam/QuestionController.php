<?php

namespace api\modules\v1\controllers\exam;

use Yii;
use api\controllers\OnAuthController;
use common\helpers\ResultHelper;
use services\exam\QuestionService;

/**
 * 试题 API
 *
 * Class QuestionController
 * @package api\modules\v1\controllers\exam
 */
class QuestionController extends OnAuthController
{
    public $modelClass = '';
    protected $authOptional = ['index', 'view', 'types', 'courses', 'search', 'sources', 'years'];

    /**
     * @var QuestionService
     */
    private $questionService;

    public function init()
    {
        parent::init();
        $this->questionService = new QuestionService();
    }

    public function actions()
    {
        return [];
    }

    /**
     * 试题列表
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->get();
        $pageSize = (int)($params['page_size'] ?? 20);
        
        $result = $this->questionService->getList($params, $pageSize);
        return ResultHelper::json(200, '获取成功', $result);
    }

    /**
     * 试题详情
     */
    public function actionView($id)
    {
        $detail = $this->questionService->getDetail($id);
        if (!$detail) {
            return ResultHelper::json(404, '试题不存在');
        }
        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * 创建试题
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $result = $this->questionService->create($data);
        
        if ($result['success']) {
            return ResultHelper::json(200, '创建成功', $result['data']);
        }
        return ResultHelper::json(422, '创建失败', $result['errors'] ?? $result['message']);
    }

    /**
     * 更新试题
     */
    public function actionUpdate($id)
    {
        $data = Yii::$app->request->post();
        $result = $this->questionService->update($id, $data);
        
        if ($result['success']) {
            return ResultHelper::json(200, '更新成功', $result['data']);
        }
        return ResultHelper::json(422, '更新失败', $result['errors'] ?? $result['message']);
    }

    /**
     * 删除试题
     */
    public function actionDelete($id)
    {
        $result = $this->questionService->delete($id);
        
        if ($result['success']) {
            return ResultHelper::json(200, '删除成功');
        }
        return ResultHelper::json(422, '删除失败', $result['message']);
    }

    /**
     * 题型列表
     */
    public function actionTypes()
    {
        $types = $this->questionService->getTypes();
        return ResultHelper::json(200, '获取成功', $types);
    }

    /**
     * 学科列表
     */
    public function actionCourses()
    {
        $period = Yii::$app->request->get('period');
        $courses = $this->questionService->getCourses($period);
        return ResultHelper::json(200, '获取成功', $courses);
    }

    /**
     * 来源列表
     */
    public function actionSources()
    {
        $sources = $this->questionService->getSources();
        return ResultHelper::json(200, '获取成功', $sources);
    }

    /**
     * 年份列表
     */
    public function actionYears()
    {
        $years = $this->questionService->getYears();
        return ResultHelper::json(200, '获取成功', $years);
    }

    /**
     * 搜索试题
     */
    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('keyword');
        $params = Yii::$app->request->get();
        
        if (empty($keyword)) {
            return $this->actionIndex();
        }
        
        $result = $this->questionService->getList($params, 20);
        return ResultHelper::json(200, '搜索成功', $result);
    }
}

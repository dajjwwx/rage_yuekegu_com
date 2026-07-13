<?php

namespace api\modules\v1\controllers\exam;

use Yii;
use api\controllers\OnAuthController;
use common\helpers\ResultHelper;
use services\exam\TestpaperService;

/**
 * 试卷 API
 *
 * Class TestpaperController
 * @package api\modules\v1\controllers\exam
 */
class TestpaperController extends OnAuthController
{
    public $modelClass = '';
    protected $authOptional = ['index', 'view', 'list'];

    /**
     * @var TestpaperService
     */
    private $testpaperService;

    public function init()
    {
        parent::init();
        $this->testpaperService = new TestpaperService();
    }

    public function actions()
    {
        return [];
    }

    /**
     * 试卷列表
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->get();
        $pageSize = (int)($params['page_size'] ?? 20);
        
        $result = $this->testpaperService->getList($params, $pageSize);
        return ResultHelper::json(200, '获取成功', $result);
    }

    /**
     * 试卷详情
     */
    public function actionView($id)
    {
        $detail = $this->testpaperService->getDetail($id);
        if (!$detail) {
            return ResultHelper::json(404, '试卷不存在');
        }
        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * 创建试卷
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $result = $this->testpaperService->create($data);
        
        if ($result['success']) {
            return ResultHelper::json(200, '创建成功', $result['data']);
        }
        return ResultHelper::json(422, '创建失败', $result['errors']);
    }

    /**
     * 更新试卷
     */
    public function actionUpdate($id)
    {
        $data = Yii::$app->request->post();
        $result = $this->testpaperService->update($id, $data);
        
        if ($result['success']) {
            return ResultHelper::json(200, '更新成功', $result['data']);
        }
        return ResultHelper::json(422, '更新失败', $result['errors']);
    }

    /**
     * 删除试卷
     */
    public function actionDelete($id)
    {
        $result = $this->testpaperService->delete($id);
        
        if ($result['success']) {
            return ResultHelper::json(200, '删除成功');
        }
        return ResultHelper::json(422, '删除失败', $result['message']);
    }

    /**
     * 添加题目到试卷
     */
    public function actionAddQuestion($id)
    {
        $params = Yii::$app->request->post();
        $result = $this->testpaperService->addQuestion($id, $params['question_id'], $params);
        
        if ($result['success']) {
            return ResultHelper::json(200, '添加成功', $result['data']);
        }
        return ResultHelper::json(422, '添加失败', $result['errors']);
    }

    /**
     * 移除试卷中的题目
     */
    public function actionRemoveQuestion($id)
    {
        $questionId = Yii::$app->request->post('question_id');
        $result = $this->testpaperService->removeQuestion($id, $questionId);
        
        return ResultHelper::json(200, '移除成功');
    }
}

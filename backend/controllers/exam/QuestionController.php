<?php

namespace backend\controllers\exam;

use Yii;
use common\helpers\ResultHelper;
use common\models\base\SearchModel;
use common\models\exam\Question;
use common\models\exam\QuestionContent;
use common\models\exam\Answer;
use common\models\exam\QuestionOptions;
use services\exam\QuestionService;
use backend\controllers\BaseController;

/**
 * 试题管理
 *
 * Class QuestionController
 * @package backend\controllers\exam
 */
class QuestionController extends BaseController
{
    /**
     * @var QuestionService
     */
    protected $questionService;

    public function init()
    {
        parent::init();
        $this->questionService = new QuestionService();
    }

    /**
     * 试题列表
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => Question::class,
            'scenario' => 'default',
            'partialMatchAttributes' => ['content', 'source'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'pageSize' => $this->pageSize,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 获取题型列表和学科列表供搜索下拉使用
        $types = $this->questionService->getTypes();
        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'types' => $types,
            'courses' => $courses,
        ]);
    }

    /**
     * 创建试题
     *
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Question();
        $model->pubdate = time();

        // 默认值
        $model->uuid = \common\helpers\StringHelper::uuid();
        $model->status = 1;

        if ($model->load(Yii::$app->request->post())) {
            try {
                $data = Yii::$app->request->post();
                $result = $this->questionService->create($data['Question'] ?? $data);
                if ($result['success']) {
                    return $this->redirect(['index']);
                }
                return $this->message('创建失败：' . json_encode($result['errors'] ?? $result['message']), $this->redirect(['index']), 'error');
            } catch (\Exception $e) {
                return $this->message('创建失败：' . $e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        $types = $this->questionService->getTypes();
        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'model' => $model,
            'types' => $types,
            'courses' => $courses,
        ]);
    }

    /**
     * 更新试题
     *
     * @param $id
     * @return mixed|string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->questionService->get($id);
        if (!$model) {
            return $this->message('试题不存在', $this->redirect(['index']), 'error');
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                $data = Yii::$app->request->post();
                $result = $this->questionService->update($id, $data['Question'] ?? $data);
                if ($result['success']) {
                    return $this->redirect(['index']);
                }
                return $this->message('更新失败：' . json_encode($result['errors'] ?? $result['message']), $this->redirect(['index']), 'error');
            } catch (\Exception $e) {
                return $this->message('更新失败：' . $e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        $types = $this->questionService->getTypes();
        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'model' => $model,
            'types' => $types,
            'courses' => $courses,
        ]);
    }

    /**
     * 查看试题详情
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $detail = $this->questionService->getDetail($id);
        if (!$detail) {
            return $this->message('试题不存在', $this->redirect(['index']), 'error');
        }

        return $this->render($this->action->id, [
            'model' => $detail,
        ]);
    }

    /**
     * 删除试题
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $result = $this->questionService->delete($id);
        if ($result['success']) {
            return $this->redirect(['index']);
        }
        return $this->message('删除失败：' . ($result['message'] ?? '未知错误'), $this->redirect(['index']), 'error');
    }
}

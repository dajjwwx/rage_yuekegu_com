<?php

namespace backend\controllers\exam;

use Yii;
use common\helpers\ResultHelper;
use common\models\base\SearchModel;
use common\models\exam\Testpaper;
use common\models\exam\Testpaperinfo;
use common\models\exam\Question;
use services\exam\TestpaperService;
use services\exam\QuestionService;
use backend\controllers\BaseController;

/**
 * 试卷管理
 *
 * Class TestpaperController
 * @package backend\controllers\exam
 */
class TestpaperController extends BaseController
{
    /**
     * @var TestpaperService
     */
    protected $testpaperService;

    /**
     * @var QuestionService
     */
    protected $questionService;

    public function init()
    {
        parent::init();
        $this->testpaperService = new TestpaperService();
        $this->questionService = new QuestionService();
    }

    /**
     * 试卷列表
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => Testpaper::class,
            'scenario' => 'default',
            'partialMatchAttributes' => ['title'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'pageSize' => $this->pageSize,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'courses' => $courses,
        ]);
    }

    /**
     * 创建试卷
     *
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Testpaper();
        $model->created = time();

        if ($model->load(Yii::$app->request->post())) {
            try {
                $data = Yii::$app->request->post();
                $result = $this->testpaperService->create($data['Testpaper'] ?? $data);
                if ($result['success']) {
                    return $this->redirect(['index']);
                }
                return $this->message('创建失败：' . json_encode($result['errors'] ?? $result['message']), $this->redirect(['index']), 'error');
            } catch (\Exception $e) {
                return $this->message('创建失败：' . $e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'model' => $model,
            'courses' => $courses,
        ]);
    }

    /**
     * 更新试卷
     *
     * @param $id
     * @return mixed|string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->testpaperService->get($id);
        if (!$model) {
            return $this->message('试卷不存在', $this->redirect(['index']), 'error');
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                $data = Yii::$app->request->post();
                $result = $this->testpaperService->update($id, $data['Testpaper'] ?? $data);
                if ($result['success']) {
                    return $this->redirect(['index']);
                }
                return $this->message('更新失败：' . json_encode($result['errors'] ?? $result['message']), $this->redirect(['index']), 'error');
            } catch (\Exception $e) {
                return $this->message('更新失败：' . $e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        $courses = $this->questionService->getCourses();

        return $this->render($this->action->id, [
            'model' => $model,
            'courses' => $courses,
        ]);
    }

    /**
     * 查看试卷详情
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $detail = $this->testpaperService->getDetail($id);
        if (!$detail) {
            return $this->message('试卷不存在', $this->redirect(['index']), 'error');
        }

        return $this->render($this->action->id, [
            'model' => $detail,
        ]);
    }

    /**
     * 删除试卷
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $result = $this->testpaperService->delete($id);
        if ($result['success']) {
            return $this->redirect(['index']);
        }
        return $this->message('删除失败：' . ($result['message'] ?? '未知错误'), $this->redirect(['index']), 'error');
    }

    /**
     * 管理试卷题目
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionQuestions($id)
    {
        $testpaper = $this->testpaperService->get($id);
        if (!$testpaper) {
            return $this->message('试卷不存在', $this->redirect(['index']), 'error');
        }

        // 获取试卷中的题目
        $questions = Testpaperinfo::find()
            ->where(['testpaper_id' => $id])
            ->orderBy(['question_num' => SORT_ASC])
            ->all();

        $types = $this->questionService->getTypes();

        return $this->render($this->action->id, [
            'testpaper' => $testpaper,
            'questions' => $questions,
            'types' => $types,
        ]);
    }

    /**
     * 从试卷中移除题目
     *
     * @param $id
     * @param $question_id
     * @return \yii\web\Response
     */
    public function actionRemoveQuestion($id, $question_id)
    {
        $result = $this->testpaperService->removeQuestion($id, $question_id);
        if ($result['success']) {
            return $this->redirect(['questions', 'id' => $id]);
        }
        return $this->message('移除失败', $this->redirect(['questions', 'id' => $id]), 'error');
    }

    /**
     * 为试卷添加题目
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAddQuestion($id)
    {
        $testpaper = $this->testpaperService->get($id);
        if (!$testpaper) {
            return $this->message('试卷不存在', $this->redirect(['index']), 'error');
        }

        $questionId = Yii::$app->request->post('question_id');
        $score = Yii::$app->request->post('score', 5);
        $questionType = Yii::$app->request->post('question_type', 0);

        if ($questionId) {
            $result = $this->testpaperService->addQuestion($id, $questionId, [
                'score' => $score,
                'question_type' => $questionType,
            ]);
            if ($result['success']) {
                return $this->redirect(['questions', 'id' => $id]);
            }
            return $this->message('添加失败：' . json_encode($result['errors'] ?? $result['message']), $this->redirect(['questions', 'id' => $id]), 'error');
        }

        // 获取可用试题列表
        $questionList = Question::find()
            ->where(['status' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->limit(100)
            ->all();

        $types = $this->questionService->getTypes();
        $courses = $this->questionService->getCourses();

        return $this->render('add-question', [
            'testpaper' => $testpaper,
            'questionList' => $questionList,
            'types' => $types,
            'courses' => $courses,
        ]);
    }
}

<?php

namespace frontend\modules\exam\controllers;

use Yii;
use yii\web\Controller;
use services\exam\TestpaperService;
use services\exam\QuestionService;
use services\exam\CategoryService;

/**
 * 试卷管理
 *
 * Class TestpaperController
 * @package frontend\controllers\exam
 */
class TestpaperController extends Controller
{
    /**
     * @var TestpaperService
     */
    private $testpaperService;

    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * @var CategoryService
     */
    private $categoryService;

    public function init()
    {
        parent::init();
        $this->testpaperService = new TestpaperService();
        $this->questionService = new QuestionService();
        $this->categoryService = new CategoryService();
    }

    /**
     * 试卷列表
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();
        
        $courseId = $request->get('course', '');
        $period = $request->get('period', '');
        $keyword = $request->get('keyword', '');
        
        $queryParams = [];
        if ($courseId) $queryParams['course'] = $courseId;
        if ($period) $queryParams['period'] = $period;
        if ($keyword) $queryParams['keyword'] = $keyword;
        
        $result = $this->testpaperService->getList($queryParams, 20);
        
        // 获取学科列表
        $courses = $this->questionService->getCourses();

        return $this->render('index', [
            'courseId' => $courseId,
            'period' => $period,
            'keyword' => $keyword,
            'courses' => $courses,
            'papers' => $result['items'] ?? [],
            'total' => $result['total'] ?? 0,
            'page' => $result['page'] ?? 1,
            'pageCount' => $result['pageCount'] ?? 1,
        ]);
    }

    /**
     * 试卷详情
     */
    public function actionView($id)
    {
        $testpaper = $this->testpaperService->getDetail($id);
        if (!$testpaper) {
            throw new \yii\web\NotFoundHttpException('试卷不存在');
        }

        return $this->render('view', [
            'testpaper' => $testpaper,
        ]);
    }

    /**
     * 手动组卷
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            $data = $request->post();
            $result = $this->testpaperService->create($data);
            if ($result['success']) {
                Yii::$app->session->setFlash('success', '试卷创建成功');
                return $this->redirect(['view', 'id' => $result['data']['id']]);
            }
            Yii::$app->session->setFlash('error', '创建失败：' . json_encode($result['errors'] ?? []));
        }

        // 获取学科
        $courses = $this->questionService->getCourses();

        return $this->render('create', [
            'courses' => $courses,
        ]);
    }

    /**
     * 智能组卷
     */
    public function actionSmart()
    {
        $request = Yii::$app->request;
        $courses = $this->questionService->getCourses();
        $types = $this->questionService->getTypes();
        
        $result = null;
        if ($request->isPost) {
            $params = $request->post();
            // 智能组卷逻辑：按条件查询试题并创建试卷
            $queryParams = [];
            if (!empty($params['course'])) $queryParams['course'] = $params['course'];
            if (!empty($params['period'])) $queryParams['period'] = $params['period'];
            if (!empty($params['difficulty'])) $queryParams['difficulty'] = $params['difficulty'];
            if (!empty($params['type'])) $queryParams['type'] = $params['type'];
            if (!empty($params['count'])) {
                $pageSize = min((int)$params['count'], 50);
            } else {
                $pageSize = 10;
            }
            
            $questions = $this->questionService->getList($queryParams, $pageSize);
            $result = $questions;
        }

        return $this->render('smart', [
            'courses' => $courses,
            'types' => $types,
            'papers' => $result,
        ]);
    }

    /**
     * 打印试卷
     */
    public function actionPrint($id = null)
    {
        $this->layout = false; // 不用主题布局，纯打印样式

        if ($id === null) {
            $id = Yii::$app->request->get('id');
        }

        if (!$id) {
            throw new \yii\web\BadRequestHttpException('缺少参数：id');
        }

        $testpaper = $this->testpaperService->getDetail($id);
        if (!$testpaper) {
            throw new \yii\web\NotFoundHttpException('试卷不存在');
        }

        return $this->render('print', [
            'testpaper' => $testpaper,
        ]);
    }
}

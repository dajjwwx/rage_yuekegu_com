<?php

namespace frontend\modules\exam\controllers;

use Yii;
use yii\web\Controller;
use services\exam\QuestionService;
use services\exam\CategoryService;

/**
 * 试题浏览器
 *
 * Class QuestionController
 * @package frontend\controllers\exam
 */
class QuestionController extends Controller
{
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
        $this->questionService = new QuestionService();
        $this->categoryService = new CategoryService();
    }

    /**
     * 试题浏览/搜索页面
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $params = $request->get();

        // 获取筛选条件数据
        $period = $request->get('xd', '');       // 学段: 空|2|3|4
        $courseId = $request->get('chid', '');   // 学科ID
        $treeType = $request->get('tree_type', 'category'); // category|knowledge
        $typeId = $request->get('type', '');      // 题型
        $difficulty = $request->get('difficulty', '');
        $year = $request->get('year', '');
        $source = $request->get('source', '');
        $keyword = $request->get('keyword', '');
        $categoryId = $request->get('category_id', '');
        $page = (int)$request->get('page', 1);

        // 获取分类树 (根据tree_type)
        // type: 77=章节(教材), 73=知识点
        $catType = ($treeType === 'knowledge') ? 73 : 77;
        $categoryTree = $this->categoryService->getTree($catType);
        
        // 获取所有学科
        $courses = $this->questionService->getCourses();
        
        // 获取题型
        $types = $this->questionService->getTypes();
        
        // 获取年份、来源
        $years = $this->questionService->getYears();
        $sources = $this->questionService->getSources();

        // 获取试题列表
        $queryParams = [];
        if ($courseId) $queryParams['course'] = $courseId;
        if ($period) $queryParams['period'] = $period;
        if ($typeId) $queryParams['type'] = $typeId;
        if ($difficulty) $queryParams['difficulty'] = $difficulty;
        if ($year) $queryParams['year'] = $year;
        if ($source) $queryParams['source'] = $source;
        if ($keyword) $queryParams['keyword'] = $keyword;
        if ($categoryId) $queryParams['category_id'] = $categoryId;
        
        $result = $this->questionService->getList($queryParams, 20);

        return $this->render('index', [
            'period' => $period,
            'courseId' => $courseId,
            'treeType' => $treeType,
            'typeId' => $typeId,
            'difficulty' => $difficulty,
            'year' => $year,
            'source' => $source,
            'keyword' => $keyword,
            'categoryId' => $categoryId,
            'categoryTree' => $categoryTree,
            'courses' => $courses,
            'types' => $types,
            'years' => $years,
            'sources' => $sources,
            'questions' => $result['items'] ?? [],
            'total' => $result['total'] ?? 0,
            'page' => $result['page'] ?? 1,
            'pageSize' => $result['pageSize'] ?? 20,
            'pageCount' => $result['pageCount'] ?? 1,
        ]);
    }

    /**
     * 试题详情
     */
    public function actionView($id)
    {
        $detail = $this->questionService->getDetail($id);
        if (!$detail) {
            throw new \yii\web\NotFoundHttpException('试题不存在');
        }

        return $this->render('view', [
            'question' => $detail,
        ]);
    }

    /**
     * AJAX: 根据学段获取学科列表
     */
    public function actionAjaxCourses()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $period = Yii::$app->request->get('period');
        $courses = $this->questionService->getCourses($period);
        return ['success' => true, 'data' => $courses];
    }

    /**
     * AJAX: 根据学科+学段获取题型列表
     */
    public function actionAjaxTypes()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $courseId = Yii::$app->request->get('course_id');
        $period = Yii::$app->request->get('period');
        $types = $this->questionService->getTypes($courseId, $period);
        return ['success' => true, 'data' => $types];
    }
}

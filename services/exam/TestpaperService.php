<?php

namespace services\exam;

use Yii;
use common\components\Service;
use common\models\exam\Testpaper;
use common\models\exam\Testpaperinfo;
use common\models\exam\TestpaperScore;
use common\models\exam\TestpaperDiagnostic;
use common\models\exam\Course;
use common\models\exam\Question;
use common\models\exam\QuestionSplits;
use common\helpers\StringHelper;
use yii\data\Pagination;

/**
 * 组卷服务
 *
 * Class TestpaperService
 * @package services\exam
 */
class TestpaperService extends Service
{
    /**
     * 获取试卷
     * @param $id
     * @return Testpaper|null
     */
    public function get($id)
    {
        return Testpaper::findOne($id);
    }

    /**
     * 获取试卷详情（含题目列表）
     * @param $id
     * @return array|null
     */
    public function getDetail($id)
    {
        $testpaper = $this->get($id);
        if (!$testpaper) {
            return null;
        }

        $data = $testpaper->toArray();

        // 题目列表
        $questions = Testpaperinfo::find()
            ->where(['testpaper_id' => $id])
            ->orderBy(['question_num' => SORT_ASC])
            ->all();

        $data['questions'] = [];
        foreach ($questions as $item) {
            $qData = $item->toArray();
            $question = Question::findOne($item->question_id);
            if ($question) {
                $qData['question_content'] = $question->content;
                $qData['question_type'] = $question->type;
            }
            $data['questions'][] = $qData;
        }

        // 学科信息
        $course = Course::findOne($testpaper->course);
        $data['course_name'] = $course ? $course->name : '';

        return $data;
    }

    /**
     * 试卷列表
     * @param array $params
     * @param int $pageSize
     * @return array
     */
    public function getList($params = [], $pageSize = 20)
    {
        $query = Testpaper::find();

        if (!empty($params['course'])) {
            $query->andWhere(['course' => $params['course']]);
        }
        if (!empty($params['period'])) {
            $query->andWhere(['period' => $params['period']]);
        }
        if (!empty($params['type'])) {
            $query->andWhere(['type' => $params['type']]);
        }
        if (!empty($params['user_id'])) {
            $query->andWhere(['user_id' => $params['user_id']]);
        }
        if (!empty($params['keyword'])) {
            $query->andWhere(['like', 'title', $params['keyword']]);
        }

        $countQuery = clone $query;
        $totalCount = $countQuery->count();

        $pagination = new Pagination([
            'totalCount' => $totalCount,
            'pageSize' => $pageSize,
        ]);

        $papers = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['created' => SORT_DESC])
            ->all();

        // 获取学科名称映射
        $courseIds = array_unique(array_map(function($p) { return $p->course; }, $papers));
        $courses = Course::find()->select(['id', 'name'])->where(['id' => $courseIds])->indexBy('id')->all();

        $items = [];
        foreach ($papers as $paper) {
            $item = (object) $paper->toArray();
            $item->course_name = isset($courses[$paper->course]) ? $courses[$paper->course]->name : '';
            $items[] = $item;
        }

        return [
            'items' => $items,
            'total' => $totalCount,
            'page' => $pagination->page + 1,
            'pageSize' => $pageSize,
            'pageCount' => $pagination->pageCount,
        ];
    }

    /**
     * 创建试卷
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        $testpaper = new Testpaper();
        $testpaper->attributes = $data;

        if (!isset($testpaper->created)) {
            $testpaper->created = time();
        }

        if ($testpaper->save()) {
            return ['success' => true, 'data' => $testpaper->toArray()];
        }
        return ['success' => false, 'errors' => $testpaper->errors];
    }

    /**
     * 更新试卷
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data)
    {
        $testpaper = $this->get($id);
        if (!$testpaper) {
            return ['success' => false, 'message' => '试卷不存在'];
        }

        $testpaper->attributes = $data;
        if ($testpaper->save()) {
            return ['success' => true, 'data' => $testpaper->toArray()];
        }
        return ['success' => false, 'errors' => $testpaper->errors];
    }

    /**
     * 删除试卷
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        $testpaper = $this->get($id);
        if (!$testpaper) {
            return ['success' => false, 'message' => '试卷不存在'];
        }

        $transaction = Yii::$app->db_yuekegu->beginTransaction();
        try {
            Testpaperinfo::deleteAll(['testpaper_id' => $id]);
            TestpaperScore::deleteAll(['paper_id' => $id]);
            $testpaper->delete();
            $transaction->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 添加题目到试卷
     * @param int $paperId
     * @param int $questionId
     * @param array $params
     * @return array
     */
    public function addQuestion($paperId, $questionId, $params = [])
    {
        $testpaper = $this->get($paperId);
        if (!$testpaper) {
            return ['success' => false, 'message' => '试卷不存在'];
        }

        // 获取当前最大题号
        $maxNum = Testpaperinfo::find()
            ->where(['testpaper_id' => $paperId])
            ->max('question_num');

        $info = new Testpaperinfo();
        $info->testpaper_id = $paperId;
        $info->question_id = $questionId;
        $info->question_num = ($maxNum ?: 0) + 1;
        $info->question_type = $params['question_type'] ?? 0;
        $info->score = $params['score'] ?? 5;
        $info->user_id = $params['user_id'] ?? Yii::$app->user->id ?? 0;

        if ($info->save()) {
            return ['success' => true, 'data' => $info->toArray()];
        }
        return ['success' => false, 'errors' => $info->errors];
    }

    /**
     * 移除试卷中的题目
     * @param int $paperId
     * @param int $questionId
     * @return array
     */
    public function removeQuestion($paperId, $questionId)
    {
        Testpaperinfo::deleteAll([
            'testpaper_id' => $paperId,
            'question_id' => $questionId,
        ]);
        return ['success' => true];
    }
}

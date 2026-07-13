<?php

namespace services\exam;

use Yii;
use common\components\Service;
use common\models\exam\Question;
use common\models\exam\Answer;
use common\models\exam\QuestionOptions;
use common\models\exam\QuestionContent;
use common\models\exam\QuestionType;
use common\models\exam\Course;
use common\models\exam\Category;
use common\helpers\StringHelper;
use yii\data\Pagination;

/**
 * 试题服务
 *
 * Class QuestionService
 * @package services\exam
 */
class QuestionService extends Service
{
    /**
     * 根据ID获取试题
     * @param $id
     * @return Question|null
     */
    public function get($id)
    {
        if (strlen($id) > 11) {
            return Question::find()->where(['uuid' => $id])->one();
        }
        return Question::find()->where(['id' => $id])->one();
    }

    /**
     * 获取试题详情（含关联数据）
     * @param $id
     * @return array|null
     */
    public function getDetail($id)
    {
        $question = $this->get($id);
        if (!$question) {
            return null;
        }

        $data = $question->toArray();
        
        // 关联数据
        $contentModel = QuestionContent::find()->where(['question_id' => $question->id])->one();
        $data['content'] = $contentModel ? $contentModel->content : '';
        $data['answer'] = Answer::find()->where(['question_id' => $question->id])->one();
        $data['options'] = QuestionOptions::find()->where(['question_id' => $question->id])->all();
        
        // 分类信息
        if ($question->category_ids) {
            $catIds = explode(',', $question->category_ids);
            $data['categories'] = Category::find()->where(['in', 'id', $catIds])->asArray()->all();
        }
        
        // 题型名称
        $typeModel = QuestionType::findOne($question->type);
        $data['type_name'] = $typeModel ? $typeModel->name : '';
        
        // 学科名称
        $courseModel = Course::findOne($question->course);
        $data['course_name'] = $courseModel ? $courseModel->name : '';

        return $data;
    }

    /**
     * 试题列表
     * @param array $params 筛选条件
     * @param int $pageSize
     * @return array
     */
    public function getList($params = [], $pageSize = 20)
    {
        $query = Question::find();
        
        // 筛选条件
        if (!empty($params['course'])) {
            $query->andWhere(['course' => $params['course']]);
        }
        if (!empty($params['period'])) {
            $query->andWhere(['period' => $params['period']]);
        }
        if (!empty($params['type'])) {
            $query->andWhere(['type' => $params['type']]);
        }
        if (!empty($params['category_id'])) {
            $query->andWhere(['like', 'category_ids', $params['category_id']]);
        }
        if (!empty($params['keyword'])) {
            $query->andWhere(['like', 'content', $params['keyword']]);
        }
        if (!empty($params['source'])) {
            $query->andWhere(['source' => $params['source']]);
        }
        // 难度筛选 (rate: 0-1, lower = easier)
        if (!empty($params['difficulty'])) {
            if ($params['difficulty'] == 'easy') {
                $query->andWhere(['<=', 'rate', 0.3]);
            } elseif ($params['difficulty'] == 'hard') {
                $query->andWhere(['>=', 'rate', 0.7]);
            } else {
                // normal
                $query->andWhere(['>', 'rate', 0.3]);
                $query->andWhere(['<', 'rate', 0.7]);
            }
        }
        // 年份筛选
        if (!empty($params['year'])) {
            $yearStart = strtotime($params['year'] . '-01-01');
            $yearEnd = strtotime(($params['year'] + 1) . '-01-01');
            $query->andWhere(['>=', 'pubdate', $yearStart]);
            $query->andWhere(['<', 'pubdate', $yearEnd]);
        }
        // 状态
        if (!empty($params['status'])) {
            $query->andWhere(['status' => $params['status']]);
        } else {
            $query->andWhere(['status' => 1]);
        }
        
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        
        $pagination = new Pagination([
            'totalCount' => $totalCount,
            'pageSize' => $pageSize,
        ]);
        
        $questions = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        
        return [
            'items' => $questions,
            'total' => $totalCount,
            'page' => $pagination->page + 1,
            'pageSize' => $pageSize,
            'pageCount' => $pagination->pageCount,
        ];
    }

    /**
     * 创建试题
     */
    public function create($data)
    {
        $transaction = Yii::$app->db_yuekegu->beginTransaction();
        try {
            $question = new Question();
            $question->attributes = $data;
            
            if (!isset($question->pubdate)) {
                $question->pubdate = time();
            }
            if (!isset($question->uuid)) {
                $question->uuid = StringHelper::uuid();
            }
            
            if (!$question->save()) {
                $transaction->rollBack();
                return ['success' => false, 'errors' => $question->errors];
            }
            
            if (!empty($data['content'])) {
                $content = QuestionContent::find()->where(['question_id' => $question->id])->one();
                if (!$content) {
                    $content = new QuestionContent();
                    $content->question_id = $question->id;
                }
                $content->content = $data['content'];
                $content->save();
            }
            
            $transaction->commit();
            return ['success' => true, 'data' => $question->toArray()];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 更新试题
     */
    public function update($id, $data)
    {
        $question = $this->get($id);
        if (!$question) {
            return ['success' => false, 'message' => '试题不存在'];
        }
        
        $transaction = Yii::$app->db_yuekegu->beginTransaction();
        try {
            $question->attributes = $data;
            if ($question->save()) {
                if (isset($data['content'])) {
                    $content = QuestionContent::find()->where(['question_id' => $question->id])->one();
                    if (!$content) {
                        $content = new QuestionContent();
                        $content->question_id = $question->id;
                    }
                    $content->content = $data['content'];
                    $content->save();
                }
                $transaction->commit();
                return ['success' => true, 'data' => $question->toArray()];
            }
            $transaction->rollBack();
            return ['success' => false, 'errors' => $question->errors];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 删除试题
     */
    public function delete($id)
    {
        $question = $this->get($id);
        if (!$question) {
            return ['success' => false, 'message' => '试题不存在'];
        }
        
        $transaction = Yii::$app->db_yuekegu->beginTransaction();
        try {
            QuestionContent::deleteAll(['question_id' => $question->id]);
            Answer::deleteAll(['question_id' => $question->id]);
            QuestionOptions::deleteAll(['question_id' => $question->id]);
            $question->delete();
            $transaction->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 获取题型列表
     * @param string|null $courseId 按学科筛选
     * @param string|null $period 按学段筛选
     * @return array
     */
    public function getTypes($courseId = null, $period = null)
    {
        $query = QuestionType::find();

        $conditions = ['status' => 1];
        if (!empty($courseId)) $conditions['course'] = $courseId;
        if (!empty($period)) $conditions['period'] = $period;

        if (!empty($courseId) || !empty($period)) {
            // 仅返回符合条件的试题中出现的题型
            $typeIds = Question::find()
                ->select(['type'])
                ->where($conditions)
                ->distinct()
                ->column();
            if (!empty($typeIds)) {
                $query->where(['id' => $typeIds]);
            } else {
                return [];
            }
        }
        
        return $query->asArray()->all();
    }

    /**
     * 获取学科列表
     */
    public function getCourses($period = null)
    {
        $query = Course::find();
        if ($period) {
            $query->where(['period' => $period]);
        }
        return $query->orderBy(['weight' => SORT_ASC])->asArray()->all();
    }

    /**
     * 获取来源列表（按题型文本缩写）
     */
    public function getSources()
    {
        return Question::find()
            ->select(['source'])
            ->where(['status' => 1])
            ->andWhere(['>', 'source', ''])
            ->groupBy(['source'])
            ->orderBy(['count(source)' => SORT_DESC])
            ->limit(30)
            ->column();
    }

    /**
     * 获取可选年份列表
     */
    public function getYears()
    {
        $years = Question::find()
            ->select(['YEAR(FROM_UNIXTIME(pubdate)) as yr'])
            ->where(['status' => 1])
            ->groupBy(['yr'])
            ->orderBy(['yr' => SORT_DESC])
            ->column();
        return $years;
    }
}

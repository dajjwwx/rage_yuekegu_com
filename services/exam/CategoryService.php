<?php

namespace services\exam;

use Yii;
use common\components\Service;
use common\models\exam\Category;
use common\models\exam\Subject;
use common\models\exam\Course;
use common\helpers\TreeHelper;

/**
 * 知识点分类服务
 *
 * Class CategoryService
 * @package services\exam
 */
class CategoryService extends Service
{
    /**
     * 获取分类树
     * @param int $type 77=章节, 73=知识点
     * @return array
     */
    public function getTree($type = null)
    {
        $query = Category::find();
        if ($type !== null) {
            $query->where(['type' => $type]);
        }
        $categories = $query->orderBy(['weight' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
        return TreeHelper::list2tree($categories);
    }

    /**
     * 获取扁平分类列表 (含等级深度)
     * @param int $type
     * @return array
     */
    public function getFlat($type = null)
    {
        $query = Category::find();
        if ($type !== null) {
            $query->where(['type' => $type]);
        }
        return $query->orderBy(['weight' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
    }

    /**
     * 根据学科和学段获取关联的章节/知识点
     * @param int $course
     * @param int $period
     * @return array
     */
    public function getByCourse($course, $period)
    {
        $subjectIds = Subject::find()
            ->select('sid')
            ->where(['course' => $course, 'period' => $period])
            ->column();

        if (empty($subjectIds)) {
            return [];
        }

        return Category::find()
            ->where(['in', 'id', $subjectIds])
            ->orderBy(['weight' => SORT_ASC])
            ->asArray()
            ->all();
    }

    /**
     * 获取分类
     * @param $id
     * @return Category|null
     */
    public function get($id)
    {
        return Category::findOne($id);
    }
}

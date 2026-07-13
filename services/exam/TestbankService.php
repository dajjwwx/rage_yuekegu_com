<?php

namespace services\exam;

use Yii;
use common\components\Service;
use common\models\exam\Testbank;
use common\models\exam\TestbankPrint;
use common\models\exam\Course;
use yii\data\Pagination;

/**
 * 题库服务
 *
 * Class TestbankService
 * @package services\exam
 */
class TestbankService extends Service
{
    /**
     * 获取题库
     * @param $id
     * @return Testbank|null
     */
    public function get($id)
    {
        return Testbank::findOne($id);
    }

    /**
     * 题库列表
     * @param array $params
     * @param int $pageSize
     * @return array
     */
    public function getList($params = [], $pageSize = 20)
    {
        $query = Testbank::find();

        if (!empty($params['period'])) {
            $query->andWhere(['period' => $params['period']]);
        }
        if (!empty($params['course_id'])) {
            $query->andWhere(['course_id' => $params['course_id']]);
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

        $items = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['create_at' => SORT_DESC])
            ->all();

        return [
            'items' => $items,
            'total' => $totalCount,
            'page' => $pagination->page + 1,
            'pageSize' => $pageSize,
            'pageCount' => $pagination->pageCount,
        ];
    }
}

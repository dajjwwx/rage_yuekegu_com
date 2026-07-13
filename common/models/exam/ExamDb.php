<?php

namespace common\models\exam;

use Yii;
use yii\db\Connection;

/**
 * 题库系统跨库访问基类
 * 
 * 所有 `yuekegu` 库中的表通过此基类访问
 * `rage_yuekegu` 库中的表直接用默认 db 连接
 */
class ExamDb
{
    /**
     * 获取主站数据库连接（yuekegu 库）
     * @return Connection
     */
    public static function getDb()
    {
        return Yii::$app->db_yuekegu;
    }
}

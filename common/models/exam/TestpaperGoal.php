<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_testpaper_goal (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $paper_id
 * @property string $goal_1
 * @property string $goal_2
 * @property string $type
 */
class TestpaperGoal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_testpaper_goal';
    }

    /**
     * 返回主站数据库连接
     * @return \yii\db\Connection
     */
    public static function getDb()
    {
        return Yii::$app->db_yuekegu;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'paper_id' => '',
            'goal_1' => '',
            'goal_2' => '',
            'type' => '',
        ];
    }
}

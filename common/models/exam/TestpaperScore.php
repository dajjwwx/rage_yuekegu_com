<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_testpaper_score (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $student_id
 * @property string $paper_id
 * @property string $score
 * @property string $goal_diff_1
 * @property string $goal_diff_2
 * @property string $course
 * @property string $user_id
 * @property string $rank_area
 * @property string $rank_county
 * @property string $rank_grade
 * @property string $rank_class
 * @property string $exam_number
 */
class TestpaperScore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_testpaper_score';
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
            'student_id' => '',
            'paper_id' => '',
            'score' => '',
            'goal_diff_1' => '',
            'goal_diff_2' => '',
            'course' => '',
            'user_id' => '',
            'rank_area' => '',
            'rank_county' => '',
            'rank_grade' => '',
            'rank_class' => '',
            'exam_number' => '',
        ];
    }
}

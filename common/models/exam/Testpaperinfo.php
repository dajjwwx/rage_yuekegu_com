<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_testpaperinfo (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $testpaper_id
 * @property string $user_id
 * @property string $question_type
 * @property string $question_id
 * @property string $score
 * @property string $question_num
 * @property string $rate
 */
class Testpaperinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_testpaperinfo';
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
            'testpaper_id' => '',
            'user_id' => '',
            'question_type' => '',
            'question_id' => '',
            'score' => '',
            'question_num' => '',
            'rate' => '',
        ];
    }
}

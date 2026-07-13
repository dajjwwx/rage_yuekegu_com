<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_question (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $type
 * @property string $content
 * @property string $pubdate
 * @property string $category_ids
 * @property string $user_id
 * @property string $source
 * @property string $source_num
 * @property string $rate
 * @property string $status
 * @property string $course
 * @property string $period
 * @property string $matching
 * @property string $score
 * @property string $leaf_parent
 * @property string $version_parent
 * @property string $tags
 * @property string $uuid
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_question';
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
            'type' => '',
            'content' => '',
            'pubdate' => '',
            'category_ids' => '',
            'user_id' => '',
            'source' => '',
            'source_num' => '',
            'rate' => '',
            'status' => '',
            'course' => '',
            'period' => '',
            'matching' => '',
            'score' => '',
            'leaf_parent' => '',
            'version_parent' => '',
            'tags' => '',
            'uuid' => '',
        ];
    }
}

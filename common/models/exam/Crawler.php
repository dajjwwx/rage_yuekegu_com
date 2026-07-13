<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_crawler (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $name
 * @property string $command
 * @property string $created
 * @property string $question_id
 */
class Crawler extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_crawler';
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
            'name' => '',
            'command' => '',
            'created' => '',
            'question_id' => '',
        ];
    }
}

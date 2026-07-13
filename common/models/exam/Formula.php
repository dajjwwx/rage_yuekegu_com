<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_formula (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $course
 * @property string $catalog
 * @property string $formula
 * @property string $weight
 */
class Formula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_formula';
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
            'course' => '',
            'catalog' => '',
            'formula' => '',
            'weight' => '',
        ];
    }
}

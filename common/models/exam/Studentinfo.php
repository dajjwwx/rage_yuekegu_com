<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stu_studentinfo (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $user_id
 * @property string $class
 * @property string $oldclass
 * @property string $name
 * @property string $sex
 * @property string $age
 * @property string $identification
 * @property string $studentcode
 * @property string $options
 */
class Studentinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stu_studentinfo';
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
            'user_id' => '',
            'class' => '',
            'oldclass' => '',
            'name' => '',
            'sex' => '',
            'age' => '',
            'identification' => '',
            'studentcode' => '',
            'options' => '',
        ];
    }
}

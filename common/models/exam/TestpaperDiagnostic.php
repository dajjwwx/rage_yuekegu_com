<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_testpaper_diagnostic (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $paper_id
 * @property string $school_id
 * @property string $grade
 * @property string $allow_lookup
 */
class TestpaperDiagnostic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_testpaper_diagnostic';
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
            'school_id' => '',
            'grade' => '',
            'allow_lookup' => '',
        ];
    }
}

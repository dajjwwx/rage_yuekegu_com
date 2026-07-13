<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stb_print (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $source_from
 * @property string $file_ids
 * @property string $unit
 * @property int $print_way
 * @property string $paper_type
 * @property float $print_double_sided
 * @property string $page_count
 * @property string $number
 * @property string $approval_result
 * @property string $user_id
 * @property string $approval_user_id
 * @property string $created_at
 * @property string $description
 */
class TestbankPrint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stb_print';
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
            'source_from' => '',
            'file_ids' => '',
            'unit' => '',
            'print_way' => '',
            'paper_type' => '',
            'print_double_sided' => '',
            'page_count' => '',
            'number' => '',
            'approval_result' => '',
            'user_id' => '',
            'approval_user_id' => '',
            'created_at' => '',
            'description' => '',
        ];
    }
}

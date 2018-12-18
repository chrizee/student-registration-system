<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faculties".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $created_at
 */
class Faculties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'created_at' => 'Created At',
        ];
    }
}

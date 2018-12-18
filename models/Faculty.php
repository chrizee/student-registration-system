<?php

namespace app\models;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "faculties".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $created_at
 */
class Faculty extends ActiveRecord
{

    public static function tableName() : String
    {
        return 'faculties';
    }

    public function rules() : array
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string','max' => 3]
        ];
    }

    public function beforeSave($insert) : bool
    {
        $this->code = strtoupper($this->code);
        $this->name = ucfirst($this->name);
        return parent::beforeSave($insert);
    }

    public function getDepartment() : ActiveQuery
    {
        return $this->hasMany(Department::class, ["faculty_id" => 'id']);
    }
}
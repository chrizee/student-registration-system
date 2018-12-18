<?php
/**
 * Created by PhpStorm.
 * User: OKORO EFE
 * Date: 12/5/2018
 * Time: 4:12 PM
 */

namespace app\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string code
 * @property string name
 */
class Department extends ActiveRecord
{
    public static function tableName() : String
    {
        return 'departments';
    }

    public function rules() : array
    {
        return [
            [['name', 'code', 'faculty_id'], 'required'],
            [['faculty_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) : bool
    {
        $this->code = strtoupper($this->code);
        $this->name = ucfirst($this->name);
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty() : ActiveQuery
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getStudent()
    {
        return $this->hasMany(Student::class, ['department_id' => 'id']);
    }
}
<?php

namespace app\models;

use yii\db\ActiveRecord;

/* @property string name*/
/* @property string level*/
/* @property string code*/
/* @property integer credit*/
/* @property integer faculty_id*/
/* @property integer department_id*/

class Course extends ActiveRecord
{

    public static function tableName() : String
    {
        return 'courses';
    }

    public function rules() : array
    {
        return [
            [['name','code', 'credit', 'faculty_id', 'department_id', 'level'], 'required'],
            [['name', 'code', 'level'], 'string'],
            [['code'], 'string', 'max' => 6],
            [['faculty_id', 'department_id', 'credit'], 'integer']
        ];
    }

    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => "faculty_id"]);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => "department_id"]);
    }

}
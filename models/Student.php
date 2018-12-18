<?php
/**
 * Created by PhpStorm.
 * User: OKORO EFE
 * Date: 12/5/2018
 * Time: 2:36 PM
 */

namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * @property mixed department_id
 * @property mixed level
 */
class Student extends ActiveRecord
{
    public $faculty_id;

    public static function tableName() : string
    {
        return "students";
    }

    public function rules() : array
    {
        return [
            [['department_id', 'level', 'reg_num'], 'required'],
            [['department_id'], 'integer'],
            ['level', 'string', 'max' => 3]
        ];
    }

    public function beforeSave($insert)
    {
        $this->user_id = Yii::$app->user->getId();
        return parent::beforeSave($insert);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRegistration()
    {
        return $this->hasOne(Registration::class, ['user_id' => 'user_id']);
    }

}
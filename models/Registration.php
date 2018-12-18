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
 * @property string courses
 */
class Registration extends ActiveRecord
{
    const PENDING = '0';
    const APPROVED = '1';
    const DISAPPROVED = '2';

    public static function tableName() : string
    {
        return "registrations";
    }

    public function rules()
    {
        return [
            [['courses'], 'required']
        ];
    }

    public function beforeSave($insert)
    {
        /*$this->user_id = Yii::$app->user->getId();
        $this->status = 0;*/
        return parent::beforeSave($insert);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::class, ['user_id' => 'user_id']);
    }

    public function getCourselist() {
        $id = explode(',',$this->courses);
        $courses = Course::findAll($id);
        $val = '';
        foreach ($courses as $course) {
            $val .= $course->name.', ';
        }
        return rtrim($val, ', ');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
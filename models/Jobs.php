<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $requirements
 * @property string $salary_range
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $contact_email
 * @property string $contact_phone
 * @property int $is_published
 * @property string $created_at
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'type', 'requirements', 'salary_range', 'city', 'state', 'zipcode', 'contact_email', 'contact_phone'], 'required'],
            [['category_id', 'is_published'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'type', 'requirements', 'salary_range', 'city', 'state', 'zipcode', 'contact_email', 'contact_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
            'requirements' => 'Requirements',
            'salary_range' => 'Salary Range',
            'city' => 'City',
            'state' => 'State',
            'zipcode' => 'Zipcode',
            'contact_email' => 'Contact Email',
            'contact_phone' => 'Contact Phone',
            'is_published' => 'Is Published',
            'created_at' => 'Created At',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => "category_id"]);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => "user_id"]);
    }

    public function beforeSave($insert)
    {
        $this->user_id = Yii::$app->user->identity->getId();
        return parent::beforeSave($insert);
    }
}

<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    /*
     * @var UploadedFile
     * */
    public $image;

    public function attributeLabels()
    {
        return [
            'password_repeat' => 'Confirm password',
        ];
    }


    public function upload()
    {
        if(!empty($this->image)) {
            $filename = "uploads/".uniqid().".".$this->image->extension;
            $this->image->saveAs($filename);
            return $filename;
        }
        return false;
    }
    public function rules()
    {
        return [
            [['fullname', 'username', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'unique'],
            //['image', 'image'],
            ['image_url', 'safe'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Both passwords didn't match"]
        ];
    }
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
    *   {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null )
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            if(isset($this->password)) {
                $this->password = md5($this->password);
                return parent::beforeSave($insert);
            }
        }
        return true;
    }

    public function getJobs()
    {
        return $this->hasMany(Jobs::class, ['user_id' => 'id']);
    }

    public function getStudent() {
        return $this->hasOne(Student::class, ['user_id', 'id']);
    }

    public function getRegistration() {
        $this->hasOne(Registration::class, ['user_id' => 'id']);
    }
}

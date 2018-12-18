<?php

namespace app\models;

use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['body'], 'string', ]
        ];
    }
}
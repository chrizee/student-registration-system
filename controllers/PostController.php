<?php

namespace app\controllers;

use app\models\Posts;
use yii\web\Controller;
use Yii;
class PostController extends Controller
{
    public function actionIndex()
    {
        $posts = Posts::find()->all();
        return $this->render('index', ['posts' => $posts]);
    }

    public function actionCreate() {
        $post = new Posts();
        if($post->load(Yii::$app->request->post()) && $post->save()) {
            Yii::$app->getSession()->setFlash("success", "Post added successfully");
            return $this->redirect(['index']);
        }
        return $this->render('create', ['post' => $post]);
    }

    public function actionShow($id)
    {
        $post = Posts::findOne($id);
        return $this->render('show', ['post', $post]);
    }
    public function actionUpdate($id) {
        $post = Posts::findOne($id);
        if($post->load(Yii::$app->request->post()) && $post->save()) {
            Yii::$app->getSession()->setFlash("success", "Post updated successfully");
            return $this->redirect(["show", 'id' => $post->id ]);
        }
        return $this->render('update', ["post" => $post]);
    }

    public function actionDelete($id)
    {
        $post = Posts::findOne($id);
        if($post->delete()) {
            Yii::$app->getSession()->setFlash("success", "Post deleted successfully");
            return $this->redirect(['index']);
        }
    }
}
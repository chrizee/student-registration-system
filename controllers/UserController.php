<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public $layout = "new";
    private $_homeUrl = "index.php?r=dashboard/index";

    public function goHome()
    {
        return Yii::$app->getResponse()->redirect($this->_homeUrl);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('index.php?r=dashboard/index');
        }

        $model->password = '';
        return $this->renderPartial('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $user = new User();

        if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }
        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                $user->image = UploadedFile::getInstance($user, "image");
                $image_url = $user->upload();
                if ($image_url) $user->image_url = $image_url;
                //print_r($user->image_url);die;
                $user->save();
                Yii::$app->getSession()->setFlash('success', "Registration successful");
                Yii::$app->user->login($user);
                return $this->redirect(['dashboard/index']);
            }
        }

        return $this->renderPartial('register', [
            'user' => $user,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionProfile()
    {
        return 'profile';
    }

}

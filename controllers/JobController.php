<?php

namespace app\controllers;

use app\models\Jobs;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class JobController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'edit', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }

    public function actionCreate()
    {
        $job = new Jobs();

        if ($job->load(Yii::$app->request->post())) {
            if ($job->validate()) {
                $job->save();
                Yii::$app->getSession()->setFlash('success', 'Job Added');
                return $this->redirect(["index"]);
            }
        }

        return $this->render('create', [
            'job' => $job,
        ]);
    }

    public function actionShow($id)
    {
        $job = Jobs::find()->where(['id' => $id])->one();
        return $this->render('show', ['job' => $job]);
    }

    public function actionDelete($id)
    {
        $job = Jobs::findOne($id);
        if(Yii::$app->user->identity->getId() != $job->user_id) {
            Yii::$app->getSession()->setFlash('success', "You can only delete your own post");
            return $this->redirect(['index']);
        }
        if($job->delete()) Yii::$app->getSession()->setFlash('success', "Job deleted");
        else Yii::$app->getSession()->setFlash('success', "Problem deleting jobs");
        return $this->redirect(['index']);
    }

    public function actionEdit($id)
    {
        $job = Jobs::find()->where(['id' => $id])->one();

        if(Yii::$app->user->identity->getId() != $job->user_id) {
            Yii::$app->getSession()->setFlash('success', "You can only edit your own post");
            return $this->redirect(['index']);
        }
        if($job->load(Yii::$app->request->post()) && $job->save()) {
            Yii::$app->getSession()->setFlash('success', "Job Edited");
            return $this->redirect(['show', 'id' => $id]);
        }
        return $this->render('edit', [
            'job' => $job
        ]);
    }

    public function actionIndex()
    {
        $query = Jobs::find();
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count()
        ]);
        $jobs = $query->where(['is_published' => '1'])->orderBy('created_at DESC')->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'jobs' => $jobs,
            'pagination' => $pagination
        ]);
    }
}

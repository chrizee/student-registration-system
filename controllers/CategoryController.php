<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }

    public function actionCreate()
    {
        $category = new Category();

        if ($category->load(Yii::$app->request->post())) {
            if ($category->validate()) {
                $category->save();
                Yii::$app->getSession()->setFlash('success', 'Category Added');
                return $this->redirect(["index"]);
                //return $this->redirect("index.php?r=category");
            }
        }

        return $this->render('create', [
            'category' => $category,
        ]);
    }

    public function actionIndex()
    {
        $query = Category::find();
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count()
        ]);
        $categories = $query->orderBy('name')->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'categories' => $categories,
            'pagination' => $pagination
        ]);
    }

}

<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
?>
<h2 class="page-header">Categories <a href="index.php?r=category/create" class="btn btn-primary pull-right">Create</a> </h2>

<?php /*if(Yii::$app->session->hasFlash('success')) : */?><!--
    <div class="alert alert-success">
        <?/*= Yii::$app->session->getFlash('success')*/?>
    </div>
--><?php /*endif; */?>


<ul class="list-group">
    <?php foreach ($categories as $category) :?>
        <li class="list-group-item"><a href="index.php?r=job&category=<?= $category->id ?>"><?= $category->name ?></a></li>
    <?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination])?>
<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
?>
    <h2 class="page-header">Jobs <a href="index.php?r=job/create" class="btn btn-primary pull-right">Create</a> </h2>

<?php /*if(Yii::$app->session->hasFlash('success')) : */?><!--
    <div class="alert alert-success">
        <?/*= Yii::$app->session->getFlash('success')*/?>
    </div>
--><?php /*endif; */?>

<?php if(!empty($jobs)) :?>
    <ul class="list-group">
        <?php foreach ($jobs as $job) :?>
            <li class="list-group-item"><a href="index.php?r=job/show&id=<?= $job->id ?>"><?= $job->title ?> <strong><?= $job->city.' '.$job->state ?> -listed on <?= (new DateTime($job->created_at))->format("F j, Y g:i a") ?></strong></a></li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>No jobs to list.</p>
    <?php endif;?>
<?= LinkPager::widget(['pagination' => $pagination])?>
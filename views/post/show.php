<?php
use yii\helpers\Html;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash("success") ?>
    </div>
<?php endif; ?>

<div class="row">
    <span><?= Html::a("Create",['/post/create'], ['class' => "btn btn-primary"])?></span>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="body-content">
            <ul class="list-group">
                <li><?php echo  $post->title ?></li>
                <li><?php echo $post->body ?></li>
            </ul>
        </div>
    </div>
</div>

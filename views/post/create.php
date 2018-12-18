<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash("success") ?>
    </div>
<?php endif; ?>
<h2>Create post</h2>
<div class="row">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($post, 'title')->textInput(['autofocus' => true])?>
    <?= $form->field($post, 'body')->textarea(['rows' => 6])?>

    <div class="form-group">
        <?= Html::submitButton("Create", ['class' => "btn btn-success"])?>
    </div>
    <?php ActiveForm::end() ?>
</div>
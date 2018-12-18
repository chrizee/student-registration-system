<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $job app\models\Jobs */
/* @var $form ActiveForm */
?>
<h2 class="page-header">Create Job</h2>
<div class="job-create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($job, 'category_id')->dropDownList(\app\models\Category::find()
            ->select(['name','id'])->indexBy('id')->column(), ['prompt' => 'Select Category']
        ) ?>
        <?= $form->field($job, 'title') ?>
        <?= $form->field($job, 'description')->textarea(['rows' => 6]) ?>
        <?= $form->field($job, 'type')->dropDownList([
                'Full time' => 'Full Time',
                'Part Time' => "Part Time",
                'As Needed' => "As Needed"
        ],['prompt' => 'Select Type']) ?>
        <?= $form->field($job, 'requirements') ?>
        <?= $form->field($job, 'salary_range')->dropDownList([
                'Under $20k' => 'Under $20k',
                '$20k - $40k' => '$20k - $40k',
                '$40k - $60k' => '$40k - $60k',
                '$60k - $80k' => '$60k - $80k',
                '$80k - $100k' => '$80k - $100k',
                '$100k - $150k' => '$100k - $150k',
                '$150k - $200k' => '$150k - $200k',
                'above $200k' => 'above $200k',
        ], ['prompt' => 'Select a range']) ?>
        <?= $form->field($job, 'city') ?>
        <?= $form->field($job, 'state') ?>
        <?= $form->field($job, 'zipcode') ?>
        <?= $form->field($job, 'contact_email') ?>
        <?= $form->field($job, 'contact_phone') ?>
        <?= $form->field($job, 'is_published')->radioList(['0' => "No", '1' => "Yes"]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- job-create -->

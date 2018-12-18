<?php
/* @var $departments app\models\Department */
/* @var $department app\models\Department */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row" style="margin-left: 15px; margin-bottom: 1em;">
    <button class="btn btn-sm btn-default new"><i class="fa fa-plus fa-arrow-circle-right"></i> <span>New</span></button>
</div>
<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Departments</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if($departments): ?>
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Department</th>
                        <th>Faculty</th>
                        <th>Short Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($departments as $value):?>
                        <tr>
                            <td><?= $value->name ?></td>
                            <td><?= $value->faculty->name ?></td>
                            <td><?= $value->code ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text text-center">No Department yet.</p>
            <?php endif; ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<section class="col-lg-6 connectedSortable new-item hidden">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Add Department</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($department, 'faculty_id')->dropDownList(\app\models\Faculty::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => "Select Faculty"])->label("Faculty")?>
            <?= $form->field($department, 'name')?>
            <?= $form->field($department, 'code')?>

            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => "btn btn-primary"])?>
            </div>
            <?php ActiveForm::end() ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function() {
        $("body").on("click", "button.new", function() {
            $("section.new-item").toggleClass("hidden");
        })
    })
</script>
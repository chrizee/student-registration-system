<?php
/* @var $faculties app\models\Faculty*/
/* @var $faculty app\models\Faculty*/
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row" style="margin-left: 15px; margin-bottom: 1em;">
    <button class="btn btn-sm btn-default new"><i class="fa fa-plus fa-arrow-circle-right"></i> <span>New</span></button>
</div>
<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Faculty</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if($faculties): ?>
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Faculty</th>
                            <th>Short Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($faculties as $value):?>
                            <tr>
                                <td><?= $value->name ?></td>
                                <td><?= $value->code ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text text-center">No faculty yet.</p>
            <?php endif; ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<section class="col-lg-6 connectedSortable new-item hidden">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Add Faculty</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($faculty, 'name')?>
            <?= $form->field($faculty, 'code')?>

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
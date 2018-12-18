<?php
/* @var $registration app\models\Registration */
/* @var $table bool */
/* @var $courses array */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?php echo  ($table) ? "Courses registered" : "Complete your registration" ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if($table): ?>
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; foreach ($courses as $course):?>
                            <?php $total += (int) $course->credit ?>
                            <tr>
                            <th><?= $course->name ?></th>
                            <td><?= $course->credit ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <td><?= $total ?></td>
                        </tr>
                    </tfoot>
                </table>
                    <div class="row" style="margin-left: 15px; margin-bottom: 1em; margin-top: 1em;">
                        <div class="col-md-12">
                            <?php if ($registration->status == 0) :?>
                                <p class="text text-left">Waiting response. You can edit your course list while waiting approval.</p>
                                <button class="pull-right btn btn-sm btn-default new"><i class="fa fa-edit"></i> <span>Edit Courses</span></button>
                            <?php else: ?>
                                <button class="pull-right btn btn-sm btn-default new"><i class="fa fa-eye"></i> <span>View Status</span></button>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php else: ?>
                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($registration, 'courses')->checkboxList($courses)->label("Select Courses")?>

                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => "btn btn-primary"])?>
                </div>
                <?php ActiveForm::end() ?>
            <?php endif; ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<?php if($table): ?>
<section class="col-lg-6 connectedSortable new-item hidden">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?= $registration->status == 0 ? "Edit course list" : "Status"?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if ($registration->status == 0) :?>

                <?php $form = ActiveForm::begin(['action' => "index.php?r=dashboard/edit-course&id=".$registration->id]) ?>

                    <?= $form->field($registrationEdit, 'courses')->checkboxList($coursesEdit)->label("Select Courses")?>

                    <div class="form-group">
                        <?= Html::submitButton('Register', ['class' => "btn btn-primary"])?>
                    </div>
                <?php ActiveForm::end() ?>
            <?php else: ?>
                <p class="text text-center"><?= Html::encode($registration->message)?></p>
            <?php endif; ?>
        </div>
        <!-- /.box-body -->
    </div>

</section>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("body").on("click", "button.new", function() {
            $("section.new-item").toggleClass("hidden");
        });
    })
</script>
<?php
/* @var $student app\models\Student */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><?= ($table) ? "Details" : "Complete you registration"; ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if($table): ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th>Department</th>
                        <td><?= $student->department->name ?></td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td><?= $student->level ?></td>
                    </tr>
                </table>
                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <?php if (empty($registration)) :?>
                            <a href="index.php?r=dashboard/register-course" class="pull-right btn btn-primary">Register Courses</a>
                        <?php else: ?>
                            <a href="index.php?r=dashboard/register-course" class=" pull-right btn btn-success">View Status</a>
                        <?php endif;?>
                    </div>
                </div>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($student, 'reg_num')->textInput(['autofocus' => true])->label("Reg Number")?>
                <?= $form->field($student, 'faculty_id')->dropDownList(\app\models\Faculty::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => "Select Faculty"])->label("Faculty")?>
                <?= $form->field($student, 'department_id')->dropDownList([], ['prompt' => "Select Department"])->label("Department")?>
                <?= $form->field($student, 'level')->dropDownList([
                    '100' => "100",
                    '200' => "200",
                    '300' => "300",
                    '400' => "400",
                    '500' => "500",
                ],['prompt' => "Select level"])?>
                <div class="form-group">
                    <?= Html::submitButton("Submit", ['class' => "btn btn-primary"])?>
                </div>
                <?php ActiveForm::end()?>
            <?php endif; ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function() {
        $("body").on("click", "button.new", function() {
            $("section.new-item").toggleClass("hidden");
        }).on("change", "select#student-faculty_id",(e) => {
            let id = e.target.value; //$(this).val();
            $.get("index.php?r=dashboard/get-department-from-faculty-ajax&faculty="+id, function (response) {
                $("select#student-department_id").empty();
                if(response) {
                    $("select#student-department_id").append(response);
                    console.log(response, id);
                }
            });
        });
    })
</script>
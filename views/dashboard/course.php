<?php
/* @var $courses app\models\Course */
/* @var $course app\models\Course */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row" style="margin-left: 15px; margin-bottom: 1em;">
    <button class="btn btn-sm btn-default new"><i class="fa fa-plus fa-arrow-circle-right"></i> <span>New</span></button>
</div>
<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Courses</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if($courses): ?>
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Course</th>
                        <th>Code</th>
                        <th>Faculty</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($courses as $value):?>
                        <tr>
                            <td><?= $value->name ?></td>
                            <td><?= $value->code ?></td>
                            <td><?= $value->faculty->name ?></td>
                            <td><?= $value->department->name ?></td>
                            <td><?= $value->level ?></td>
                            <td><?= $value->credit ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text text-center">No Course yet.</p>
            <?php endif; ?>

        </div>
        <!-- /.box-body -->
    </div>

</section>

<section class="col-lg-6 connectedSortable new-item hidden">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Add Course</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($course, 'name')?>
            <?= $form->field($course, 'faculty_id')->dropDownList(\app\models\Faculty::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => "Select Faculty"])->label("Faculty")?>
            <?= $form->field($course, 'department_id')->dropDownList([], ['prompt' => "Select Department"])->label("Department")?>
            <?= $form->field($course, 'code')?>
            <?= $form->field($course, 'level')->dropDownList([
                    '100' => "100",
                    '200' => "200",
                    '300' => "300",
                    '400' => "400",
                    '500' => "500",
            ],['prompt' => "Select level"])?>
            <?= $form->field($course, 'credit')?>

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
        }).on("change", "select#course-faculty_id",(e) => {
            let id = e.target.value; //$(this).val();
            $.get("index.php?r=dashboard/get-department-from-faculty-ajax&faculty="+id, function (response) {
                if(response) {
                    $("select#course-department_id").append(response);
                    console.log(response, id);
                }
            });
        }).on("change", "select#course-department_id", function(e) {
            let val = $(this).filter(":selected").className;
            console.log(val, $(this));
            $("input#course-code").val(val);
        })
    })
</script>
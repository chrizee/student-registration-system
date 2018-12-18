<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="col-lg-6 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Registration</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?= $registration->user->fullname?></td>
                    </tr>
                    <tr>
                        <th>Reg number</th>
                        <td><?= $registration->student->reg_num?></td>
                    </tr>
                    <tr>
                        <th>Faculty</th>
                        <td><?= $registration->student->department->faculty->name?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?= $registration->student->department->name?></td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td><?= $registration->student->level ?></td>
                    </tr>
                    <tr>
                        <th>Courses</th>
                        <td><?= $registration->courselist?></td>
                    </tr>
                        <tr>
                            <th>Status</th>
                            <th><?php
                                if($registration->status == \app\models\Registration::PENDING) echo "Waiting Approval";
                                if($registration->status == \app\models\Registration::APPROVED) echo "Approved";
                                if($registration->status == \app\models\Registration::DISAPPROVED) echo "Rejected";
                                ?>
                            </th>
                        </tr>
                </tbody>
            </table>
            <?php if($registration->status != \app\models\Registration::APPROVED): ?>
            <div class="row" style="margin-top: 1em;">
                <div class="col-md-12">
                    <button class="btn btn-primary new pull-right">Change status</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- /.box-body -->
    </div>

</section>


<section class="col-lg-6 connectedSortable new-item hidden">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Respond to registration</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($registration, 'message')->textarea(['rows' => 6])->label("Message")?>
                <?= $form->field($registration, 'status')->radioList([
                        '1' => "Approve",
                        "2" => "Reject"
                ])?>
                <div class="form-group">
                    <?= Html::submitButton('Respond', ['class' => "btn btn-success"])?>
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
        });
    })
</script>
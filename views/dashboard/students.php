<section class="col-lg-10 connectedSortable">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Students</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Reg Number</th>
                        <th>Faculty</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Registration Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><a href="index.php?r=dashboard/registration&id=<?= $student->user_id?>"><?= $student->user->fullname?></a></td>
                            <td><?= $student->reg_num?></td>
                            <td><?= $student->department->faculty->name?></td>
                            <td><?= $student->department->name?></td>
                            <td><?= $student->level ?></td>
                            <td><?php if($student->registration) {
                                        if($student->registration->status == \app\models\Registration::PENDING) echo "Waiting Approval";
                                        if($student->registration->status == \app\models\Registration::APPROVED) echo "Approved";
                                        if($student->registration->status == \app\models\Registration::DISAPPROVED) echo "Rejected";
                                    }else {
                                    echo "Not registered";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
    </div>

</section>
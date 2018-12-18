<a href="index.php?r=job">Go back</a>
<h2 class="page-header"><?= $job->title?> in <small><?= $job->city.", ".$job->state?></small>
    <?php if(Yii::$app->user->identity->getId() == $job->user_id) :?>
        <span class="pull-right">
            <a class="btn btn-default" href="index.php?r=job/edit&id=<?= $job->id ?>">Edit</a>
            <a class="btn btn-danger" href="index.php?r=job/delete&id=<?= $job->id ?>">Delete</a>
        </span>
    <?php endif;?>
</h2>
<?php if(!empty($job->description)) :?>
    <div class="well">
        <?= $job->description ?>
    </div>
<?php endif;?>

<ul class="list-group">
    <li class="list-group-item"><strong>Listing date: </strong><?= (new DateTime($job->created_at))->format("F j, Y g:i a") ?></li>

    <?php if(!empty($job->category->name)) :?>
        <li class="list-group-item"><strong>Category: </strong><?= $job->category->name ?></li>
    <?php endif; ?>

    <?php if(!empty($job->type)) :?>
        <li class="list-group-item"><strong>Employment type: </strong><?= $job->type ?></li>
    <?php endif; ?>

    <?php if(!empty($job->requirements)) :?>
        <li class="list-group-item"><strong>Requirements: </strong><?= $job->requirements ?></li>
    <?php endif; ?>

    <?php if(!empty($job->salary_range)) :?>
        <li class="list-group-item"><strong>Category: </strong><?= $job->salary_range ?></li>
    <?php endif; ?>

    <?php if(!empty($job->contact_email)) :?>
        <li class="list-group-item"><strong>Employer's email: </strong><?= $job->contact_email ?></li>
    <?php endif; ?>

    <?php if(!empty($job->contact_phone)) :?>
        <li class="list-group-item"><strong>Employer's phone: </strong><?= $job->contact_phone ?></li>
    <?php endif; ?>
</ul>
<a class="btn btn-primary" href="mailto:<?= $job->contact_email ?>?Subject=Job%20Application">Contact Employer</a>
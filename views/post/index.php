<?php
use yii\helpers\Html;
?>

<div class="row">
    <span><?= Html::a("Create",['/post/create'], ['class' => "btn btn-primary"])?></span>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="table-responsive">
            <?php if(count($posts) > 0):?>
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= Html::encode($post->id) ?></td>
                            <td><?= Html::encode($post->title) ?></td>
                            <td><?= Html::encode($post->body) ?></td>
                            <td><?= Html::encode($post->created) ?></td>
                            <td>
                                <span><?= Html::a("View", ["/post/show", 'id' => $post->id], ['class' => "label label-primary"]) ?></span>

                                <span><?= Html::a("Update", ["/post/update", 'id' => $post->id], ['class' => "label label-default"]) ?></span>
                                <span><?= Html::a("Delete", ["/post/delete", 'id' => $post->id], ['class' => "label label-danger"]) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                <?php else: ?>
                <p class="text text-danger">No post to display.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

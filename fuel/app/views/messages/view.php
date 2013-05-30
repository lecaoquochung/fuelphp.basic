<strong>Message:</strong>
<?php echo $message->message; ?></p>
<h3>Comments</h3>
<ul>
<?php foreach ($comments as $comment) : ?>
    <li>
    <ul>
        <li><strong>Name:</strong> <?php echo $comment->name; ?></li>
        <li><strong>Comment:</strong><br /><?php echo $comment->comment; ?></li>
        <li><p><?php echo Html::anchor('comments/edit/'.$comment->id.'/'.$message->id, 'Edit'); ?>|
        <?php echo Html::anchor('comments/delete/'.$comment->id.'/'.$message->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?></li>
    </ul>
    </li>
<?php endforeach; ?>
</ul>
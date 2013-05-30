<h2>Listing <span class='muted'>Users</span></h2>
<br>
<?php if ($users): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Username</th>
			<th>Password</th>
			<th>Group</th>
			<th>Email</th>
			<th>Last login</th>
			<th>Login hash</th>
			<th>Ip</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($users as $user): ?>		<tr>

			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->password; ?></td>
			<td><?php echo $user->group; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo $user->last_login; ?></td>
			<td><?php echo $user->login_hash; ?></td>
			<td><?php echo $user->ip; ?></td>
			<td>
				<?php echo Html::anchor('user/view/'.$user->id, '<i class="icon-eye-open" title="View"></i>'); ?> |
				<?php echo Html::anchor('user/edit/'.$user->id, '<i class="icon-wrench" title="Edit"></i>'); ?> |
				<?php echo Html::anchor('user/delete/'.$user->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Users.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('user/create', 'Add new User', array('class' => 'btn btn-success')); ?>

</p>

<?php

?>

<ul>
	<li><a href="/?action=newitem">Upload a song</a></li>
</ul>


<?php if(LoggedInUserIsAdmin()) : ?>

	Admin Items:<br />
	<ul>
		<li><a href="/?action=editusers">Edit Users</a></li>
	</ul>

<?php endif; ?>
		
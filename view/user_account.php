<?php echo $error ?><br />

<label>Username:</label> <?php echo $details['username'] ?><br />
<label>Email:</label><?php echo $details['email'] ?><br />

<form method="post">
	<?php echo $error ?><br />
    <label>Password</label> <input type="password" name="password" value="" /><br />
    <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
    <input type="submit" name="updatepw" value="Create User" />
</form>


<label>Username:</label> <?php echo $this->_data['username'] ?><br />
<label>Email:</label><?php echo $this->_data['email'] ?><br />

<form method="post">
	<?php echo $this->_data['error'] ?><br />
    <label>Password</label> <input type="password" name="password" value="" /><br />
    <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
    <input type="submit" name="updatepw" value="Change Password" />
</form>

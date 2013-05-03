<form method="post">
	<?php echo $this->_data['error'] ?><br />
    <label>Username</label> <input type="text" name="user" value="<?php echo $this->_data['user'] ?>" />
    <label>Password</label> <input type="password" name="pass" value="<?php echo $this->_data['pass'] ?>" />
    <input type="submit" name="login" value="Log In" />
</form>

<form method="post">
    <?php echo $this->_data['error'] ?><br />
    
    <label>Username</label> <input type="text" name="username" value="<?php echo $this->_data['username'] ?>" /><br />
    <label>Email</label> <input type="text" name="email" value="<?php echo $this->_data['email'] ?>" /><br />
    <label>Password</label> <input type="password" name="password" value="<?php echo $this->_data['password'] ?>" /><br />
    <label>Password Again</label> <input type="password" name="password_check" value="<?php echo $this->_data['password_check'] ?>" /><br />
    <input type="submit" name="create" value="Create User" />
</form>

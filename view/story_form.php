<form method="post">
    <?php echo $this->_data['error'] ?><br />

    <label>Headline:</label> <input type="text" name="headline" value="<?php echo $this->_data['headline'] ?>" /> <br />
    <label>URL:</label> <input type="text" name="url" value="<?php echo $this->_data['url'] ?>" /><br />
    <input type="submit" name="create" value="Create" />
</form>

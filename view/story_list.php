<a class="headline" href="<?php echo $this->_data['story']['url'] ?>"><?php echo $this->_data['story']['headline'] ?></a><br />
<span class="details"><?php echo $this->_data['story']['created_by'] ?> | <?php echo $this->_data['comment_count'] ?> Comments | 
<?php echo date('n/j/Y g:i a', strtotime($this->_data['story']['created_on'])) ?></span>
    
<?php 
if($this->_data['authenticated']) {
?>
	<form method="post" action="/comment/create">
	<input type="hidden" name="story_id" value="<?php echo $_GET['id'] ?>" />
	<textarea cols="60" rows="6" name="comment"></textarea><br />
	<input type="submit" name="submit" value="Submit Comment" />
	</form>            
<?php
}
?>
<?php 

foreach($this->_data['comments'] as $comment) {
	print('
	<div class="comment"><span class="comment_details">' . $this->_data['comment']['created_by'] . ' | ' .
	date('n/j/Y g:i a', strtotime($this->_data['comment']['created_on'])) . '</span>
	' . $this->_data['comment']['comment'] . '</div>
	');
}

?>

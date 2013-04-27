<a class="headline" href="<?php echo $story['url'] ?>"><?php echo $story['headline'] ?></a><br />
<span class="details"><?php echo $story['created_by'] ?> | <?php echo $comment_count ?> Comments | 
<?php echo date('n/j/Y g:i a', strtotime($story['created_on'])) ?></span>
    
if($this->session->isAuthenticated()) {
	<form method="post" action="/comment/create">
	<input type="hidden" name="story_id" value="<?php echo $_GET['id'] ?>" />
	<textarea cols="60" rows="6" name="comment"></textarea><br />
	<input type="submit" name="submit" value="Submit Comment" />
	</form>            
}

<?php 

foreach($comments as $comment) {
	print('
	<div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
	date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
	' . $comment['comment'] . '</div>
	');
}

?>

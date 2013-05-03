<ol>

<?php 
foreach($stories as $story) {
?>

<li>
<a class="headline" href="<?php echo $story['url'] ?>"><?php $story['headline'] ?></a><br />
<span class="details"><?php echo $story['created_by'] ?> | <a href="/story/?id=<?php echo $story['id'] ?>"><?php echo $count ?> Comments</a> | 
<?php echo date('n/j/Y g:i a', strtotime($story['created_on'])) ?></span>
</li>

<?php
}
?>

</ol>

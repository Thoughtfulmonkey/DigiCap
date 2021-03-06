<!DOCTYPE html>
<head>
	<title>Forum list</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="<?php echo $APPROOT; ?>/css/default.css">
	<script src="<?php echo $APPROOT; ?>/js/jquery-3.1.0.min.js"></script>
</head>

<body>

	<?php echo $this->render('app/views/header.php',$this->mime,get_defined_vars(),0); ?>

	<div id="discussion_listing">

		<h2>Choose a discussion</h2>
	
		<?php foreach (($forumlist?:array()) as $forum): ?>
			<div class="discussion_block">
				<a href="discussion/<?php echo $forum['fid']; ?>"><?php echo $forum['title']; ?></a><br>
			</div>
		<?php endforeach; ?>
		
	</div>
	
</body>

</html>
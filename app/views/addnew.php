<!DOCTYPE html>
<head>
	<title>Digital Capabilities</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="{{ @APPROOT }}/css/default.css">
	<script src="{{ @APPROOT }}/js/jquery-3.1.0.min.js"></script>
	<script>
	 
		// TODO: check for required fields before posting
	 
		var tabi = 1;
	 
		// Document is ready
		$('document').ready(function(){
		
			// Adda new tab
			$('#new_tab_button').click( function(){
				
				tabi++;
				
				// The inner HTML
				var html = '<div id="close_'+tabi+'" class="close_button">x</div>';
				html +=	'<label for="tab_title_'+tabi+'">Title:</label>';
				html +=	'<input name="tab_title_'+tabi+'" type="text"><br>';
					
				html +=	'<label for="type_'+tabi+'">Type :</label>';
				html +=	'<input type="radio" name="type_'+tabi+'" value="1" class="type_choice" checked="checked">Video';
				html +=	'<input type="radio" name="type_'+tabi+'" value="2" class="type_choice">Text';
				html +=	'<input type="radio" name="type_'+tabi+'" value="3" class="type_choice">Code<br />';
					
				html +=	'<label for="tab_content_'+tabi+'">Content: </label>';
				html +=	'<textarea name="tab_content_'+tabi+'" type="text"></textarea><br>';
				
				html +=	'<label for="tab_side_'+tabi+'">Side Panel: </label>';
				html +=	'<textarea name="tab_side_'+tabi+'" type="text"></textarea><br>';
				
				// Build the div
				var tab = document.createElement('div');
				$(tab).addClass("tab_definition")
					.html(html)
					.attr("id", "tab_"+tabi)
					.appendTo('#tab_container');
					
				// Listener for the close button
				$(tab).find('.close_button').click(function(){
					
					$(this).parent().remove();
				});
				
			});
		
		});
		
	</script>
</head>

<body>
	
	<div id="new_object_panel">
	
		<h1>Add a New Learning Object</h1>
	
		<form method="POST" action="buildlo" class="tab_create_form">
		
			<label for="title">Title:</label>
			<input name="title" type="text"><br>
			
			<div id="tab_title">Tabs</div>
			
			<div id="tab_container">
			</div>
			
			<div id="new_tab_button">+ new tab</div>
			
			<label for="tags">Tags:</label>
			<input name="tags" type="text"><br>
			
			<br>
			<div style="text-align:center;">
				<input type="submit" value="Save">
			</div>
		
		</form>
	
	</div>
	
</body>
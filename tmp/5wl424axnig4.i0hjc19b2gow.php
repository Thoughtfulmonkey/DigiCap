<!DOCTYPE html>
<head>
	<title>Digital Capabilities</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="<?php echo $APPROOT; ?>/css/default.css">
	<script src="<?php echo $APPROOT; ?>/js/jquery-3.1.0.min.js"></script>
	<script>

		var learnObj;
	
		// Display a tab
		function displayTab(index){
			
			// Switch active tab
			$('.tab').removeClass('active');
			$('#tab_'+index).addClass('active');
			
			// Display side-panel text
			$('.side_panel').empty();
			if ( learnObj[index].sidePanelText ){
				$('.side_panel').show();
				$('.side_panel').append( learnObj[index].sidePanelText );
			}
			else {
				$('.side_panel').hide();
			}
			
			// Display content
			var type = learnObj[index].type;
			$('.content').empty();
			switch(type) {
				case "1":
					$('.content').append( '<div class="video_content"><iframe width="700" height="500" src="https://www.youtube.com/embed/'+learnObj[index].content+'" frameborder="0" allowfullscreen></iframe></div>' );
					break;
				case "2":
					$('.content').append( '<div class="text_content">'+learnObj[index].content+'</div>' );
					break;
				default:
					$('.content').append("Unknown content type");
			}

		}
		
		// Load a learning object
		function loadLearnObj(id){
			
			$.getJSON("<?php echo $APPROOT; ?>/loadlo/"+id, 
				function(result){
					
					learnObj = result;
					
					// Tidy up
					$('#tab_list').empty();
					
					// Loop through the returned objects
					for (var i=0; i<learnObj.length; i++){

						// Build the div for the tab
						var t = document.createElement('div');
						$(t).addClass("tab")
							.html(learnObj[i].title)
							.attr("id", 'tab_'+i)
							.appendTo( $('#tab_list') );
					}
					
					// Tab click listeners
					$('.tab').click( function(){
						displayTab( $(this).attr("id").substr(4) );
					});
					
					// Display the first tab
					displayTab(0);
				}
			);
		}
	
		// Document is ready
		$('document').ready(function(){
			
			// Load the first learning object
			loadLearnObj( <?php echo $los['0']['id']; ?> );
			
			// Load new learning objects
			$('.play_item').click( function(){
				
				loadLearnObj( $(this).attr('id') );
			});
			
		});
		
	</script>
</head>

<body>
	
	<div id="main_title">The Digital Capabilities Framework</div>
	
	<div id="playlist">
		<div id="playlist_title">Content found:</div>
		<?php foreach (($los?:array()) as $learnObj): ?>
			<div id="<?php echo $learnObj['id']; ?>" class="play_item"><?php echo $learnObj['title']; ?></div>
		<?php endforeach; ?>
	</div>
	
	<div id="lo_panel">
	
		<div id="tab_list">	
		</div>
	
		<div class="tab_content">
		
			<div class="content">
			</div>
			
			<div class="side_panel">
			</div>
		
		</div>
	
	</div>

</body>
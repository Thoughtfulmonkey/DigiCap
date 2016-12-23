<!DOCTYPE html>
<head>
	<title>Digital Capabilities</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="{{ @APPROOT }}/css/default.css">
	<script src="{{ @APPROOT }}/js/jquery-3.1.0.min.js"></script>
	<script>
	
		function pullList(author){
			
			$.getJSON("{{ @APPROOT }}/loadlist/"+author,
			
				function(result){

					var lastId = "unset";
					var obj = null;
					
					// Loop through the returned objects
					for (var i=0; i<result.length; i++){

						if ( result[i].id != lastId ){
							
							//console.log("adding");
							//console.log(result[i]);
							
							// Save the last one?
							if (lastId != "unset") $(obj).appendTo( $('#listing_panel') );
							
							// New tag
							obj = document.createElement('div');
							$(obj).addClass("learning_object")
								.html('<div class="title">'+result[i].title+'</div><div class="tags"><div>')
								.attr("id", result[i].id);
							
							// Set author data
							$(obj).data("author", result[i].mine);
							
							// Add the first tag
							$(obj).find('.tags').append('<div class="tag">'+result[i].value+'</div>');
							
							lastId = result[i].id;
						}
						else {
							
							// Add tag to current learning object
							$(obj).find('.tags').append('<div class="tag">'+result[i].value+'</div>');
						}

					}
					// Append the last learning object
					$(obj).appendTo( $('#listing_panel') );
					
				}
			);
			
		}
	
		// Document is ready
		$('document').ready(function(){
			
			pullList(-1);	// -1 is a hang-over from choosing all; no longer works this way (but could if needed)
			
			$('#add_new').click( function(){ window.location.href = "{{ @APPROOT }}/addnew/"; } );
			
			// View toggle buttons
			$('.button').click( function(){
				
				$('.button').removeClass('active');	// Toggle active highlight
				$(this).addClass('active');
				
				if ( $(this).attr("id") == "list_mine" ){	// Hide learning objects from other people
					//$('*[data-author="0"]').hide();

					$('.learning_object').each( function(index){
						if ( $(this).data("author") == "0" ) $(this).hide();
					} );

				} else {									// Show all learning object listings
					$('.learning_object').show();

				}
				
			});
			
		});
		
	</script>
</head>

<body>
	
	<div id="toggle_buttons">
		<div id="list_mine" class="button" >Mine</div>
		<div id="list_all" class="button active" >All</div>
	</div>

	<div id="add_new">Add New</div>
	
	<div id="listing_panel">
	</div>
	
</body>
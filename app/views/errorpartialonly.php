<!DOCTYPE html>
<head>
	<title>Digital Capabilities</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="{{ @APPROOT }}/css/default.css">
	<script src="{{ @APPROOT }}/js/jquery-3.1.0.min.js"></script>
	<script>

	
		// Document is ready
		$('document').ready(function(){
			
			
			
		});
		
	</script>
</head>

<body>
	
	<div id="error">
	
		<h1 class="error_title">No Full Matches</h1>
		<p>No content fully matched your criteria. Try clicking on a tag below to view partial matches.</p>
		
		<repeat group="{{ @partial }}" value="{{ @tag }}">
			<a href="{{ @APPROOT }}/search/{{ @tag.value }}"><div class="tag">{{ @tag.value }} ({{ @tag.count }})</div></a>
		</repeat>
	
	</div>

</body>
<!DOCTYPE html>
<head>
	<title>Digital Capabilities</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="<?php echo $APPROOT; ?>/css/default.css">
	<script src="<?php echo $APPROOT; ?>/js/jquery-3.1.0.min.js"></script>
	<script>
	
		var filterChoice = "";
	
		$('document').ready(function(){
			
			// Role choice
			$('.role').click(function(){
				
				filterChoice += $(this).attr('id') + ",";
				
				$('html, body').animate({
                    scrollLeft: $("#capabilities").offset().left
                }, 1000);
			});
			
			// Capability choice
			$('.cap').click(function(){
				filterChoice += $(this).attr('id');
				
				window.location.href = "<?php echo $APPROOT; ?>/search/"+filterChoice;
			});
			
		});
		
	</script>
</head>

<body>
	
	<div id="panel_container">
	
		<div id="roles" class="panel">
		
			<div id="main_title">The Digital Capabilities Framework</div>
		
			<div class="panel_info">
				
				<div class="steps">
					<span class="active_step">1.about you</span> &gt; <span class="inactive_step">2.your goals</span>
				</div>
				
				<div class="prompt">
					Welcome,<br>
					What is your role?
				</div>
			</div>
			
			<div class="option_grid">
				<div id="role_lecturer" class="option role">Lecturer<br><img src="./img/role_lecturer.png"></div>
				<div id="role_online" class="option role">Online Tutor<br><img src="./img/role_online.png"></div>
				<div id="role_researcher" class="option role">Researcher<br><img src="./img/role_researcher.png"></div>
				<div id="role_student" class="option role"><img src="./img/role_student.png"><br>Student</div>
				<div id="role_support" class="option role"><img src="./img/role_support.png"><br>Learning Support</div>
				<div id="role_manager" class="option role"><img src="./img/role_manager.png"><br>Manager</div>
			</div>
			
		</div>
		
		<div id="capabilities" class="panel">
		
			<div id="main_title">The Digital Capabilities Framework</div>
		
			<div class="panel_info">
				
				<div class="steps">
					<span class="inactive_step">1.about you</span> &gt; <span class="active_step">2.your goals</span>
				</div>
				
				<div class="prompt">
					Which digital<br>
					capability would<br>
					you like to<br>
					improve?
				</div>
			</div>
			
			<div class="option_grid">
				<div id="cap_critical" class="option cap">Critical Use<br><img src="./img/cap_critical.png"></div>
				<div id="cap_identity" class="option cap">Identity Management<br><img src="./img/cap_identity.png"></div>
				<div id="cap_creative" class="option cap">Creative Production<br><img src="./img/cap_creative.png"></div>
				<div id="cap_learning" class="option cap"><img src="./img/cap_learning.png"><br>Learning</div>
				<div id="cap_participation" class="option cap"><img src="./img/cap_participation.png"><br>Participation</div>
				<div id="cap_ict" class="option cap"><img src="./img/cap_ict.png"><br>ICT Proficiency</div>
			</div>
			
		</div>

</body>
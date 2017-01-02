<?php

class Author{
	
	// Main listing of learning objects
	function listing($f3){
		
		echo Template::instance()->render('app/views/listing.php');
	}
	
	
	// Load list for chosen author (or all)
	function loadList($f3){
		
		// Sanitise author id
		$author = $f3->get('PARAMS.author');
		$author = $f3->scrub($author);
		
		/*
		$list;
		if ($author == "-1"){
			
			$list = $f3->get('DB')->exec('
				SELECT `learningobject`.*, `tag`.`value` 
				FROM `learningobject` 
					JOIN `tag` ON `learningobject`.`id` = `tag`.`learnObjId` 
				ORDER BY 
					`learningobject`.`dateCreated` ASC'
			);
		}
		else {
			
			$list = $f3->get('DB')->exec('
				SELECT `learningobject`.*, `tag`.`value` 
				FROM `learningobject` 
					JOIN `tag` ON `learningobject`.`id` = `tag`.`learnObjId` 
				WHERE 
					`learningobject`.`author` = :author 
				ORDER BY 
					`learningobject`.`dateCreated` ASC',
				array( ':author'=>$author )
			);
			
		}
		*/
		
		$list = $f3->get('DB')->exec('
			SELECT `learningobject`.*, `tag`.`value`, IF(`learningobject`.`author`=:uid, 1, 0) AS "mine"
			FROM `learningobject` 
				LEFT JOIN `tag` ON `learningobject`.`id` = `tag`.`learnObjId` 
			ORDER BY 
				`learningobject`.`dateCreated` ASC',
			array(
				':uid'=>$f3->get('SESSION.uid')
			)
		);
		
		$json = json_encode($list);
		echo $json;
	}
	
	
	// Adding a new learning object
	function addNew($f3){
		
		echo Template::instance()->render('app/views/addnew.php');
	}
	
	
	// Form submission
	function buildNew($f3){
		
		// TODO: check logged in
		// TODO: check for required fields
		
		// Extract post data;
		$postData = $f3->get('POST');
		$postKeys = array_keys($postData);
		
		// Data we want
		$title = $postData["title"];
		$tags = explode(",",$postData["tags"]);
		
		// Loop over the whole thing to get the tab ids
		$tabids = [];
		for ($i=0; $i<count($postData); $i++){
			
			// Is it a tab? Note will be at position zero (which is similar to false)
			if ( strpos($postKeys[$i], "tab_title") === false ){
			}else{
				array_push( $tabids, substr($postKeys[$i],10) );
			}
		}
		
		// Insert the learning object into the database
		$f3->get('DB')->exec('
			INSERT INTO `learningobject`
				(`author`, `title`)
			VALUES
				(:uid, :title)',
			array(
				':uid'=>$f3->get('SESSION.uid'),
				':title'=>$title 
			)
		);
		
		// Get the last inserted ID
		$result = $f3->get('DB')->exec('SELECT LAST_INSERT_ID()');
		$loid = $result[0]['LAST_INSERT_ID()'];
		
		// Set a unique label for the learning object
		$this->generateLabel($f3, $loid);
		
		// Any tags?
		//  Could still be in a playlist without them
		if ( strlen($tags[$i])>0 ){
			
			// Loop to insert tags into the database
			for ($i=0; $i<count($tags); $i++){
				
				$f3->get('DB')->exec('
					INSERT INTO `tag`
						(`learnObjId`, `value`)
					VALUES
						(:loid, :value)',
					array(
						':loid'=>$loid,
						':value'=>$tags[$i].trim() 
					)
				);
			}
		}
		
		// Loop to insert the tabs into the database
		for ($i=0; $i<count($tabids); $i++){
			
			$tabindex = $tabids[$i];
			
			$f3->get('DB')->exec('
				INSERT INTO `tab`
					(`learnObjId`, `title`, `type`, `content`, `sidePanelText`, `sequence`)
				VALUES
					(:loid, :title, :type, :content, :sidepanel, :sequence)',
				array(
					':loid'=>$loid,
					':title'=>$postData['tab_title_'.$tabindex],
					':type'=>$postData['type_'.$tabindex],
					':content'=>$postData['tab_content_'.$tabindex],
					':sidepanel'=>$postData['tab_side_'.$tabindex],
					':sequence'=>$i
				)
			);
		}
		
		// Redirect back to listing
		$f3->reroute('/author');
		
	}
	
	
	// Unique label generation
	function generateLabel($f3, $loid){
		
		$unique = false;
		$label = null;
		do{
			
			$label = $this->alphaLabel(8);
			
			// See if this label has already been used
			$search = $f3->get('DB')->exec('
				SELECT `label`
				FROM `learningobject`
				WHERE `label`=:label',
				array(
					':label'=>$label
				)
			);
			
			if ( count($search)==0 ) $unique = true;
			
		} while (!unique);
		
		// Update the learning object with this label
		$f3->get('DB')->exec('
			UPDATE `learningobject`
			SET `label`=:label
			WHERE `id`=:id',
			array(
				':label'=>$label,
				':id'=>$loid
			)
		);
	}
	
	//
	function alphaLabel($l){
		
		$set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$label = "";
		
		for ($i=0; $i<$l; $i++){
			
			$p = rand(0, strlen($set));
			$label = $label.substr($set, $p, 1);
		}
		return $label;
	}
	
}

?>
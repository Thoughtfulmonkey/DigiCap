<?php

class ContentPool{
	
	function search($f3){
		
		// Sanitise parameters from the address bar
		$tagList = $f3->get('PARAMS.tags');
		$tagList = $f3->scrub($tagList);
		
		// Convert to array
		$tags = explode(",",$tagList);
		
		// Build the query string
		//  need a questionmark for each tag
		$queryString = "";
		for ($i=0; $i<count($tags); $i++){ 
			$queryString = $queryString."?";
			if ($i < count($tags)-1 ) $queryString = $queryString.",";
		}
		
		// Search for matches
		//  id: learning object id
		//  count: number of matching tags
		$matches = $f3->get('DB')->exec('
				SELECT 
					`learningobject`.`id`, 
					`tag`.`value`,
					COUNT(`learningobject`.`id`) AS "count"
				FROM `tag`
					JOIN `learningobject` ON `tag`.`learnObjId` = `learningobject`.`id`
				WHERE `value` IN
					('.$queryString.')
				GROUP BY `learningobject`.`id`',
				$tags
			);
		
		
		// Any matches for the provided tags?
		if ( count($matches)>0 ){
			
			// Find complete matches
			// TODO: maybe look at partial matches
			$complete  = [];
			$idList = "";
			for ($i=0; $i<count($matches); $i++){
				
				// All tags matched?
				if ( $matches[$i]["count"] == count($tags) ) {
					array_push( $complete, $matches[$i] );
					
					$idList = $idList.$matches[$i]["id"];
					if ($i < count($matches)-1 ) $idList = $idList.",";
				}
			}
		
			// Any complete matches?
			if ( $idList.length >0 ){
		
				// Pull data for matching learning objects
				//  store for rendering
				$f3->set('los', $f3->get('DB')->exec('
						SELECT 
							`learningobject`.`id`,
							`learningobject`.`title`
						FROM `learningobject`
						WHERE `learningobject`.`id` IN
							('.$idList.')',
						$tags
					)
				);
				
				echo Template::instance()->render('app/views/renderobjects.php');
			}
			else {
				// No complete matches - offer partial matches
				
				// Sum the tag matches
				$f3->set('partial', $f3->get('DB')->exec('
					SELECT 
						`tag`.`value`,
						COUNT(`tag`.`value`) AS "count"
					FROM `tag`
						JOIN `learningobject` ON `tag`.`learnObjId` = `learningobject`.`id`
					WHERE `value` IN
						('.$queryString.')
					GROUP BY `tag`.`value`',
					$tags
				));
				
				// Display
				echo Template::instance()->render('app/views/errorpartialonly.php');
			}
		}
		else {
			// No matching tags at all
			echo Template::instance()->render('app/views/errornomatches.php');
		}
		
	}
	
	// Loading a single learning object
	//  return as json
	function load($f3){
		
		// Sanitise parameters from the address bar
		$loid = $f3->get('PARAMS.id');
		$loid = $f3->scrub($loid);
		
		// Pull data for matching learning objects
		$tabs = $f3->get('DB')->exec('
			SELECT 
				`learningobject`.`title`,
				`tab`.* 
			FROM `learningobject`
				JOIN `tab` ON `learningobject`.`id` = `tab`.`learnObjId`
			WHERE `learningobject`.`id` = :loid
			ORDER BY `tab`.`sequence`',
			array( ':loid'=>$loid )
		);
		
		// Found a match?
		if ( count($tabs) == 0 ){
			echo '{ "error": "not found" }';
		}
		else {
			
			$json = json_encode($tabs);
			echo $json;
		}
	}
	
	/*	
		// Pull data for matching learning objects
		$los = $f3->get('DB')->exec('
				SELECT 
					`learningobject`.`title`,
					`tab`.* 
				FROM `learningobject`
					JOIN `tab` ON `learningobject`.`id` = `tab`.`learningObjId`
				WHERE `learningobject`.`id` IN
					('.$idList.')
				ORDER BY `tab`.`sequence`',
				$tags
			);

		var_dump($los);
*/
}

?>
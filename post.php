<?php
	
	# Configuration
	include('config.php');
	
	# Delete
	if(isset($_POST['id']) && !empty($_POST['id'])):
		
		# Escape ID
		$id = mysql_real_escape_string($_POST['id']);
		
		# Save
		$result = mysql_query("DELETE FROM `".DB_PREFIX."urls` WHERE `id` = '$id'");
		
		# Result
		if($result):
			
			# Success Message
			print 'Success';
		
		# End Result
		endif;
		
		# Exit
		exit;
	
	# Post
	elseif(isset($_GET['url']) && !empty($_GET['url'])):

		# Escape URL
		$url = mysql_real_escape_string($_GET['url']);
		
		# Title
		if(isset($_GET['title']) && !empty($_GET['title'])):
		
			# Escape Title
			$title = mysql_real_escape_string($_GET['title']);
		
		# No Title
		else:
			
			# Untitled
			$title = 'Untitled Site';
		
		# End Title
		endif;
	
		# Timestamp
		$timestamp = time();
		
		# URL Query
		if($result = mysql_query('SELECT `id` FROM `'.DB_PREFIX.'urls` WHERE `url` = "'.$url.'" LIMIT 1')):
	
			# Exists
			if($row = mysql_fetch_array($result, MYSQL_ASSOC)):
			
				# Message
				$_SESSION['msg'] = '<div class="message">You&rsqou;ve already saved that <a href="'.$url.'">URL</a>.</div>'."\n";
			
			# Create
			else:
			
				# Save
				$result = mysql_query("INSERT INTO `".DB_PREFIX."urls` VALUES('','$title','$url','$timestamp')");
				
				# Result
				if($result):
					
					# Success Message
					$_SESSION['msg'] = '<div class="message">URL Saved!</div>'."\n";
				
				# No Result
				else:
				
					# Fail Message
					$_SESSION['msg'] = '<div class="message error">Something went wrong!</div>'."\n";
				
				# End Messages
				endif;
			
			# End Exists/Create
			endif;
		
		# End URL Query
		endif;
	
	# End URL Required
	endif;
	
	# Redirect
	header('location: '.str_replace('/post.php', '',VL_URL));
		
	# Exit
	exit;

?>
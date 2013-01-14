<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="author" content="Kenton Glass" />
		<title>View Later</title>
		<style type="text/css">
			html,body,div,span,ul,li{font-size:100%;vertical-align:baseline;border:0;outline:0;background:transparent;margin:0;padding:0}ol,ul{list-style:none}body{background:#F2F2F2;font-family:Georgia,serif;font-size:14px;color:#333}a,a:visited{color:#666;text-decoration:none}a:active,a:hover{color:#000!important}#container{width:500px;margin:15px}#content{background:#FFF;border:5px solid #DDD;padding:15px}.title a,.title a:visited{font-size:16px;color:#EB6A00}.url{font-size:14px}.clear{clear:both}.left{float:left}.right{float:right;text-align:right}hr{width:250px;height:2px;background:#F2F2F2;color:#F2F2F2;border:none;margin:30px auto}.message{border-bottom:1px solid #E2C822;background:#FFF9D7;margin-bottom:5px;padding:10px 10px 8px}.error{border-bottom-color:#DD3C10;background:#FFEBE8}#footer{font-size:12px;margin:10px 2px 0 0}#install{background:#DDD;padding:4px}.metadata,.actions a,.actions a:visited{font-size:11px;color:#CCC}
		</style>
	</head>
	<body>
		<div id="container">
			<?php if(isset($_SESSION['msg'])){ print $_SESSION['msg']; $_SESSION['msg'] = NULL; } ?>
			<div id="content">
				<ul>
				<?php
	
					# Run Query
					$result = mysql_query('SELECT * FROM `'.DB_PREFIX.'urls` ORDER BY id DESC');
					
					# Start Count
					$counter = 0;
					$count   = mysql_num_rows($result);
					
					# Loop Array
					while($vl = mysql_fetch_array($result)):
					
						# Increase Count
						$counter++;
						
						# Convert Date
						$date  = date('m/d/Y',$vl['timestamp']);
						
						# Clean Up URL
						$url = str_replace('http://','',$vl['url']);
						$url = str_replace('https://','',$url);
						$url = str_replace('www.','',$url);
						$url_length = strlen($url);
						if($url_length > 50):
							$url = substr($url,0,50);
						endif;
						
						# Clean Up Title
						$title = stripslashes($vl['title']);
						$title_length = strlen($title);
						if($title_length > 50):
							$title = substr($title,0,50);
						endif;
					
							# One URL
							print '<li id="item-'.$vl['id'].'">'."\n"
								 .'	<div class="left">'."\n"
								 .'		<span class="title"><a title="'.$vl['title'].'" href="'.$vl['url'].'">'.$title.'</a></span><br />'."\n"
								 .'		<span class="url"><a title="'.$vl['url'].'" href="'.$vl['url'].'">'.$url.'</a></span>'."\n"
								 .'	</div>'."\n"
								 .'	<div class="right">'."\n"
								 .'		<span class="metadata">'.$date.'</span><br />'."\n"
								 .'		<span class="actions">'."\n"
								 .'			<a class="delete" id="'.$vl['id'].'" href="#">Delete</a>'."\n"
								 .'		</span>'."\n"
								 .'	</div>'."\n"
								 .'	<div class="clear"></div>'."\n";
							
							if($counter == $count):
								print '</li>'."\n";
							else:
								print '<hr />'."\n"
									 .'</li>'."\n";
							endif;
				
					# End Array
					endwhile;
			
				?>
				</ul>
			</div>
			<div id="footer">
				<span class="right">Grab the <a id="install" href="javascript:location.href='<?php print VL_URL; ?>/post.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href);" onclick="alert('Drag this bookmarklet onto your browser bar.');return false;">View Later</a> bookmarklet.</span>
				<span class="left">&copy; <a href="http://kenton.me" title="Kenton Glass">Kenton Glass</a></span>
			</div>
		</div>
		<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){setTimeout(function(){$('.message').fadeOut();},1000);$('.delete').click(function(e){e.preventDefault();var id=$(this).attr('id');$.post('post.php',{id:id},function(data){if(data!==''){$('li#item-'+id).prev('hr').fadeOut();$('li#item-'+id).fadeOut();$('#content').fadeIn().before('<div class="message">URL deleted!</div>');}else{$('#content').fadeIn().before('<div class="message error">Something went wrong!</div>');}
			setTimeout(function(){$('.message').fadeOut();},1000);});});});
		</script>
	</body>
</html>
<?php


require_once 'is_logged.php';
?>

<div id="header">
	<div class="header-wrap">
		<div class="logo">
			<a href="">LOGO</a>
		</div>
		<div class="nav">
			<a href="/projects/vtu3">Home</a>
			<a href="/projects/vtu3/articles">Articles</a>
			<?php
				if(is_log()==true){
					echo '<a href="/projects/vtu3/articles/create">Create an Article</a>';
					echo '<a href="/projects/vtu3/logout.php">Logout</a>';
				}else{
					echo '<a href="/projects/vtu3/login.php" class="bg-teal a-but">Login/Sign up</a>';
				}
			?>
		</div>
	</div>
</div>

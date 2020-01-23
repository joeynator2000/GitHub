<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Info X support desk</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../styles/styles.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src='https://kit.fontawesome.com/a076d05399.js'></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<?php
			include ('../scripts/Homescripts.php');
		?>
		<div id='bodybox'>
			<a href='?logout'>
				<div id='logout'>
					<img id='powerbutton' src='../styles/images/logout.png' alt='an image of the logout button'>
				</div>
			</a>
			<div class='container'>
				<div id='backarrow'>
					<?php
						if (!empty($_GET))
						{
            				$backarrow = "<button id='backarrowbutton'><i class='fas fa-arrow-left buttonimg' onclick='history.back(-1);'></i></button>";
							
							echo $backarrow;
							if (isset($Currentpage)) echo $Currentpage;
						}
					?>
				</div>
				<?php
					switch ($_SESSION['permission'])
					{
						case 1:
							echo $Level1display;
						break;
						
						case 2:
							echo $Level2display;
						break;
						
						case 3:
							echo $Level3display;
						break;
						
						case 4:
							echo $Level4display;
						break;
					}
				?>
			</div>
			<a href='Home.php'>
				<div id='logobox1'>
				</div>
			</a>
		</div>
	</body>
</html>
<?php
header("Refresh:5");
?>
<html>
	<head>
		<style>
			body {
				background-color: #003366;
				color: #66ffff;
			}
			p {
				font-size: 20px;
				font-family: monospace;
				background-color: #003366;
				color: #66ff66;
				//max-width: 90%;
				//height: 80%;
				word-break: break-word;
			}
			#nutzer {
				color: #ff0000;
			}
			img {
				max-height: 70%;
				max-width: 70%;
			}
			#e3 {
				width: 20%;
				font-size: 20px;
				background-color: #003366;
				color: #66ff66;
				box-shadow: 0 0 0px #66ff66;
				border-color:#66ff66;
				float:right;
				margin-right: 5%;
			}
			a:link {color: white;}
			a:visited {color: green;}
		</style>
	</head>
	<body>
		<form method=post>
		<?php
		date_default_timezone_set('Europe/Berlin');
		$datei = "chat".date("Y_m_d").".xls";
		if(file_exists($datei)){
			$inhalt = file($datei);
			$inhalt = array_reverse($inhalt);
			//echo "<textarea readonly=\"true\">";
			echo "<p>";
			foreach($inhalt as $f){
				echo $f."<br>";
			}
			echo "</p>";
		}
		?>
		</form>
	</body>
</html>

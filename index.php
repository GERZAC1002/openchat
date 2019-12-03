<?php
$cookie_name = "nutzername";
$maxzeichen = 1024;
if(isset($_COOKIE[$cookie_name])){
	if(isset($_POST["abmelden"])){
		header('Location: ./index.php');
		setcookie($cookie_name, "", time()-10);
		header("Refresh:0");
	}
	$r = strtoupper($_COOKIE[$cookie_name]);
	if(strlen($r) > 30){
			header('Location: ./index.php');
			setcookie($cookie_name,"",time()-10);
			header("Refresh:0");
	}else{
		$r = implode("&lt;",explode("<",$r));
		$r = implode("&gt;",explode(">",$r));
		echo "<! DOCTYPE html><html><head><title>OpenChat</title>
		<meta charset=\"utf-8\">
		<style>
			body {background-color: #003366;color: #66ffff;}
			textarea {font-size: 20px;font-family: monospace;background-color: #003366;color: #66ff66;width: 90%;height: 80%;}
			#e1 {width: 90%;font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;}
			#e2 {width: 45%;font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;float:left;margin-left: 5%;}
			#e5 {width: 45%;font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;float:right;margin-right: 5%;}
			#e3 {width: 45%;font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;float:right;margin-right: 5%;}
			#e4 {width: 45%;font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;float:left;margin-left: 5%;}
			iframe {word-wrap: break-word;text-align: center;font-size: 20px;font-family: monospace;background-color: #003366;color: #66ff66;width: 90%;height: 1000%;}
		</style>
		</head>
		<body>
		<center>
		<form method=post>
		<h1><u>Simples CHAT Programm</u></h1>
		<p><b> Ein Chatprogramm, bei dem jeder teilnehmen kann. Zeichenbegrenzung: $maxzeichen Zeichen</b>
		<br>Alle 5 Sekunde(n) wird automatisch aktualisiert<br>Links unbedingt mit http(s):// eingeben
		</p>
		<br><input autofocus id=\"e1\" name=\"nachricht\" type=text placeholder=\"Hier Text einfügen!\" maxlength=$maxzeichen ><br><br>
		<input id=\"e2\" name=\"elink\" type=text placeholder=\"Hier Link einfügen!\" maxlength=$maxzeichen >
		<input id=\"e5\" name=\"bild\" type=text placeholder=\"Hier Bildlink einfügen!\" maxlength=$maxzeichen ><br>
		</center><br>
		<input type=\"submit\" id=\"e4\" name=\"absenden\" value=\"Absenden\"><input id=\"e3\" type=\"submit\" name=\"abmelden\" value=\"Abmelden\"><br><center>";
		date_default_timezone_set('Europe/Berlin');
		$datei;
		$text;
		$inhalt;
		if(isset($_POST["elink"])){
			if(!empty($_POST["elink"])){
				$datei = fopen("chat".date("Y_m_d").".xls","a+") or die("Datei kann nicht geöffnet werden!");
				$vor = "<font color=#ff0066>".date("Y/m/d H:i:s")."</font>"." <font color=#ffff00>$r</font>&gt; Link: ";
				$text = "<a target=\"_blank\" href=\"".implode("&lt;",explode("<",implode("&gt;",explode(">",$_POST["elink"]))))."\">".$_POST["elink"]."</a>";
				$text = $vor.$text."\n";
				fwrite($datei, $text);
				fclose($datei);
			}
		}if(isset($_POST["bild"])){
			if(!empty($_POST["bild"])){
				$datei = fopen("chat".date("Y_m_d").".xls","a+") or die("Datei kann nicht geöffnet werden!");
				$bildlink = $_POST["bild"];
				$extern = fopen($bildlink,"rb");
				$inhalt = stream_get_contents($extern);
				$datnam = strrev(strtok(strrev($_POST["bild"]),"/"));
				$endung = strrev(strtok(strrev($datnam),"."));
				$datnam = rand(100000,999999).".$endung";
				while(file_exists("img/".$datnam)){
						$datnam = rand(100000,999999).".$endung";
				}
				$intern = fopen("img/".$datnam,"wb");
				fwrite($intern,$inhalt);
				fclose($extern);
				fclose($intern);
				$vor = "<font color=#ff0066>".date("Y/m/d H:i:s")."</font>"." <font color=#ffff00>$r</font>&gt; Bild: ";
				$text = "<a target=\"_blank\" href=\"img/".$datnam."\">$datnam</a>";
				$text = $vor.$text."\n";
				fwrite($datei, $text);
				fclose($datei);
			}
		}
		if(isset($_POST["nachricht"])){
			if(!empty($_POST["nachricht"] )){
				$datei = fopen("chat".date("Y_m_d").".xls","a+") or die("Datei kann nicht geöffnet werden!");
				$vor = "<font color=#ff0066>".date("Y/m/d H:i:s")."</font>"." <font color=#ffff00>$r</font>&gt; ";
				$text = $_POST["nachricht"]."\n";
				$text = implode("&lt;",explode("<",$text));
				$text = implode("&gt;",explode(">",$text));
				$text = $vor.$text;
				fwrite($datei, $text);
				fclose($datei);
			}
		}
	}
	echo "
				<iframe scrolling=\"no\" src=\"text.php\" frameborder=\"0\" border=\"0\" ></iframe>
			</form>
		</center>
	</body>
</html>";
}else{
	if(isset($_POST["name"]) && isset($_POST["passwort"])){
		$name = strtoupper($_POST["name"]);
		if(strlen($name) > 10){
			header('Location: ./index.php');
			setcookie($cookie_name,"",time()-10);
			header("Refresh:0");
		}
		$name = implode("&lt;",explode("<",$name));
		$name = implode("&gt;",explode(">",$name));
		$passwort = md5(md5($_POST["passwort"]).sha1($_POST["passwort"]));
		$paar = $name . ";" . $passwort . "\n";
		$datei = fopen("users.docx","a+") or die("Datei kann nicht geöffnet werden!");
		$i = 0;
		while(!feof($datei)){
			$zeile = fgets($datei);
			if($paar==$zeile){
				$i = $i +1;
				//setcookie($cookie_name, $name);
				echo "<html><head></head><body><form method=post><input type=\"hidden\" value=\"".$name."\" ></form></body></html>";
				header('Location: ./index.php');
				header("Refresh:0");
			}
		}
		fclose($datei);
		if($i >= 1){
			header('Location: ./index.php');
			setcookie($cookie_name,$name);
		}else{
			$i=0;
			$datei = fopen("users.docx","a+") or die("Datei kann nicht geöffnet werden!");
			while(!feof($datei)){
				$zeile = fgets($datei);
				if(strtok($zeile,";")==$name){
					$i = $i +1;
				}
			}
			fclose($datei);
			if($i==0){
				$datei = fopen("users.docx","a+") or die("Datei kann nicht geöffnet werden!");
				fwrite($datei,$paar);
				header('Location: ./index.php');
				setcookie($cookie_name,$name);
				header("Refresh:0");
			}else{
				header('Location: ./index.php');
				setcookie($cookie_name, "", time()-10);
			}
		}
		header("Refresh:0");
	}else{
		echo "<! DOCTYPE html><html>
		<head>
			<title>Anmeldung</title>
			<meta charset=\"utf-8\">
			<style>
			body {background-color: #003366;color: #66ffff;font-family: monospace;font-size: 20px;}
			a:link {color: white;}
			a:visited {color: green;}
			#e2 {font-size: 20px;background-color: #003366;color: #66ff66;box-shadow: 0 0 0px #66ff66;border-color:#66ff66;}
			</style>
		</head>
		<body>
			<form method=post>
				<center>
					<p>
						Um einen Neuen Nutzer zu erstellen bitte Nutzername und Passwort eingeben.<br>
						Wenn es geklappt hat wird man zum Chat weitergeleitet!<br>
						Nutzernamen werden intern großgeschrieben!<br>
						Bei Passwörten ist Groß-/Kleinschreibung entscheidend!<br>
						Auf persönliche Anfrage werden Passwörter ersetzt<br>
						<br><br>
						<u><b>Gründe für nicht erfolgter Weiterleitung:</b></u><br>
						- Passwort war falsch -<br>
						- Benutzername existiert bereits -<br>
						- Cookies deaktiviert -<br><br>
					<p>Nutzername:
					<input autofocus id=\"e2\" name=\"name\" type=text maxlength=10><br></p>
					<p>&nbsp;&nbsp;Passwort:
					<input id=\"e2\" name=\"passwort\" type=password maxlength=10><br></p>
					<input id=\"e2\" type=submit value=\"Anmelden\"><br>
					<p><a href=\"text.php\">Ohne Anmeldung mitlesen</a></p>
					<p></p>
				</center>
			</form>
		</body>
	</html>";
	}
}
?>

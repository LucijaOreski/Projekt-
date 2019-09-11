<?php
	include("baza.php");
	if(session_id()=="")
	session_start();

?>
<DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="utf-8"/>
		<title>KLADIONICA</title>
		<link href="lucija.css" rel="stylesheet" type="text/css">
	</head>
	<header>
			<a href="o_autoru.html" style="margin-left: 15px; color: #2B3856;">Autor</a>
			<h1>KLADIONICA</h1>
			<?php
				if(isset($_SESSION['id'])){
					echo '<a href="popis_listica.php" style="color: #2B3856; float: right; margin-right: 15px;">Moji listići</a>';
					if($_SESSION['tip_korisnika_id'] == 1 || $_SESSION['tip_korisnika_id'] == 0){
						echo '<a href="moje_utakmice.php" style="color: #2B3856; float: right; margin-right: 15px;">Moje utakmice</a>';
					}
				}else{
					
				}
			?>
			<?php 
				if(isset($_SESSION['id'])){
					echo '<a href="odjava.php" style="color: #2B3856; float: right; margin-right: 15px;">Odjava</a>';
				}else{
					echo '<a href="prijava.php" style="color: #2B3856; float: right; margin-right: 15px;">Prijava</a>';
				}			
			?>				
	</header>
	<body>
		<nav id="navigacija">
			<ul>
				<li>
				<a href="index.php">Početna stranica</a>
				</li>
				<li>
				<a href="popis_liga.php">Popis liga</a>
				</li>
				<?php
					if(isset($_SESSION['id'])){
						if($_SESSION['tip_korisnika_id'] == 0){
						echo '<li>
							<a href="popis_korisnika.php">Popis korisnika</a>
							</li>							
							<li>
							<a href="popis_momcadi.php">Popis momčadi</a>
							</li>';
						}
						echo '<li>
							<a href="listic.php">Listić</a>
							</li>';
					}
				?>
			</ul>
		</nav>
		<section id="sekcija">
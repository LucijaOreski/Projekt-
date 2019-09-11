<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	if(isset($_SESSION['id']))
		$id=$_SESSION['id'];
	
	if(isset($_SESSION['id']) && $_SESSION['tip_korisnika_id']==0){
		?>
		<button onclick="window.location.href='nova_liga.php'">Nova liga</button>
		<?php
	}
?>


<table style="margin-bottom: 15px;">
	<thead>
		<tr>
			<th>Naziv lige</th>
			<th>Slika</th>
			<th>Video</th>
			<th>Opis</th>
			<th>Izmjena</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$upit='SELECT * FROM liga';
			$rezultat=izvrsiUpit($bp, $upit);
			while(list($liga_id, $moderator_id, $naziv, $slika, $video, $opis)=mysqli_fetch_array($rezultat)){
				echo '<tr>';
				echo '<td><a href="popis_utakmica.php?id='.$liga_id.'">'.$naziv.'</a></td>';
				echo '<td><img width="40px" height="40px" src="'.$slika.'"/></td>';
				echo '<td><a href="'.$video.'" target="_blank">'.$video.'</a></td>';
				echo '<td>'.$opis.'</td>';
				if(isset($_SESSION['id']) && $_SESSION['tip_korisnika_id']==0){
					echo '<td><a href="izmjena_liga.php?id='.$liga_id.'">Izmjena</a></td>';					
				}else{
					echo '<td></td>';
				}
				echo '</tr>';
			}
		?>
	</tbody>
</table>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
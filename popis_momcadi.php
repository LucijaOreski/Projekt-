<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	if(isset($_SESSION['id']))
		$id=$_SESSION['id'];
?>

 <button onclick="window.location.href='nova_momcad.php'">Nova momčad</button>
 
<table style="margin-bottom: 15px;">
	<thead>
		<tr>
			<th>Naziv momcadi</th>
			<th>Opis</th>
			<th>Izmjena</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$upit='SELECT momcad_id, naziv, opis FROM momcad';
			$rezultat=izvrsiUpit($bp, $upit);
			while(list($momcad_id, $naziv, $opis)=mysqli_fetch_array($rezultat)){
				echo '<tr>';
					echo '<td>'.$naziv.'</td>';
					echo '<td>'.$opis.'</td>';
					echo '<td><a href="izmjena_momcadi.php?id='.$momcad_id.'">Izmjena</a></td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
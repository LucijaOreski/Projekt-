<?php
	
	session_start();
	include ('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	$id=$_SESSION['id'];
?>

<table>
	<thead>
		<tr>
			<th>Broj listića</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$upit='SELECT listic_id, status FROM listic WHERE korisnik_id='.$id;
			$rezultat=izvrsiUpit($bp, $upit);
			while(list($listic_id, $status,)=mysqli_fetch_array($rezultat)){
				echo '<tr>';
				echo '<td>'.$listic_id.'</td>';
				echo '<td>'.$status.'</td>';
				echo '</tr>';
			}
			
		?>
	</tbody>
</table>


<?php
	
	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
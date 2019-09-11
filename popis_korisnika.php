<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
?>

<button onclick="window.location.href='novi_korisnik.php'">Novi korisnik</button>

<table style="margin-bottom: 15px;">
	<thead>
		<tr>
			<th>Tip korisnika</th>
			<th>Korisničko ime</th>
			<th>Lozinka</th>
			<th>Ime</th>
			<th>Prezime</th>
			<th>Email</th>
			<th>Slika</th>
			<th>Izmjena</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$upit='SELECT korisnik_id, tip_korisnika.naziv, korisnicko_ime, lozinka, ime, prezime, email, slika 
			FROM korisnik, tip_korisnika
			WHERE korisnik.tip_korisnika_id=tip_korisnika.tip_korisnika_id';
			$rezultat=izvrsiUpit($bp, $upit);
			while(list($korisnik_id, $naziv, $korisnicko_ime, $lozinka, $ime, $prezime, $email, $slika)=mysqli_fetch_array($rezultat)){
				echo '<tr>';
				echo '<td>'.$naziv.'</a></td>';
				echo '<td>'.$korisnicko_ime.'</td>';
				echo '<td>'.$lozinka.'</td>';
				echo '<td>'.$ime.'</td>';
				echo '<td>'.$prezime.'</td>';
				echo '<td>'.$email.'</td>';
				echo '<td><img width="40px" height="40px" src="'.$slika.'"/></td>';
				echo '<td><a href="izmjena_korisnika.php?id='.$korisnik_id.'">Izmjena</a></td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table>




<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
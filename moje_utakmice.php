<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	
?>

<button onclick="window.location.href='nova_utakmica.php'">Nova utakmica</button>
<button onclick="window.location.href='statistika.php'">Statistika dobitnih / nedobitnih listića</button>

<table style="margin-bottom: 15px;">
	<thead>
		<tr>
			<th>Naziv</th>
			<th>Vrijeme početka</th>
			<th>Vrijeme završetka</th>
			<th>Naziv 1. momčadi</th>
			<th>Naziv 2. momčadi</th>
			<th>Rezultat</th>
			<th>Izmjena rezultata</th>
			<th>Izmjena utakmice</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(isset($_SESSION['id']))
				$id=$_SESSION['id'];
			if(isset($_SESSION['tip_korisnika_id']))
				$tip_korisnika=$_SESSION['tip_korisnika_id'];
			$upit='SELECT liga_id FROM liga WHERE moderator_id='.$id;
			$rezultat=izvrsiUpit($bp, $upit);
			while(list($liga_id)=mysqli_fetch_array($rezultat)){
				if($tip_korisnika==1){
				$upit='SELECT utakmica.opis, datum_vrijeme_pocetka, datum_vrijeme_zavrsetka, m1.naziv, m2.naziv, utakmica.rezultat_1, 
				utakmica.rezultat_2, utakmica_id 
				FROM momcad m1, momcad m2, utakmica 
				WHERE m1.momcad_id = utakmica.momcad_1 
				and m2.momcad_id = utakmica.momcad_2
				AND m1.liga_id = '.$liga_id;
				}
				$rezultat2=izvrsiUpit($bp, $upit);
				while(list($naziv, $vrijeme_pocetka, $vrijeme_zavrsetka, $naziv_1_momcadi, $naziv_2_momcadi, 
				$rezultat_1_momcadi, $rezultat_2_momcadi, $utakmica_id)=mysqli_fetch_array($rezultat2)){
					echo '<tr>
							<td>'.$naziv.'</td>
							<td>'.date('d.m.Y H:i:s',strtotime($vrijeme_pocetka)).'</td>
							<td>'.date('d.m.Y H:i:s',strtotime($vrijeme_zavrsetka)).'</td>
							<td>'.$naziv_1_momcadi.'</td>
							<td>'.$naziv_2_momcadi.'</td>
							<td>'.$rezultat_1_momcadi.':'.$rezultat_2_momcadi.'</td>
							<td><a href="izmjena_rezultata_utakmice.php?id='.$utakmica_id.'">Izmjena</a></td>
							<td><a href="izmjena_utakmice.php?id='.$utakmica_id.'">Izmjena</a></td>
						</tr>';	
				}
			}
			
			
			
		?>
	</tbody>
</table>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
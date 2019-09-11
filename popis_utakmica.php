<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	
?>

<table>
	<thead>
		<tr>
			<th>Naziv</th>
			<th>Vrijeme početka</th>
			<th>Vrijeme završetka</th>
			<th>Naziv 1. momčadi</th>
			<th>Naziv 1. momčadi</th>
			<th>Rezultat</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(isset($_GET['id']))
				$id=$_GET['id'];
			if(isset($_SESSION['tip_korisnika_id']))
				$tip_korisnika=$_SESSION['tip_korisnika_id'];
			
			if(empty($tip_korisnika)){
				$upit='SELECT utakmica.opis, datum_vrijeme_pocetka, datum_vrijeme_zavrsetka, m1.naziv, m2.naziv, utakmica.rezultat_1, utakmica.rezultat_2 
				FROM momcad m1, momcad m2, utakmica 
				WHERE m1.momcad_id = utakmica.momcad_1 
				and m2.momcad_id = utakmica.momcad_2
				AND m1.liga_id = '.$id.' 
				AND datum_vrijeme_zavrsetka < NOW()';
			}
			else{
				if($tip_korisnika==2 OR $tip_korisnika==1){
					$upit='SELECT utakmica.opis, datum_vrijeme_pocetka, datum_vrijeme_zavrsetka, m1.naziv, m2.naziv, utakmica.rezultat_1, utakmica.rezultat_2 
					FROM momcad m1, momcad m2, utakmica 
					WHERE m1.momcad_id = utakmica.momcad_1 
					and m2.momcad_id = utakmica.momcad_2
					AND m1.liga_id = '.$id;
				}
			}
			$rezultat=izvrsiUpit($bp, $upit);
				while(list($naziv, $vrijeme_pocetka, $vrijeme_zavrsetka, $naziv_1_momcadi, $naziv_2_momcadi, 
				$rezultat_1_momcadi, $rezultat_2_momcadi)=mysqli_fetch_array($rezultat)){
					echo '<tr>
							<td>'.$naziv.'</td>
							<td>'.date('d.m.Y H:i:s',strtotime($vrijeme_pocetka)).'</td>
							<td>'.date('d.m.Y H:i:s',strtotime($vrijeme_zavrsetka)).'</td>
							<td>'.$naziv_1_momcadi.'</td>
							<td>'.$naziv_2_momcadi.'</td>
							<td>'.$rezultat_1_momcadi.':'.$rezultat_2_momcadi.'</td>
						<tr>';	
				}
		
		?>
	<tbody>
</table>


<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
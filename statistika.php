<?php
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();

?>

<?php
	if(isset($_POST['submit'])){	
		$filtriranje=$_POST['filtriranje'];
		$datum_pocetka=strtotime($_POST['datum_od']);
		$datum_zavrsetka=strtotime($_POST['datum_do']);
		$sortiraj=$_POST['sortiraj'];
		$strani_datum_pocetka=date('Y-m-d H:i:s', $datum_pocetka);
		$strani_datum_zavrsetka=date('Y-m-d H:i:s', $datum_zavrsetka);
		if($filtriranje=="l"){
			$upit='SELECT m.liga_id, lg.naziv, SUM(CASE WHEN l.status = "D" THEN 1 ELSE 0 END) AS dobitni, 
				SUM(CASE WHEN l.status="N" THEN 1 ELSE 0 END) AS nedobitni
				FROM listic l, utakmica u, momcad m, liga lg
				WHERE l.utakmica_id=u.utakmica_id AND m.momcad_id=u.momcad_1 AND lg.liga_id=m.liga_id
				AND u.datum_vrijeme_zavrsetka BETWEEN "'.$strani_datum_pocetka.'" AND "'.$strani_datum_zavrsetka.'"
				GROUP BY m.liga_id
				ORDER BY dobitni '.$sortiraj;
			$rezultat=izvrsiUpit($bp, $upit);
			echo '<table>
					<thead>
						<tr>
							<th>ID lige</th>
							<th>Naziv lige</th>
							<th>Dobitni</th>
							<th>Nedobitni</th>
						</tr>
					</thead>
				<tbody>';			
			while(list($liga_id, $naziv, $dobitni, $nedobitni)=mysqli_fetch_array($rezultat)){
				echo '<tr>
						<td>'.$liga_id.'</td>
						<td>'.$naziv.'</td>
						<td>'.$dobitni.'</td>
						<td>'.$nedobitni.'</td>
					<tr>';	
			}
				echo '</tbody>
			</table>';			
		}	
		else{
			$upit='SELECT l.korisnik_id, korisnicko_ime, SUM(CASE WHEN l.status = "D" THEN 1 ELSE 0 END) AS dobitni, 
				SUM(CASE WHEN l.status="N" THEN 1 ELSE 0 END) AS nedobitni
				FROM listic l, utakmica u, korisnik k
				WHERE l.utakmica_id=u.utakmica_id AND u.datum_vrijeme_zavrsetka 
				BETWEEN "'.$strani_datum_pocetka.'" AND "'.$strani_datum_zavrsetka.'"
				AND k.korisnik_id=l.korisnik_id
				GROUP BY l.korisnik_id
				ORDER BY dobitni '.$sortiraj;
		$rezultat=izvrsiUpit($bp, $upit);
		echo '<table>
					<thead>
						<tr>
							<th>ID korisnika</th>
							<th>Korisničko ime</th>
							<th>Dobitni</th>
							<th>Nedobitni</th>
						</tr>
					</thead>
				<tbody>';
		while(list($korisnik_id, $korisnicko_ime, $dobitni, $nedobitni)=mysqli_fetch_array($rezultat)){
				echo '<tr>
						<td>'.$korisnik_id.'</td>
						<td>'.$korisnicko_ime.'</td>
						<td>'.$dobitni.'</td>
						<td>'.$nedobitni.'</td>
					<tr>';	
			}
				echo '</tbody>
			</table>';						
		}
	}	
?>

<form method="POST" action="">
	<table>
		<tbody>
			<tr>
				<td>
					<label><strong>Filtriranje:</strong></label>
				</td>
				<td>
				<select name="filtriranje">
					<option value="l">Po ligi</option>
					<option value="k">Po korisniku</option>
				</select>
				</td>		
			</tr>
			<tr>
				<td>
					<label><strong>Datum od:</strong></label>
				</td>
				<td>
					<input name="datum_od" required/>
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Datum do:</strong></label>
				</td>
				<td>
					<input	name="datum_do" required/>
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Sortiraj:</strong></label>
				</td>
				<td>
				<select name="sortiraj">
					<option value="asc">Dobitni - rastuće</option>
					<option value="desc">Dobitni - padajuće</option>		
				</select>
				</td>		
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="submit" value="Pretraži"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
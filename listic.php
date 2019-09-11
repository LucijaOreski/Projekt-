<?php
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	$utakmica='';
	$ocekivani_rezultat='';
	$korisnik_id='';
	
	if(isset($_POST['submit'])){
		$utakmica=$_POST['utakmica'];
		$ocekivani_rezultat=$_POST['rezultat'];
		$korisnik_id=$_SESSION['id'];
		
		$upit='INSERT INTO listic (utakmica_id, korisnik_id, ocekivani_rezultat, status) VALUES ('.$utakmica.', 
		'.$korisnik_id.', '.$ocekivani_rezultat.', "P")';
		izvrsiUpit($bp, $upit);
		header('Location: popis_listica.php');
	}
	
?>

<form name="listic" method="POST" action="listic.php">
<table>
	<tbody>
		<tr>
			<td>
				<label><strong>Utakmica:</strong></label>
			</td>
			<td>
			<?php
				
				echo '<select name="utakmica">'; 
				$upit='SELECT utakmica_id, m1.naziv, m2.naziv 
						FROM momcad m1, momcad m2, utakmica 
						WHERE m1.momcad_id = utakmica.momcad_1 
						and m2.momcad_id = utakmica.momcad_2
						AND datum_vrijeme_pocetka > NOW()';
				$rezultat=izvrsiUpit($bp, $upit);
				WHILE(list($utakmica_id, $momcad_1, $momcad_2)=mysqli_fetch_array($rezultat)){
					echo '<option value="'.$utakmica_id.'">'.$momcad_1.'-'.$momcad_2.'</option>';
				}
				echo '</select>';
			?>
		</td>
	</tr>
	<tr>
		<td>
			<label><strong>Očekivani rezultat:</strong></label>
		</td>
		<td>
			<select name="rezultat"> 
				<option value="0">Neriješeno</option>
				<option value="1">Pobjeda momčad 1</option>
				<option value="2">Pobjeda momčad 2</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
			<input name="submit" type="submit" value="Uplati listić"/>
		</td>
	</tr>
</form>



<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
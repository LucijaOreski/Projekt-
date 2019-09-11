<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	$utakmica_id=$_GET['id'];
	$opis_utakmice='';
	$datum_vrijeme_pocetka_utakmice='';
	$datum_vrijeme_zavrsetka_utakmice='';
	$rezultat_1_utakmice='';
	$rezultat_2_utakmice='';
	$momcad_1_utakmice='';
	$momcad_2_utakmice='';
	if(isset($_SESSION['tip_korisnika_id'])){
		$tip_korisnika=$_SESSION['tip_korisnika_id'];
		if($tip_korisnika==1){
			$upit='SELECT opis, datum_vrijeme_pocetka, datum_vrijeme_zavrsetka, rezultat_1, rezultat_2, momcad_1, momcad_2
			FROM utakmica 
			WHERE utakmica_id = '.$utakmica_id;
			}
			$rezultat=izvrsiUpit($bp, $upit);
			while(list( $opis, $datum_vrijeme_pocetka, $datum_vrijeme_zavrsetka, $rezultat_1, $rezultat_2, $momcad_1, $momcad_2)=mysqli_fetch_array($rezultat)){
				$opis_utakmice=$opis;
				$datum_vrijeme_pocetka_utakmice=$datum_vrijeme_pocetka;
				$datum_vrijeme_zavrsetka_utakmice=$datum_vrijeme_zavrsetka;
				$rezultat_1_utakmice=$rezultat_1;
				$rezultat_2_utakmice=$rezultat_2;
				$momcad_1_utakmice=$momcad_1;
				$momcad_2_utakmice=$momcad_2;
		}
	}
	
	if(isset($_POST['submit'])){
		$utakmica_id=$_POST['utakmica_id'];
		$momcad_1=$_POST['momcad_1'];
		$momcad_2=$_POST['momcad_2'];
		$datum_vrijeme_pocetka=$_POST['datum_vrijeme_pocetka'];
		$rezultat_1=$_POST['rezultat_1'];
		$rezultat_2=$_POST['rezultat_2'];
		$opis=$_POST['opis'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==1){
			$upit='UPDATE utakmica SET momcad_1='.$momcad_1.', momcad_2='.$momcad_2.', datum_vrijeme_pocetka="'.$datum_vrijeme_pocetka.'", 
			datum_vrijeme_zavrsetka="'.$datum_vrijeme_pocetka.'" + INTERVAL 90 MINUTE, rezultat_1='.$rezultat_1.', rezultat_2='.$rezultat_2.', 
			opis="'.$opis.'"
			WHERE utakmica_id='.$utakmica_id;
			izvrsiUpit($bp, $upit); 
			header('Location: moje_utakmice.php');
			}
		}	
	}	
?>


<form method="POST" action="">
	<table>
		<tbody>
			<tr>
				<td>
					<label><strong>Naziv 1.momčadi:</strong></label>
				</td>
				<td>
					<?php
						echo '<select name="momcad_1" required>'; 
						$upit='SELECT momcad_id, naziv
						FROM momcad';
						$rezultat=izvrsiUpit($bp, $upit);
						WHILE(list($momcad_id, $naziv)=mysqli_fetch_array($rezultat)){
							echo '<option value="'.$momcad_id.'"';
							if($momcad_id==$momcad_1_utakmice)
							echo 'selected="selected"';
							echo '>'.$naziv.'</option>';
					}
						echo '</select>';
					?>	
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Naziv 2.momčadi:</strong></label>
				</td>
				<td>
					<?php
						echo '<select name="momcad_2" required>'; 
						$upit='SELECT momcad_id, naziv
						FROM momcad';
						$rezultat=izvrsiUpit($bp, $upit);
						WHILE(list($momcad_id, $naziv)=mysqli_fetch_array($rezultat)){
							echo '<option value="'.$momcad_id.'"';
							if($momcad_id==$momcad_2_utakmice)
							echo 'selected="selected"';
							echo '>'.$naziv.'</option>';
					}
						echo '</select>';
					?>	
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Datum i vrijeme početka:</strong></label>
				</td>
				<td>
					<input	name="datum_vrijeme_pocetka" required value="<?php echo $datum_vrijeme_pocetka_utakmice; ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Datum i vrijeme završetka:</strong></label>
				</td>
				<td>
					<input	name="datum_vrijeme_zavrsetka" disabled value="<?php echo $datum_vrijeme_zavrsetka_utakmice; ?>"/>
				</td>
			</tr>
			<tr>	
				<td>
					<label><strong>Rezultat 1:</strong></label>
				</td>
				<td>
					<input type="text" name="rezultat_1" id="rezultat_1"
						size="120" value="<?php echo $rezultat_1_utakmice; ?>"
						required/>
				</td>
			</tr>
			<tr>	
				<td>
					<label><strong>Rezultat 2:</strong></label>
				</td>
				<td>
					<input type="text" name="rezultat_2" id="rezultat_2"
						size="120" value="<?php echo $rezultat_2_utakmice; ?>"
						required/>
				</td>
			</tr>
			<tr>	
				<td>
					<label><strong>Opis: </strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis"
						size="120" 
						required value="<?php echo $opis_utakmice; ?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="submit" value="Pošalji"/>
					<input type="hidden" name="utakmica_id" value="<?php echo $utakmica_id; ?>"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
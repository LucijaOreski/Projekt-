<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	$momcad_id=$_GET['id'];
	$naziv_momcadi='';
	$opis_momcadi='';
	if(isset($_SESSION['tip_korisnika_id'])){
		$tip_korisnika=$_SESSION['tip_korisnika_id'];
		if($tip_korisnika==0){
			$upit='SELECT naziv, opis FROM momcad 
			WHERE momcad_id = '.$momcad_id;
			$rezultat=izvrsiUpit($bp, $upit);
			while(list( $naziv, $opis)=mysqli_fetch_array($rezultat)){
				$naziv_momcadi=$naziv;
				$opis_momcadi=$opis;
			}
		}	
	}
	
	if(isset($_POST['submit'])){
		$naziv=$_POST['naziv'];
		$opis=$_POST['opis'];
		$momcad_id=$_POST['momcad_id'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
				$upit='UPDATE momcad SET naziv="'.$naziv.'", opis="'.$opis.'"
				WHERE momcad_id = '.$momcad_id;
				izvrsiUpit($bp, $upit); 
				header('Location: popis_momcadi.php');
			}
		}	
	}	
?>


<form method="POST" action="">
	<table>
		<tbody>
			<tr>
				<td>
					<label for="naziv"><strong>Naziv momčadi:</strong></label>
				</td>
				<td>
					<input type="text" name="naziv" id="naziv"
						size="120" minlength="3" maxlength="50"
						placeholder="Ime momcadi ne smije sadržavati praznine, treba uključiti minimalno 3 znaka i započeti velikim početnim slovom"
						required value="<?php echo $naziv_momcadi; ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="opis"><strong>Opis momčadi:</strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis"
						size="120" minlength="10" maxlength="50"
						placeholder="Opis momcadi ne smije sadržavati praznine, treba uključiti minimalno 6 znakova i započeti velikim početnim slovom"
						required value="<?php echo $opis_momcadi; ?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="submit" value="Pošalji"/>
					<input type="hidden" name="momcad_id" value="<?php echo $momcad_id; ?>"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
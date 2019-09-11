<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	if(isset($_POST['submit'])){
		$liga_id=$_POST['liga_id'];
		$naziv=$_POST['naziv'];
		$opis=$_POST['opis'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
			$upit='INSERT INTO momcad ( liga_id, naziv, opis) VALUES 
			("'.$liga_id.'", "'.$naziv.'", "'.$opis.'")';
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
					<label for="liga_id"><strong>Liga:</strong></label>
				</td>
				<td>
					<?php
						echo '<select name="liga_id" required>'; 
						$upit='SELECT liga_id, naziv
						FROM liga';
						$rezultat=izvrsiUpit($bp, $upit);
						WHILE(list($liga_id, $naziv)=mysqli_fetch_array($rezultat)){
							echo '<option value="'.$liga_id.'">'.$naziv.'</option>';
					}
						echo '</select>';
					?>	
				</td>
			</tr>
			<tr>
				<td>
					<label for="naziv"><strong>Naziv momčadi:</strong></label>
				</td>
				<td>
					<input type="text" name="naziv" id="naziv"
						size="120" minlength="3" maxlength="50"
						placeholder="Ime momčadi ne smije sadržavati praznine, treba uključiti minimalno 3 znaka i započeti velikim početnim slovom"
						required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="opis"><strong>Opis momčadi:</strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis"
						size="120" minlength="10" maxlength="50"
						placeholder="Opis momčadi ne smije sadržavati praznine, treba uključiti minimalno 6 znakova i započeti velikim početnim slovom"
						required/>
				</td>
			</tr>	
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" name="submit" value="Pošalji"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
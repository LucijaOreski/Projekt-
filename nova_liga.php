<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	if(isset($_POST['submit'])){
		$naziv=$_POST['naziv'];
		$slika=$_POST['slika'];
		$video=$_POST['video'];
		$opis=$_POST['opis'];
		$korisnik_id=$_POST['korisnik_id'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
			$upit='INSERT INTO liga (naziv, slika, video, opis, moderator_id) VALUES 
			("'.$naziv.'", "'.$slika.'", "'.$video.'", "'.$opis.'", "'.$korisnik_id.'")';
			izvrsiUpit($bp, $upit); 
			header('Location: popis_liga.php');
			}
		}	
	}	
?>


<form method="POST" action="">
	<table>
		<tbody>
			<tr>
				<td>
					<label for="naziv"><strong>Naziv lige:</strong></label>
				</td>
				<td>
					<input type="text" name="naziv" id="naziv"
						size="120" minlength="3" maxlength="50"
						placeholder="Ime lige ne smije sadržavati praznine, treba uključiti minimalno 3 znaka i započeti velikim početnim slovom"
						required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="slika"><strong>Slika:</strong></label>
				</td>
				<td>
					<input name="slika" type="text" size="120" required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="video"><strong>Video:</strong></label>
				</td>
				<td>
					<input name="video" type="text" size="120" required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="opis"><strong>Opis lige:</strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis"
						size="120" minlength="10" maxlength="50"
						placeholder="Opis lige ne smije sadržavati praznine, treba uključiti minimalno 6 znakova i započeti velikim početnim slovom"
						required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="korisnik_id"><strong>Moderator:</strong></label>
				</td>
				<td>
			<?php
					echo '<select name="korisnik_id" required>'; 
					$upit='SELECT korisnik_id, korisnicko_ime 
					FROM korisnik WHERE tip_korisnika_id=1';
					$rezultat=izvrsiUpit($bp, $upit);
					WHILE(list($korisnik_id, $korisnicko_ime)=mysqli_fetch_array($rezultat)){
						echo '<option value="'.$korisnik_id.'">'.$korisnicko_ime.'</option>';
					}
					echo '</select>';
			?>	
				</td>
			</tr>		
			<tr>
				<td colspan="2" style="text-align:center;">
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
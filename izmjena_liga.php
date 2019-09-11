<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	$liga_id=$_GET['id'];
	$opis_lige='';
	$naziv_lige='';
	$slika_lige='';
	$video_lige='';
	$moderator_lige='';
	if(isset($_SESSION['tip_korisnika_id'])){
		$tip_korisnika=$_SESSION['tip_korisnika_id'];
		if($tip_korisnika==0){
			$upit='SELECT naziv, slika, video, opis, moderator_id
			FROM liga 
			WHERE liga_id = '.$liga_id;
			}
			$rezultat=izvrsiUpit($bp, $upit);
			while(list( $naziv, $slika, $video, $opis, $moderator_id)=mysqli_fetch_array($rezultat)){
				$opis_lige=$opis;
				$naziv_lige=$naziv;
				$slika_lige=$slika;
				$video_lige=$video;
				$moderator_lige=$moderator_id;
			}
	}
	
	if(isset($_POST['submit'])){
		$naziv=$_POST['naziv'];
		$slika=$_POST['slika'];
		$video=$_POST['video'];
		$opis=$_POST['opis'];
		$korisnik_id=$_POST['korisnik_id'];
		$liga_id=$_POST['liga_id'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
				$upit='UPDATE liga SET naziv="'.$naziv.'", slika="'.$slika.'", video="'.$video.'", moderator_id='.$korisnik_id.', opis="'.$opis.'"
				WHERE liga_id = '.$liga_id;
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
						required value="<?php echo $naziv_lige; ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="slika"><strong>Slika:</strong></label>
				</td>
				<td>
					<input name="slika" type="text" required value="<?php echo $slika_lige; ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="video"><strong>Video:</strong></label>
				</td>
				<td>
					<input name="video" type="text" required value="<?php echo $video_lige; ?>"/>
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
						required value="<?php echo $opis_lige; ?>"/>
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
					FROM korisnik
					WHERE tip_korisnika_id = 1';
					$rezultat=izvrsiUpit($bp, $upit);
					WHILE(list($korisnik_id, $korisnicko_ime)=mysqli_fetch_array($rezultat)){
						echo '<option value="'.$korisnik_id.'"';
						if($moderator_lige == $korisnik_id)
							echo 'selected="selected"';
						echo '>'.$korisnicko_ime.'</option>';
					}
					echo '</select>';
			?>	
				</td>
			</tr>		
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="submit" value="Pošalji"/>
					<input type="hidden" name="liga_id" value="<?php echo $liga_id; ?>"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
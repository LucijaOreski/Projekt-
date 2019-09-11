<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
	
	$korisnik_id=$_GET['id'];
	$korisnicko_ime='';
	$lozinka_korisnika='';
	$ime_korisnika='';
	$prezime_korisnika='';
	$email_korisnika='';
	$slika_korisnika='';
	$tip_korisnika_id='';
	if(isset($_SESSION['tip_korisnika_id'])){
		$tip_korisnika=$_SESSION['tip_korisnika_id'];
		if($tip_korisnika==0){
			$upit='SELECT tip_korisnika.tip_korisnika_id, korisnicko_ime, lozinka, ime, prezime, email, slika 
			FROM korisnik, tip_korisnika
			WHERE korisnik.tip_korisnika_id=tip_korisnika.tip_korisnika_id AND korisnik_id='.$korisnik_id;

			$rezultat=izvrsiUpit($bp, $upit);
			while(list($tip, $kor_ime, $lozinka, $ime, $prezime, $email, $slika)=mysqli_fetch_array($rezultat)){
				$tip_korisnika_id=$tip;
				$korisnicko_ime=$kor_ime;
				$lozinka_korisnika=$lozinka;
				$ime_korisnika=$ime;
				$prezime_korisnika=$prezime;
				$email_korisnika=$email;
				$slika_korisnika=$slika;
			}	
		}
	}
	
	
	if(isset($_POST['submit'])){
		$korisnik_id=$_POST['korisnik_id'];
		$tip_korisnika_id=$_POST['tip_korisnika'];
		$korisnicko_ime=$_POST['korisnicko_ime'];
		$lozinka_korisnika=$_POST['lozinka_korisnika'];
		$ime_korisnika=$_POST['ime_korisnika'];
		$prezime_korisnika=$_POST['prezime_korisnika'];
		$email_korisnika=$_POST['email_korisnika'];
		$slika_korisnika=$_POST['slika_korisnika'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
			$upit='UPDATE korisnik SET tip_korisnika_id='.$tip_korisnika_id.', korisnicko_ime="'.$korisnicko_ime.'", lozinka="'.$lozinka_korisnika.'", 
			ime="'.$ime_korisnika.'", prezime="'.$prezime_korisnika.'", email="'.$email_korisnika.'", slika="'.$slika_korisnika.'"
			WHERE korisnik_id='.$korisnik_id;
			izvrsiUpit($bp, $upit); 
			header('Location: popis_korisnika.php');
			}
		}	
	}	
?>


<form method="POST" action="">
<table>
	<tbody>
		<tr>
			<td>
				<label for="korisnicko_ime"><strong>Korisničko ime:</strong></label>
			</td>
			<td>
				<input type="text" name="korisnicko_ime" id="korisnicko_ime"
					size="120" minlength="6" maxlength="50"
					placeholder="Korisničko ime mora sadržavati barem 6 znakova."
					required value="<?php echo $korisnicko_ime; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="lozinka_korisnika"><strong>Lozinka:</strong></label>
			</td>
			<td>
				<input name="lozinka_korisnika" id="lozinka_korisnika" 
					size="120" minlength="6" maxlength="50"	placeholder="Lozinka treba sadržati minimalno 6 znakova."
					required
					value="<?php echo $lozinka_korisnika; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ime_korisnika"><strong>Ime:</strong></label>
			</td>
			<td>
				<input type="text" name="ime_korisnika" id="ime_korisnika" 
					size="120" minlength="1" maxlength="50" placeholder="Ime mora započeti velikim početnim slovom." 
					required value="<?php echo $ime_korisnika; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="prezime_korisnika"><strong>Prezime:</strong></label>
			</td>
			<td>
				<input type="text" name="prezime_korisnika" id="prezime_korisnika" 
					size="120" minlength="1" maxlength="50" placeholder="Prezime mora započeti velikim početnim slovom." 
					required
					value="<?php echo $prezime_korisnika; ?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="email_korisnika"><strong>E-mail:</strong></label>
			</td>
			<td>
				<input type="email" name="email_korisnika" id="email_korisnika" 
					size="120" minlength="6" maxlength="50" placeholder="Ispravan oblik elektroničke pošte je nesto@nesto.nesto." 
					required
					value="<?php echo $email_korisnika; ?>"/>
			</td>
		</tr>
		<tr>
			<td><label for="tip_korisnika"><strong>Tip korisnika:</strong></label></td>
			<td>
				<select id="tip_korisnika" name="tip_korisnika">
				<?php
					echo '<option value="0"';
					if($tip_korisnika_id==0) 
						echo " selected='selected'";
					echo'>Administrator</option>';
					echo '<option value="1"'; 
					if($tip_korisnika_id==1)
						echo " selected='selected'";
					echo'>Voditelj</option>';
					echo '<option value="2"';
					if($tip_korisnika_id==2)
						echo " selected='selected'";
					echo'>Korisnik</option>';
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="slika_korisnika"><strong>Slika:</strong></label>
			</td>
			<td>
			<?php
					$dir=scandir("korisnici");
					echo '<select id="slika_korisnika" name="slika_korisnika">';
					foreach($dir as $key => $value){
						if($key<2)continue;
						else if($slika_korisnika=="korisnici/".$value){
							echo '<option value="'."korisnici/".$value.'"';
							echo ' selected="selected">'."korisnici/".$value;
							echo '</option>';
						}
						else{
							echo '<option value="'."korisnici/".$value.'">';
							echo "korisnici/".$value;
							echo '</option>';
						}
					}
					echo '</select>';
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<input type="submit" name="submit" value="Pošalji"/>
				<input type="hidden" name="korisnik_id" value="<?php echo $korisnik_id; ?>"/>
			</td>
		</tr>
	</tbody>
</table>
</form>
	

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
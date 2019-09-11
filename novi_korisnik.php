<?php
	
	session_start();
	include ('zaglavlje.php');
	$bp = spojiSeNaBazu();

	if(isset($_POST['submit'])){
		$kor_ime=$_POST['kor_ime'];
		$lozinka=$_POST['lozinka'];
		$ime=$_POST['ime'];
		$prezime=$_POST['prezime'];
		$email=$_POST['email'];
		$tip=$_POST['tip'];
		$slika=$_POST['slika'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==0){
			$upit='INSERT INTO korisnik (korisnicko_ime, lozinka, ime, prezime, email, tip_korisnika_id, slika) VALUES 
			("'.$kor_ime.'", "'.$lozinka.'", "'.$ime.'", "'.$prezime.'", "'.$email.'", "'.$tip.'", "'.$slika.'")';
			izvrsiUpit($bp, $upit); 
			header('Location: popis_korisnika.php');
			}
		}	
	}	
	$slika="";
?>

<form method="POST" action="">
<table>
	<tbody>
		<tr>
			<td>
				<label for="kor_ime"><strong>Korisničko ime:</strong></label>
			</td>
			<td>
				<input type="text" name="kor_ime" id="kor_ime"
					size="120" minlength="3" maxlength="50"
					placeholder="Korisničko ime mora sadržavati barem 3 znaka."
					required/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="lozinka"><strong>Lozinka:</strong></label>
			</td>
			<td>
				<input name="lozinka" id="lozinka" 
					size="120" minlength="6" maxlength="50"	placeholder="Lozinka treba sadržati minimalno 6 znakova."
					required/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ime"><strong>Ime:</strong></label>
			</td>
			<td>
				<input type="text" name="ime" id="ime" 
					size="120" minlength="1" maxlength="50" placeholder="Ime mora započeti velikim početnim slovom." 
					required/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="prezime"><strong>Prezime:</strong></label>
			</td>
			<td>
				<input type="text" name="prezime" id="prezime" 
					size="120" minlength="1" maxlength="50" placeholder="Prezime mora započeti velikim početnim slovom." 
					required/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="email"><strong>E-mail:</strong></label>
			</td>
			<td>
				<input type="email" name="email" id="email" 
					size="120" minlength="6" maxlength="50" placeholder="Ispravan oblik elektroničke pošte je nesto@nesto.nesto." 
					required/>
			</td>
		</tr>
		<tr>
			<td><label for="tip"><strong>Tip korisnika:</strong></label></td>
			<td>
				<select id="tip" name="tip">
					<option value="0">Administrator</option>
					<option value="1">Voditelj</option>
					<option value="2">Korisnik</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="slika"><strong>Slika:</strong></label>
			</td>
			<td>
			<?php
				$dir=scandir("korisnici");
				echo '<select id="slika" name="slika">';
				foreach($dir as $key => $value){
					if($key<2)continue;
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
			</td>
		</tr>
	</tbody>
</table>
</form>
	
	
<?php
	
	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
?>
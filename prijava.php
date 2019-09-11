<?php
	
	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();

	$korisnicko_ime='';
	$lozinka='';
	$greska= '';
	
	if(isset($_POST['submit'])){	
		$korisnicko_ime=$_POST['korisnicko_ime'];
		$lozinka=$_POST['lozinka'];	
		foreach($_POST as $kljuc => $vrijednost){
			if(empty($vrijednost)){
				$greska .= $kljuc. ',';
			}
		}
		if(empty($greska)){
		$upit='SELECT korisnik_id, tip_korisnika_id, ime, prezime FROM korisnik WHERE korisnicko_ime="'.$korisnicko_ime.'" 
		AND lozinka="'.$lozinka.'"';
			$rezultat=izvrsiUpit($bp, $upit);
			$korisnikPostoji=false;
			WHILE(list($korisnik_id, $tip_korisnika_id, $ime, $prezime)=mysqli_fetch_array($rezultat)){
				$korisnikPostoji=true;
				$_SESSION['id']=$korisnik_id;
				$_SESSION['tip_korisnika_id']=$tip_korisnika_id;
				$_SESSION['ime']=$ime;
				$_SESSION['prezime']=$prezime;
			}
			If($korisnikPostoji){
				header('Location: index.php');
			}
			else{
				$greska='Pogrešno korisničko ime ili lozinka!';
			}
		}
		else{
			$greska='Navedena polja nisu ispunjena: '.$greska;
		}
	}
	
	
	
?>



<form id="prijava" name="prijava" method="POST" action="prijava.php">
	<link href="lucija.css" rel="stylesheet" type="text/css">
	<table>
		<caption style="color: #2B3856; font-size: 30px;">Prijava u sustav</caption>
		<tbody>
			<tr>
					<td colspan="2" style="text-align:center;">
						<label class="greska"><?php if($greska!="")echo $greska; ?></label>
					</td>
			</tr>
			<tr>
				<td>
					<label for="korisnicko_ime"><strong>Korisničko ime:</strong></label>
				</td>
				<td>
					<input name="korisnicko_ime" id="korisnicko_ime" type="text" size="120"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="lozinka"><strong>Lozinka:</strong></label>
				</td>
				<td>
					<input name="lozinka"	id="lozinka" type="password" size="120"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input name="submit" type="submit" value="Prijavi se"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php
	
	zatvoriVezuNaBazu($bp);
	include('podnozje.php');
	
?>
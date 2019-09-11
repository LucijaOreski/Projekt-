<?php

	session_start();
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();
		
	if(isset($_POST['submit'])){
		$id=$_POST['id'];
		$rezultat_1=$_POST['rezultat_1'];
		$rezultat_2=$_POST['rezultat_2'];
		if(isset($_SESSION['tip_korisnika_id'])){
			$tip_korisnika=$_SESSION['tip_korisnika_id'];
			if($tip_korisnika==1 || $tip_korisnika==0){
			$upit='UPDATE utakmica SET rezultat_1 = '.$rezultat_1.', rezultat_2 = '.$rezultat_2.' 
			WHERE utakmica_id='.$id;
			izvrsiUpit($bp, $upit); 
			
			$upit='UPDATE listic SET listic.status = IF((SELECT 
				(CASE WHEN rezultat_1 > rezultat_2 
				THEN 1 WHEN rezultat_1 < rezultat_2 
				THEN 2 ELSE 0 END) AS konacni_rezultat 
				FROM utakmica WHERE utakmica_id='.$id.') = listic.ocekivani_rezultat, "D", "N") 
				WHERE utakmica_id = '.$id.'';
			izvrsiUpit($bp, $upit);
			header('Location: moje_utakmice.php');
			}
		}	
	}	
?>


<form method="POST" action="">
	<table>
		<tbody>
		<?php
		$id=$_GET['id'];
		$upit='SELECT m1.naziv, m2.naziv, utakmica.rezultat_1, utakmica.rezultat_2, utakmica_id 
			FROM momcad m1, momcad m2, utakmica 
			WHERE m1.momcad_id = utakmica.momcad_1 
			and m2.momcad_id = utakmica.momcad_2
			AND utakmica_id = '.$id;
		$rezultat=izvrsiUpit($bp, $upit);	
		WHILE(list($momcad_1, $momcad_2, $rezultat_1, $rezultat_2)=mysqli_fetch_array($rezultat)){
		echo '<tr>
				<td>
					<label><strong>Naziv 1.momčadi:</strong></label>
				</td>
				<td>
					'.$momcad_1.'
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Naziv 2.momčadi:</strong></label>
				</td>
				<td>
					'.$momcad_2.'
				</td>
			</tr>
			<tr>	
				<td>
					<label><strong>Rezultat 1:</strong></label>
				</td>	
				<td>
					<input type="number_format" name="rezultat_1" id="rezultat_1"
						size="120" value="'.$rezultat_1.'"
						required/>
				</td>
			<tr>	
				<td>
					<label><strong>Rezultat 2:</strong></label>
				</td>
				<td>
					<input type="number_format" name="rezultat_2" id="rezultat_2"
						size="120" value="'.$rezultat_2.'"
						required/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="hidden" name="id" value="'.$id.'"/>
					<input type="submit" name="submit" value="Pošalji"/>
				</td>
			</tr>';
			
			}
		?>	
			
		</tbody>
	</table>
</form>

<?php

	zatvoriVezuNaBazu($bp);
	include ('podnozje.php');
	
?>
<?php

	define("POSLUZITELJ","localhost");
	define("BAZA","iwa_2018_vz_projekt");
	define("BAZA_KORISNIK","iwa_2018");
	define("BAZA_LOZINKA","foi2018");
	
	function spojiSeNaBazu(){
		$bp = mysqli_connect(POSLUZITELJ,BAZA_KORISNIK,BAZA_LOZINKA);
		if(!$bp)echo "GREŠKA: Problem sa spajanjem u datoteci baza.php funkcija spojiSeNaBazu: ".mysqli_connect_error();
		mysqli_select_db($bp,BAZA);
		if(mysqli_error($bp)!=="")echo "GREŠKA: Problem sa odabirom baze u baza.php funkcija spojiSeNaBazu: ".mysqli_error($bp);
		mysqli_set_charset($bp,"utf8");
		if(mysqli_error($bp)!=="")echo "GREŠKA: Problem sa odabirom baze u baza.php funkcija spojiSeNaBazu: ".mysqli_error($bp);
		
		return $bp;
	}	
	function izvrsiUpit($bp, $upit){
		$rezultat = mysqli_query($bp,$upit);
		if(mysqli_error($bp)!=="")echo "GREŠKA: Problem sa upitom: ".$upit." : u datoteci baza.php funkcija izvrsiUpit: ".mysqli_error($bp);
			
		return $rezultat;
	}
	function zatvoriVezuNaBazu($bp){
		mysqli_close($bp);
	}	
	
?>
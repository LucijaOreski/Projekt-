<?php

	session_start();
	
	include('zaglavlje.php');
	$bp=spojiSeNaBazu();

?>

<div>
	<p style="text-align: center;">
		<img src="kladionica_lmh.jpg" alt="KLADIONICA LMH"/>
	</p>
</div>






<?php
	zatvoriVezuNaBazu($bp);
	include('podnozje.php');
?>



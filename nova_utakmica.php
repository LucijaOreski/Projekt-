<?php

    session_start();
    include('zaglavlje.php');
    $bp=spojiSeNaBazu();
        
    if(isset($_POST['submit'])){
        $momcad_1=$_POST['momcad_1'];
        $momcad_2=$_POST['momcad_2'];
        $datum_pocetka=strtotime($_POST['datum_vrijeme_pocetka']);
        $opis=$_POST['opis'];
        if(isset($_SESSION['tip_korisnika_id'])){
            $tip_korisnika=$_SESSION['tip_korisnika_id'];
			$strani_datum=date('Y-m-d H:i:s', $datum_pocetka);
            if($tip_korisnika==1){
            $upit='INSERT INTO utakmica (momcad_1, momcad_2, datum_vrijeme_pocetka, datum_vrijeme_zavrsetka, rezultat_1, rezultat_2, opis) VALUES 
            ('.$momcad_1.', '.$momcad_2.', "'.$strani_datum.'", "'.$strani_datum.'" + INTERVAL 90 MINUTE, -1, -1, "'.$opis.'")';
            izvrsiUpit($bp, $upit); 
            header('Location: moje_utakmice.php');
            }
        }    
    }    
    $korisnik_id=$_SESSION['id'];
?>


<form method="POST" action="">
    <table>
        <tbody>
            <tr>
                <td>
                    <label><strong>Naziv 1.momčadi:</strong></label>
                </td>
                <td>
                    <?php
                        echo '<select name="momcad_1" required>'; 
                        $upit='SELECT momcad_id, momcad.naziv
                        FROM momcad, liga WHERE momcad.liga_id = liga.liga_id and moderator_id = '.$korisnik_id;
                        $rezultat=izvrsiUpit($bp, $upit);
                        WHILE(list($momcad_id, $naziv)=mysqli_fetch_array($rezultat)){
                            echo '<option value="'.$momcad_id.'">'.$naziv.'</option>';
                        }
                        echo '</select>';
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    <label><strong>Naziv 2.momčadi:</strong></label>
                </td>
                <td>
                    <?php
                        echo '<select name="momcad_2" required>'; 
                        $upit='SELECT momcad_id, momcad.naziv
                        FROM momcad, liga WHERE momcad.liga_id = liga.liga_id and moderator_id = '.$korisnik_id;
                        $rezultat=izvrsiUpit($bp, $upit);
                        WHILE(list($momcad_id, $naziv)=mysqli_fetch_array($rezultat)){
                            echo '<option value="'.$momcad_id.'">'.$naziv.'</option>';
                        }
                        echo '</select>';
                    ?>    
                </td>
            </tr>
            <tr>
                <td>
                    <label><strong>Datum i vrijeme početka:</strong></label>
                </td>
                <td>
                    <input name="datum_vrijeme_pocetka" />
                </td>
            </tr>
            <tr>    
                <td>
                    <label><strong>Opis: </strong></label>
                </td>
                <td>
                    <input type="text" name="opis" id="opis"
                        size="120" 
                        required/>
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
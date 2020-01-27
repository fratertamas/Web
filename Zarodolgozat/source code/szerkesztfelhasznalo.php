<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Felhasználó szerkesztése';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    
?>
<?php
if(isset($_SESSION['beosztasnev']) && (($_SESSION['beosztasnev'] == "intézményvezető") || 
        ($_SESSION['beosztasnev'] == "intézményvezető helyettes")) && isset($_GET['id'])){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");
    $id = mysqli_real_escape_string($dbkapcs, trim($_GET['id']));
    
    
?>    
    <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Felhasználó adatainak szerkesztése:</h4><br />
    <?php
        $query = "SELECT felhasznalonev, f_vezeteknev, f_keresztnev, f_beosztas, beosztas_nev, f_csoport, csoport_nev FROM felhasznalo_regadatok INNER JOIN felhasznalo ON felhasznalo_regadatok.felhasznalo_id = felhasznalo.felhasznalo_id  INNER JOIN beosztas ON f_beosztas = beosztas_id INNER JOIN csoport ON f_csoport = csoport_id WHERE felhasznalo_regadatok.felhasznalo_id = ".$id.";";
        $data = mysqli_query($dbkapcs, $query);
        
        if (mysqli_num_rows($data) == 1) {
            $sor = mysqli_fetch_array($data);
            $mfnev = $sor['felhasznalonev'];
            $mvnev = $sor['f_vezeteknev'];
            $mknev = $sor['f_keresztnev'];
            $mbeosztasid = $sor['f_beosztas'];
            $mbeosztasnev= $sor['beosztas_nev'];
            $mcsoportid = $sor['f_csoport'];
            $mcsoportnev = $sor['csoport_nev'];
        }
        if(isset($_POST['fn_nev']) && isset($_POST['vnev'])
       && isset($_POST['knev']) && isset($_POST['beosztas']) && isset($_POST['csoport'])){
            
        $fnev = mysqli_real_escape_string($dbkapcs, trim($_POST['fn_nev']));
        $vnev = mysqli_real_escape_string($dbkapcs, trim($_POST['vnev']));
        $knev = mysqli_real_escape_string($dbkapcs, trim($_POST['knev']));
        $beosztas = $_POST['beosztas'];
        $csoport = $_POST['csoport'];
        
        //Felhasználónév létezésének (adatbázisban) ellenőrzésée
        $query = "SELECT felhasznalonev FROM felhasznalo_regadatok;";
        $data = mysqli_query($dbkapcs, $query);
        while ($sor = mysqli_fetch_array($data)) {
            if(($sor['felhasznalonev'] == $fnev) && ($fnev !=$mfnev)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A megadott felhasználónév már létezik!<br />";
                
            }
        }
        //Felhasználónév, Vezetéknév és Keresztnév mezők ürességének vizsgálata
        if ($fnev == "") {
            $hiba = true;
            $uzenetcim = "Hibaüzenet";
            $uzenet .= "Nem adta meg az új felhasználó felhasználónevét!<br />";
        }
        if ($vnev == "") {
            $hiba = true;
            $uzenetcim = "Hibaüzenet";
            $uzenet .= "Nem adta meg az új felhasználó vezetéknevét!<br />";
        }
        if ($knev == "") {
            $hiba = true;
            $uzenetcim = "Hibaüzenet";
            $uzenet .= "Nem adta meg az új felhasználó keresztnevét!<br />";
        }
       
        //Selectek vizsgálata
        if ($beosztas == 0) {
            $hiba = true;
            $uzenetcim = "Hibaüzenet";
            $uzenet .= "Nem választott ki az új felhasználó beosztását!<br />";
        }
        if ($csoport == 0){
            $hiba = true;
            $uzenetcim = "Hibaüzenet";
            $uzenet .= "Nem választott ki az új felhasználó csoportotját!<br />";
        }
        if ($hiba == TRUE) {
            ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
            </script><?php
        }else{
            
            $uzenetcim = "Visszajelzés";
            $uzenet = "Sikeresen módosította a felhasználó adatait!<br />A felhasználók kezelése oldal automatikusan betölt 3mp múlva.";
            
            //Felhasználó adatok frissítése a felhasznalo_regadatok és felhasználó táblában táblákban
            $query = "UPDATE felhasznalo_regadatok SET felhasznalonev='".$fnev."' WHERE felhasznalo_id=".$id.";";
            mysqli_query($dbkapcs, $query);
            $query = "UPDATE felhasznalo SET f_vezeteknev='".$vnev."', f_keresztnev='".$knev."',f_beosztas=".$beosztas.",f_csoport=".$csoport." WHERE felhasznalo_id=".$id.";";
            mysqli_query($dbkapcs, $query);
            ?>
            <script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
                setTimeout("location.href='felhasznalokkezelese.php'",3000);
            </script><?php
        }
       }
        
    ?>
    <div class="row" style="width:100%;">           
        <div class="col-md-9">           
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id; ?>" method="post">
                        <div class="form-group row">
                            <label for="fn_nev" class="col-4 col-form-label">Felhasználónév</label> 
                            <div class="col-8">
                                <input id="fn_nev" name="fn_nev" placeholder="Felhasználónév" class="form-control here" type="text" value=<?php if (isset($fnev) &&  ($hiba == true)){ echo $fnev;}else{if(isset($fnev)){echo $fnev;}else{echo $mfnev;}}?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vnev" class="col-4 col-form-label">Vezetéknév</label> 
                            <div class="col-8">
<input id="vnev" name="vnev" placeholder="Vezetéknév" class="form-control here" type="text" value=<?php if (isset($vnev) &&  ($hiba == true)){ echo $vnev;}else{ if(isset($vnev)){echo $vnev;}else{echo $mvnev;}}?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="knev" class="col-4 col-form-label">Keresztnév</label> 
                            <div class="col-8">
                                <input id="knev" name="knev" placeholder="Keresztnév" class="form-control here" type="text" value=<?php if (isset($knev) &&  ($hiba == true)){ echo $knev;}else{ if(isset($knev)){echo $knev;}else{echo $mknev;}}?>>
                            </div>
                        </div>
                        <?php
                            $query = "SELECT * FROM beosztas;";
                            $data = mysqli_query($dbkapcs, $query);
                        ?>
                        <div class="form-group row">
                            <label for="beosztas" class="col-4 col-form-label">Beosztás</label> 
                            <div class="col-8">
                                <select id="beosztas" name="beosztas" class="custom-select">
                                    <?php
                                    if (isset($beosztas) &&  ($hiba == true)){
                                        $query2 = "SELECT * FROM beosztas WHERE beosztas_id = ".$beosztas.";";
                                        $data2 = mysqli_query($dbkapcs, $query2);
                                        $sor2 = mysqli_fetch_array($data2);
                                    }
                                    ?>
                                    <option value=<?php if (isset($beosztas) &&  ($hiba == true)){ echo $beosztas. ' selected';} else {echo $mbeosztasid. ' selected';}?>><?php if (isset($beosztas) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['beosztas_nev'];} else {echo $mbeosztasnev;}?></option>
                                    <?php
                                    while ($sor = mysqli_fetch_array($data)) {
                                        //
                                        echo '<option value="'.$sor['beosztas_id'].'">'.$sor['beosztas_nev'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            $query = "SELECT * FROM csoport;";
                            $data = mysqli_query($dbkapcs, $query);
                        ?>
                        <div class="form-group row">
                            <label for="csoport" class="col-4 col-form-label">Csoport</label> 
                            <div class="col-8">
                                <select id="csoport" name="csoport" class="custom-select">
                                    <?php
                                    if (isset($beosztas) &&  ($hiba == true)){
                                        $query2 = "SELECT * FROM csoport WHERE csoport_id = ".$csoport.";";
                                        $data2 = mysqli_query($dbkapcs, $query2);
                                        $sor2 = mysqli_fetch_array($data2);
                                    }
                                    ?>
                                    <option value=<?php if (isset($csoport) &&  ($hiba == true)){ echo $csoport. ' selected';} else {echo $mcsoportid;}?>><?php if (isset($csoport) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['csoport_nev'];} else {echo $mcsoportnev;}?></option>
                                    <?php
                                    while ($sor = mysqli_fetch_array($data)) {
                                        echo '<option value="'.$sor['csoport_id'].'">'.$sor['csoport_nev'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-4 col-8" style="text-align: center;">
                                <button id="submit" name="submit" type="submit" class="btn btn-dark" >Felhasználó adatainak módosítása</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
                        <?php
                            mysqli_close($dbkapcs);
                        ?>        
<?php    
}else{
    $uzenetcim = "Hibaüzenet";
    $uzenet .= "Nincs jogosultsága az oldal megtekintéséhez!<br />";
    ?><script>
        $(document).ready(function(){
        $("#visszajelzes").modal('show');});
        setTimeout("location.href='kezdolap.php'",2000);
    </script><?php
 }
?>
                                   

<!-- Modal -->
    <div class="modal" id="visszajelzes">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Fejléc -->
            <div class="modal-header">
              <h4 class="modal-title" <?php if($uzenetcim == "Hibaüzenet"){
                echo 'style="color: red;text-align: center;"';
            }else{
            echo 'style="color: #06104c;text-align: center;"';}?>><?php echo $uzenetcim; ?></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal törzs -->
            <div class="modal-body" <?php if($uzenetcim == "Hibaüzenet"){
                echo 'style="color: red;text-align: center;"';
            }else{
            echo 'style="color: #06104c;text-align: center;"';}?>>
              <?php echo $uzenet; ?>
            </div>

            <!-- Modal lábéc -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Bezár</button>
            </div>

          </div>
        </div>
    </div>
<?php
//lábléc
  require_once('footer.php');
?>   
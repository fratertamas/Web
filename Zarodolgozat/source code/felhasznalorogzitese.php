<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Új felhasználó rögzítése';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    
?>
<?php
if($_SESSION['beosztasnev'] == "intézményvezető"){
    if(isset($_POST['fn_nev']) && isset($_POST['ujJelszo1']) && isset($_POST['vnev'])
       && isset($_POST['knev']) && isset($_POST['beosztas']) && isset($_POST['csoport'])){
        
        $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                   or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
        $dbkapcs->query("SET NAMES utf8;");
        $fnev = mysqli_real_escape_string($dbkapcs, trim($_POST['fn_nev']));
        $jelszo = mysqli_real_escape_string($dbkapcs, trim($_POST['ujJelszo1']));
        $vnev = mysqli_real_escape_string($dbkapcs, trim($_POST['vnev']));
        $knev = mysqli_real_escape_string($dbkapcs, trim($_POST['knev']));
        $beosztas = $_POST['beosztas'];
        $csoport = $_POST['csoport'];
        
        //Felhasználónév létezésének (adatbázisban) ellenőrzésée
        $query = "SELECT felhasznalonev FROM felhasznalo_regadatok;";
        $data = mysqli_query($dbkapcs, $query);
        while ($sor = mysqli_fetch_array($data)) {
            if($sor['felhasznalonev'] == $fnev){
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
            $uzenet = "Sikeresen felvitelre került az új felhasználó!";
            
            //Felhasználó beszúrása a felhasznalo_regadatok táblába
            $hashelt=hash("sha512", $jelszo); 
            $query = "INSERT INTO felhasznalo_regadatok (felhasznalonev, jelszo) VALUES ('".$fnev."','".$hashelt."');";
            $data = mysqli_query($dbkapcs, $query);
            $query = "UPDATE felhasznalo SET f_vezeteknev='".$vnev."', f_keresztnev='".$knev."',f_beosztas=".$beosztas.",f_csoport=".$csoport." WHERE f_vezeteknev IS NULL AND f_keresztnev IS NULL AND f_beosztas IS NULL AND f_csoport IS NULL;";
            $data = mysqli_query($dbkapcs, $query);
            ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
            </script><?php
        }
        
    }
?>
<div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Új felhasználó adatainak megadása:</h4><br />
    <div class="row" style="width:100%;">    
        
        <div class="col-md-9">
            
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group row">
                            <label for="fn_nev" class="col-4 col-form-label">Felhasználónév</label> 
                            <div class="col-8">
                                <input id="fn_nev" name="fn_nev" placeholder="Felhasználónév" class="form-control here" type="text" value=<?php if (isset($fnev) &&  ($hiba == true)){ echo $fnev;}?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ujJelszo1" class="col-4 col-form-label">Jelszó</label> 
                            <div class="col-8">
                                <input id="ujJelszo1" name="ujJelszo1" placeholder="Jelszó" class="form-control here" type="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ujJelszo2" class="col-4 col-form-label">Jelszó megerősítése</label> 
                            <div class="col-8">
                                <input id="ujJelszo2" name="ujJelszo2" placeholder="Jelszó megerősítése" class="form-control here"  type="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vnev" class="col-4 col-form-label">Vezetéknév</label> 
                            <div class="col-8">
                                <input id="vnev" name="vnev" placeholder="Vezetéknév" class="form-control here" type="text" value=<?php if (isset($vnev) &&  ($hiba == true)){ echo $vnev;}?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="knev" class="col-4 col-form-label">Keresztnév</label> 
                            <div class="col-8">
                                <input id="knev" name="knev" placeholder="Keresztnév" class="form-control here" type="text" value=<?php if (isset($knev) &&  ($hiba == true)){ echo $knev;}?>>
                            </div>
                        </div>
                        <?php
                            $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                                        or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
                            $dbkapcs->query("SET NAMES utf8;");
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
                                    <option value=<?php if (isset($beosztas) &&  ($hiba == true)){ echo $beosztas. ' selected';} else {echo 0;}?>><?php if (isset($beosztas) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['beosztas_nev'];} else {echo "Nincs kiválasztva";}?></option>
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
                                    <option value=<?php if (isset($csoport) &&  ($hiba == true)){ echo $csoport. ' selected';} else {echo 0;}?>><?php if (isset($csoport) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['csoport_nev'];} else {echo "Nincs kiválasztva";}?></option>
                                    <?php
                                    while ($sor = mysqli_fetch_array($data)) {
                                        echo '<option value="'.$sor['csoport_id'].'">'.$sor['csoport_nev'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            mysqli_close($dbkapcs);
                        ?>
                        <div class="form-group row">
                            <div class="offset-4 col-8" style="text-align: center;">
                                <button id="submit" name="submit" type="submit" class="btn btn-dark" disabled>Új felhasználó rögzítése</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="funkciok/jelszocsere.js"></script>
        <div class="col-md-3 " >
            <p style="text-align: center;" >
                <span id='egyezes'></span>
            </p>
            <h6 style="text-align: center;">A jelszó a következőket kell tartamazza:</h6>
            <ul class="list-group">
                <li id="betu" class="list-group-item ervenytelen">Legalább <strong>egy betűt</strong></li>
                <li id="nagybetu" class="list-group-item ervenytelen">Legalább <strong>egy nagy betűt</strong></li>
                <li id="szam" class="list-group-item ervenytelen">Legalább <strong>egy számot</strong></li>
                <li id="hossz" class="list-group-item ervenytelen">Legalább <strong>8 karakterből</strong> kell álljon</li>
            </ul>
        </div>
        
    </div>
</div>
<?php
 }else{
    $uzenetcim = "Hibaüzenet";
    $uzenet .= "Nincs jogosultsága az oldal megtekintéséhez!<br />";
    ?><script>
            $(document).ready(function(){
            $("#visszajelzes").modal('show');});
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
<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Tanulók adatainak listázása';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    $feltetel ="";
    
if(isset($_SESSION['beosztasnev'])){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");        
?>    

 <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Tanulók kezelése</h4><br />
   <?php
     if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
        
         if(!isset($_GET['oldal'])){
         ?>    
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="form-group row">
                    <label for="szoktazon" class="col-1 col-form-label">Okt. azon.</label> 
                    <div class="col-3">
                        <input id="szoktazon" name="szoktazon" placeholder="Oktatási azonosító" class="form-control here" type="text" value="">
                    </div>
                    <label for="sznem" class="col-1 col-form-label">Nem</label> 
                    <div class="col-3">
                        <select id="sznem" name="sznem" class="custom-select">                 
                            <option value="-">Nincs kiválasztva</option>
                            <option value="0">Nő</option>
                            <option value="1">Férfi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="szvnev" class="col-1 col-form-label">Vezetéknév</label> 
                    <div class="col-3">
                        <input id="szvnev" name="szvnev" placeholder="Vezetéknév" class="form-control here" type="text" value="">
                    </div>
                    <label for="szknev" class="col-1 col-form-label">Keresztnév</label> 
                    <div class="col-3">
                        <input id="szknev" name="szknev" placeholder="Keresztnév" class="form-control here" type="text" value="">
                    </div>
                    <label for="szcsoport" class="col-1 col-form-label">Csoport</label> 
                    <div class="col-3">
                        <select id="szcsoport" name="szcsoport" class="custom-select">
                            <?php
                                $query = "SELECT * FROM csoport;";
                                $data = mysqli_query($dbkapcs, $query);
                            ?>                    
                            <option value=0>Nincs kiválasztva</option>
                            <?php
                                while ($sor = mysqli_fetch_array($data)) {
                                    if($sor['csoport_nev'] != "Minden"){
                                        echo '<option value="'.$sor['csoport_id'].'">'.$sor['csoport_nev'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="szlakhelytip" class="col-1 col-form-label">Lakhely tip.</label> 
                    <div class="col-3">
                        <select id="szlakhelytip" name="szlakhelytip" class="custom-select">
                            <?php
                                $query = "SELECT * FROM lakhely_tipus;";
                                $data = mysqli_query($dbkapcs, $query);
                            ?>                    
                            <option value=0>Nincs kiválasztva</option>
                            <?php
                                while ($sor = mysqli_fetch_array($data)) {
                                    echo '<option value="'.$sor['lakhely_tip_id'].'">'.$sor['lakhely_tip'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <label for="szfelekezet" class="col-1 col-form-label">Felekezet</label> 
                    <div class="col-3">
                        <select id="szfelekezet" name="szfelekezet" class="custom-select">
                            <?php
                            $query = "SELECT * FROM felekezet;";
                            $data = mysqli_query($dbkapcs, $query);
                            ?>                    
                            <option value=0>Nincs kiválasztva</option>
                            <?php
                            while ($sor = mysqli_fetch_array($data)) {
                                echo '<option value="'.$sor['felekezet_id'].'">'.$sor['felekezet_nev'].'</option>';
                            }
                            ?>
                        </select>            
                    </div>
                    <label for="szetkat" class="col-1 col-form-label" >Étk.kat.</label> 
                    <div class="col-3">
                        <select id="szetkat" name="szetkat" class="custom-select">
                            <?php
                            $query = "SELECT * FROM etkezesi_kategoria;";
                            $data = mysqli_query($dbkapcs, $query);
                            ?>                    
                            <option value=0>Nincs kiválasztva</option>
                            <?php
                            while ($sor = mysqli_fetch_array($data)) {
                                echo '<option value="'.$sor['etkezesi_kategoria_id'].'">'.$sor['etkezesi_kategoria_nev'].'</option>';
                            }
                            ?>
                        </select>    
                    </div>
                </div>
                <div style="text-align: center;">
                    <button id="submit" name="szures" type="szures" class="btn btn-dark" >Listáz</button>
                </div>
            </form>
            <hr/>
        <?php
        }
    }//a szűris feltételek megjelenítés vége
    
        
    //SZŰRÉSI FELTÉTELEK FELDOLGOZÁSÁNAK KEZDETE
        if(isset($_POST['szures'])){
            //TÖRLÉS
        if (isset($_POST['torol']) && isset($_POST['ttorol'])){
            foreach ($_POST['ttorol'] as $torlendo_id){
                $query = "DELETE FROM tanulo WHERE tanulo_id = $torlendo_id";
                mysqli_query($dbkapcs, $query); 
            }
            $uzenetcim = "Tanuló(k) törlése";
            $uzenet .= "A kiválasztott tanuló(k) törlve lett(ek)!<br />";
            ?><script>
                        $(document).ready(function(){
                        $("#visszajelzes").modal('show');});
                </script><?php
        }
        //TÖRLÉS VÉGE
            if(isset($_POST['szoktazon']) && !empty($_POST['szoktazon'])){
                $szoktazon = mysqli_real_escape_string($dbkapcs, trim($_POST['szoktazon']));
                $feltetel .= " t_oktatasi_azon =  '".$szoktazon."' AND ";
            }
            if(isset($_POST['sznem']) && ($_POST['sznem'] != "-")){
                $sznem = mysqli_real_escape_string($dbkapcs, trim($_POST['sznem']));
                $feltetel .= " t_neme = '".$sznem."' AND ";
            }
            if(isset($_POST['szvnev']) && !empty($_POST['szvnev'])){
                $szvnev = mysqli_real_escape_string($dbkapcs, trim($_POST['szvnev']));
                $feltetel .= "  t_vnev LIKE '%{$szvnev}%' AND ";

            }
            if(isset($_POST['szknev']) && !empty($_POST['szknev'])){
                $szknev = mysqli_real_escape_string($dbkapcs, trim($_POST['szknev']));
                $feltetel .= " t_knev LIKE '%{$szknev}%' AND ";
                echo $feltetel;
            }
            if(isset($_POST['szlakhelytip']) && ($_POST['szlakhelytip'] != 0)){
                $szlakhelytip = mysqli_real_escape_string($dbkapcs, trim($_POST['szlakhelytip']));
                $feltetel .= " t_lakhely_tip = '".$szlakhelytip."' AND ";
            }
            if(isset($_POST['szfelekezet']) && ($_POST['szfelekezet'] != 0)){
                $szfelekezet = mysqli_real_escape_string($dbkapcs, trim($_POST['szfelekezet']));
                $feltetel .= " t_felekezet = '".$szfelekezet."' AND ";
            }
            if(isset($_POST['szetkat']) && ($_POST['szetkat'] != 0)){
                $szetkat = mysqli_real_escape_string($dbkapcs, trim($_POST['szetkat']));
                $feltetel .= " t_etkezesi_kategoria = '".$szetkat."' AND ";
            }
            //SZŰRÉSI FELTÉTELEK FELDOLGOZÁSÁNAK VÉGE
            //
            $query = 'SELECT f_csoport FROM felhasznalo WHERE felhasznalo_id = "'.$_SESSION['felhasznalo_id'].'";';
        $data = mysqli_query($dbkapcs, $query);
        $sor = mysqli_fetch_array($data);

        
        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
            if(isset($_POST['szcsoport']) && ($_POST['szcsoport'] != 0)){
                $szcsoport = mysqli_real_escape_string($dbkapcs, trim($_POST['szcsoport']));
                $feltetel .= " t_csoport = '".$szcsoport."' ";
            }else{
                $feltetel .=  " t_csoport IS NOT NULL ";
            }
         }else{
            $feltetel .=  " t_csoport = '".$sor['f_csoport']."' "; 
         }
        $query = 'SELECT tanulo_id, t_oktatasi_azon, t_nev_elotag, t_vnev, t_knev, t_szul_hely, t_szul_datum,
            t_anya_nev_elotag, t_anya_nev, csoport_nev 
            FROM tanulo 
            INNER JOIN csoport ON csoport_id = t_csoport 
            WHERE '.$feltetel.'
            ORDER BY t_vnev ASC, t_knev ASC';
            $data = mysqli_query($dbkapcs, $query);
            echo '<div><strong>Találatok száma: '. mysqli_num_rows($data).' fő</strong></div>';
            //
            //IDE JÖN AZ EGYOLDALAS MEGJELENÍTÉS LAPOZÓ NÉLKÜL!!!!!!!!!
            if(($_SESSION['beosztasnev'] == "intézményvezető") 
            || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
            || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
            }else{
                echo '<form action="exportalasexcel.php" method="post">';    
            }?>
        <table class="table table-hover szegelymentes">
            <thead>
                <tr>
                    <th></th>
                    <th style="text-align: center;">Oktatási azonosító</th>
                    <th style="text-align: center;">Tanuló neve</th>
                    <th style="text-align: center;">Születési hely</th>
                    <th style="text-align: center;">Születési idő</th>
                    <th style="text-align: center;">Édesanyja neve</th>
                    <?php
                        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                            echo '<th style="text-align: center;">Csoport</th>';
                        }
                    ?>
                    <th></th>
                </tr>    
            </thead>
            <tbody>

        <?php
        
            while ($sor = mysqli_fetch_array($data)) { 
                echo '<tr>';
                    echo '<td class="align-middle" style="text-align:center;">';
                    if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                        echo '<input type="checkbox"  name="ttorol[]" value="'.$sor['tanulo_id'].'">';
                    }
                    echo '</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_oktatasi_azon'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_nev_elotag'].' '.$sor['t_vnev'].' '.$sor['t_knev'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_szul_hely'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_szul_datum'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_anya_nev_elotag'].' '.$sor['t_anya_nev'].'</td>';
                    if(($_SESSION['beosztasnev'] == "intézményvezető") 
                    || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                    || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                        echo '<td class="align-middle" style="text-align:center;">'.$sor['csoport_nev'].'</td>';
                        echo '<td class="align-middle" style="text-align:center;">'
                        .'<div class="btn-group">'
                        .'<button type="button" class="btn btn-dark  dropdown-toggle" data-toggle="dropdown">Műveletek</button>'
                        .'<div class="dropdown-menu">'
                          .'<a class="dropdown-item" href="tanulomegtekint.php?id='.$sor['tanulo_id'].
                     '"">Adatok megtekintése</a>'
                          .'<a class="dropdown-item" href="tanuloszerkeszt.php?id='.$sor['tanulo_id'].'">Adatok szerkesztése</a>'
                        .'</div>'
                    .'</div>'
                        . '</td>';
                    }else{
                        echo '<td class="align-middle" style="text-align:center;"><a href="tanulomegtekint.php?id='.$sor['tanulo_id'].
                         '"><input type="button" class="btn btn-dark" value="Adatok"></a></td>';
                    }
                echo '</tr>';  

            }
                echo '</tbody></table>';

        ?>
                <div class="form-group row">
                    <div class="col-1" style="text-align: center;">
                    <?php
                        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                            echo '<button id="torol" name="torol" type="submit" class="btn btn-dark" >Kijelöltek törlése</button>';
                        }else{

                            echo '<button type="submit" id="expsubmit" name="expsubmit" class="btn btn-dark" placeholder="Exportálás Excelbe" >Exportálás Excelbe</button>';
                        }
                    ?>
                </div>
            </div>        
            <!-- Lapozólinkek -->

            </form>
        </div>
    <?php   
        mysqli_close($dbkapcs);
            //LAPOZÓ NÉLKÜLI VÉGE
        }else{
            if(($_SESSION['beosztasnev'] == "intézményvezető") 
            || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
            || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
            }else{
                echo '<form action="exportalasexcel.php" method="post">';    
            }?>
        <table class="table table-hover szegelymentes">
            <thead>
                <tr>
                    <th></th>
                    <th style="text-align: center;">Oktatási azonosító</th>
                    <th style="text-align: center;">Tanuló neve</th>
                    <th style="text-align: center;">Születési hely</th>
                    <th style="text-align: center;">Születési idő</th>
                    <th style="text-align: center;">Édesanyja neve</th>
                    <?php
                        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                            echo '<th style="text-align: center;">Csoport</th>';
                        }
                    ?>
                    <th></th>
                </tr>    
            </thead>
            <tbody>

        <?php
        $query = 'SELECT f_csoport FROM felhasznalo WHERE felhasznalo_id = "'.$_SESSION['felhasznalo_id'].'";';
        $data = mysqli_query($dbkapcs, $query);
        $sor = mysqli_fetch_array($data);

        //TÖRLÉS
        if (isset($_POST['torol']) && isset($_POST['ttorol'])){
            foreach ($_POST['ttorol'] as $torlendo_id){
                $query = "DELETE FROM tanulo WHERE tanulo_id = $torlendo_id";
                mysqli_query($dbkapcs, $query); 
            }
            $uzenetcim = "Tanuló(k) törlése";
            $uzenet .= "A kiválasztott tanuló(k) törlve lett(ek)!<br />";
            ?><script>
                        $(document).ready(function(){
                        $("#visszajelzes").modal('show');});
                </script><?php
        }
        //TÖRLÉS VÉGE
        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                $feltetel .=  " t_csoport IS NOT NULL ";
         }else{
                $feltetel .=  " t_csoport = '".$sor['f_csoport']."' "; 
         }
        $query = 'SELECT tanulo_id, t_oktatasi_azon, t_nev_elotag, t_vnev, t_knev, t_szul_hely, t_szul_datum,
            t_anya_nev_elotag, t_anya_nev, csoport_nev 
            FROM tanulo 
            INNER JOIN csoport ON csoport_id = t_csoport 
            WHERE '.$feltetel.'
            ORDER BY t_vnev ASC, t_knev ASC';
            $data = mysqli_query($dbkapcs, $query);

            //Hány találatot akarok egy oldalon:
            $talalatperoldal = 25;
            //Összesen mennyi találat van:
            $osszestalalat = mysqli_num_rows($data);
            //oldalak száma
            $oldalakszama = ceil($osszestalalat/$talalatperoldal);
            //annak meghatározása, hogy melyik oldalon vagyunk
            if(!isset($_GET['oldal'])){
                $oldal=1;
            }else{
                $oldal=$_GET['oldal'];
            }
            if(isset($_GET['oldal']) && ($_GET['oldal']>1)){
                $elozooldal=$_GET['oldal']-1;
            }
            if(isset($_GET['oldal']) && ($_GET['oldal']<$oldalakszama)){
               $utolsooldal=$_GET['oldal']+1; 
            }
            if(!isset($_GET['ssz'])){
                $t_sorszam=0;
            }else{
                $t_sorszam=($oldal-1)*$talalatperoldal;
            }
            //SQL LIMIT kezdetének meghatározása
            $limitkezdoertek =  ($oldal-1)*$talalatperoldal;
            //Kiválasztott szakaszok az adatbázisból:
            $query = $query.' LIMIT '.$limitkezdoertek.', '.$talalatperoldal.';';
            $data = mysqli_query($dbkapcs, $query);


            while ($sor = mysqli_fetch_array($data)) { 
                $t_sorszam++;
                echo '<tr>';
                    echo '<td class="align-middle" style="text-align:center;">';
                    if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                        echo '<input type="checkbox"  name="ttorol[]" value="'.$sor['tanulo_id'].'">';
                    }else{
                        echo $t_sorszam;
                    }
                    echo '</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_oktatasi_azon'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_nev_elotag'].' '.$sor['t_vnev'].' '.$sor['t_knev'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_szul_hely'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_szul_datum'].'</td>';
                    echo '<td class="align-middle" style="text-align:center;">'.$sor['t_anya_nev_elotag'].' '.$sor['t_anya_nev'].'</td>';
                    if(($_SESSION['beosztasnev'] == "intézményvezető") 
                    || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                    || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                        echo '<td class="align-middle" style="text-align:center;">'.$sor['csoport_nev'].'</td>';
                        echo '<td class="align-middle" style="text-align:center;">'
                            .'<div class="btn-group">'
                            .'<button type="button" class="btn btn-dark  dropdown-toggle" data-toggle="dropdown">Műveletek</button>'
                            .'<div class="dropdown-menu">'
                              .'<a class="dropdown-item" href="tanulomegtekint.php?id='.$sor['tanulo_id'].
                         '"">Adatok megtekintése</a>'
                              .'<a class="dropdown-item" href="tanuloszerkeszt.php?id='.$sor['tanulo_id'].'">Adatok szerkesztése</a>'
                            .'</div>'
                        .'</div>'
                        . '</td>';
                    }else{
                    echo '<td class="align-middle" style="text-align:center;"><a href="tanulomegtekint.php?id='.$sor['tanulo_id'].
                         '"><input type="button" class="btn btn-dark" value="Adatok"></a></td>';
                    }
                echo '</tr>';  

            }
                echo '</tbody></table>';

        ?>
                <div class="form-group row">
                    <div class="col-1" style="text-align: center;">
                    <?php
                        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                            echo '<button id="torol" name="torol" type="submit" class="btn btn-dark" >Kijelöltek törlése</button>';
                        }else{

                            echo '<button type="submit" id="expsubmit" name="expsubmit" class="btn btn-dark" placeholder="Exportálás Excelbe" >Exportálás Excelbe</button>';
                        }
                    ?>
                </div>
            </div>        
            <!-- Lapozólinkek -->
            <div style="width:100%;">   
                <ul class="pagination justify-content-center">
                    <?php
                    if(isset($elozooldal)){
                        echo '<li class="page-item"><a href="tanuloklistaz.php?oldal='.$elozooldal.'&ssz='.$t_sorszam.'" class="page-link">Előző</a></li>';
                    }else{
                        echo '<li class="page-item disabled"><a href="tanuloklistaz.php?oldal=#&ssz='.$t_sorszam.'" class="page-link">Előző</a></li>';
                    }
                    for($oldal=1; $oldal<=$oldalakszama;$oldal++){
                    ?>    
                    <li class="page-item">
                        <?php
                        echo '<a href="tanuloklistaz.php?oldal='.$oldal.'&ssz='.$t_sorszam.'" class="page-link">'.$oldal.'</a> ';
                        ?>
                    </li>
                    <?php
                    }
                    if(isset($utolsooldal)){
                        echo '<li class="page-item"><a href="tanuloklistaz.php?oldal='.$utolsooldal.'&ssz='.$t_sorszam.'" class="page-link">Köv.</a></li>';
                    }else{
                        echo '<li class="page-item disabled"><a href="tanuloklistaz.php?oldal=#&ssz='.$t_sorszam.'" class="page-link">Köv.</a></li>';
                    }
                    ?>   
                    </ul>
                </div>
            </form>
        </div>
    <?php   
        mysqli_close($dbkapcs);
    }
}else{
    $uzenetcim = "Hibaüzenet";
    $uzenet .= "Nincs jogosultsága az oldal megtekintéséhez!<br />";
?>
    <script>
            $(document).ready(function(){
            $("#visszajelzes").modal('show');});
            setTimeout("location.href='kezdolap.php'",2000);
    </script>
<?php
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
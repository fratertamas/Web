<?php
require_once('dbkapcsolat.php');
  //Munkamenet indítása
  require_once('munkamenetinditasa.php');
    $oldalcime = 'Kezdőlap';
    require_once('header.php');
    $uzenetcim = "";
    $uzenet = "";
?>
<?php
    if (!isset($_SESSION['felhasznalo_id'])) {
        $uzenetcim = "Hibaüzenet";
        $uzenet .= "Kérem jelentkezzen be a <a href=\"index.php\" style=\"color:blue;font-weight: bold;\">bejelentkezés</a> oldalon<br />";
    ?>
        <script>
            $(document).ready(function(){
            $("#visszajelzes").modal('show');});
        </script>
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
    exit();
  }
  $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                    or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
  $dbkapcs->query("SET NAMES utf8;");
$query2 = "SELECT beosztas_nev FROM felhasznalo, beosztas WHERE felhasznalo.f_beosztas = beosztas.beosztas_id AND felhasznalo.felhasznalo_id = '".$_SESSION['felhasznalo_id']."'";
                    $data2 = mysqli_query($dbkapcs, $query2);
                    if (mysqli_num_rows($data2) == 1){
                        $sor2 = mysqli_fetch_array($data2);
                        $_SESSION['beosztasnev'] = $sor2['beosztas_nev'];
                    }
                    
  // Menüsor megjelenítése
  require_once('menu.php');
  
  //Funkciók listázása (menüpontok bővebben)
  echo '<div style="width:80%; margin:auto;">';
    $query = 'SELECT * FROM felhasznalo WHERE felhasznalo_id = "'.$_SESSION['felhasznalo_id'].'";';
    $data = mysqli_query($dbkapcs, $query);
    $sor = mysqli_fetch_array($data);
    echo '<h5>'.$sor['f_vezeteknev'].' '.$sor['f_keresztnev']. ' ('.$_SESSION['felhasznalonev'].')</h5><br />';
    ?>
    <div class="list-group">
        <span class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1" style="text-align:center;">Az óvodai belső tanulói adatnyilvántartó rendszer használata közben a következőkre jogosult</h5>  
            </div>
        </span>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Kezdőlap</h6>
            </div>
            <div style="margin-left:15px;">
                <small class="text-muted" >Egy rövid áttekintést ad a felületen használható menüpontokról és funkciókról.
                </small>
            </div>
       </span>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1" style="color:black;">Saját adatok</h6>
        </div>
            <p class="mb-0" style="color:#06104C;padding-left:15px;">Adatok megtekintése</p>
            <div style="margin-left:15px;">
                <small class="text-muted">Saját adatok megtekintése, milyen felhasználói adatok vannak tárolva.</small>
            </div>
            <p class="mb-0" style="color:#06104C;padding-left:15px; margin-top: 5px;">Jelszó módosítása</p>
            <div style="margin-left:15px;">
                <small class="text-muted">Belépési jelszó megváltoztatása.</small>
            </div>
      </span>
    <?php
    //intézményvezető esetén:
    if($_SESSION['beosztasnev'] == "intézményvezető"){
    ?>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Felhasználók</h6>
            </div>
            <p class="mb-0" style="color:#06104C;padding-left:15px;">Felhasználók kezelése</p>
            <div style="margin-left:15px;">
                <small class="text-muted" >Egy táblázatban megjelennek a felhasználók adatai.
                    Lehetősége van a felhasználónév előtt található kiválasztó négyzetet használva az oldal alján található gomb segítségével a kiválasztott felhasználót törölni.
                    Továbbá a "Műveletek" gomb használatával szerkesztheti a felhasználó adatait, illetve módosíthatja a belépési jelszavát.
                </small>
            </div>        
            <p class="mb-0" style="color:#06104C;padding-left:15px; margin-top: 5px;">Felhasználó hozzáadása</p>
            <div style="margin-left:15px;">
                <small class="text-muted">Segítségével felviheti a rendszerbe egy új felhasználó adatait.</small>
            </div>
        </span> 
<?php
    }
    if($_SESSION['beosztasnev'] == "intézményvezető helyettes"){
    ?>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Felhasználók</h6>
            </div>
            
            <div style="margin-left:15px;">
                <small class="text-muted" >Egy táblázatban megjelennek a felhasználók adatai. 
                    Továbbá az "Adatok módosítása" gombra kattintást követően szerkesztheti az adott felhasználó adatait. 
                     
                </small>
            </div>
       </span>
<?php
    }
    //Intézményvezető, vezető helyettes és óvodatitkár esetén
    if(($_SESSION['beosztasnev'] == "intézményvezető") 
    || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
    || ($_SESSION['beosztasnev'] == "óvodatitkár")){
?>    
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Tanulók</h6>
            </div>
            <p class="mb-0" style="color:#06104C;padding-left:15px;">Tanulók listázása</p>
            <div style="margin-left:15px;">
                <small class="text-muted" >Az adatbázisban szereplő tanulók alapadatai jelennek meg.
                    Lehetőség van a "Műveletek" gomb megnyomása hatására megjelenő menüpontok segítségével egy-egy tanuló adatainak a részletes megtekintésére, továbbá szerkesztésére.
                    A kiválasztó négyzet használatával pedig az adott oldalon megjelölt tanulók törlésére.<br />
                    Amennyiben szűrési feltételek kerülnek a találatok szűkítése végett beállításra a találati lista egy oldalon jelenik meg, ahol hasonlóan a szűrés nélküli nézethez lehet
                    a tanuló adatait részletesen megtekinteni, illetve szerkesztheti a "Műveletek" gomb használatával. Továbbá a kiválasztó jelölő négyzet segítségével kiválasztott tanulókat törölni.
                </small>
            </div>
             
            <p class="mb-0" style="color:#06104C;padding-left:15px; margin-top: 5px;">Új tanuló adatainak felvitele</p>
            <div style="margin-left:15px;">
                <small class="text-muted">A funkció használatával rögzíthető egy új tanuló adatai</small>
            </div>
            <p class="mb-0" style="color:#06104C;padding-left:15px; margin-top: 5px;">Exportálás</p>
            <div style="margin-left:15px;">
                <small class="text-muted">Használatával a tanulók teljes adatbázisban tárolt listája exportálásra kerül, amennyiben
                nem adunk meg dátumot akkor az aktuális dátumot veszi alapul a rendszer, más esetben pedig azt vizsgálja, hogy a megadott dátumkor, mely
                tanulók voltak az intézménnyel jogviszonyban.
                <br /><span style="color:red;">Az <strong>Exportálás</strong> funkció csak Mozilla Firefox böngészővel működik!</span>
                </small>
                
            </div>
       </span>
<?php    
    }
    //Csak pedagógusoknak megjelenő
    if($_SESSION['beosztasnev'] == "óvodapedagógus"){
?>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Tanulói adatok</h6>
            </div>
            
            <div style="margin-left:15px;">
                <small class="text-muted" >Használatával megtekintheti a csoportjába tartozó tanulók alapadatait, egy tanuló részletes adatainak megtekintéséhez az Adatok gombra kattintással van lehetősége. 
                    Továbbá az Exportálás Excelbe gombra kattintás hatására lementheti a tanulók részletesebb adathalmazát. 
                    <br /><span style="color:red;">Az <strong>Exportálás Excelbe</strong> funkció csak Mozilla Firefox böngészővel működik!</span> 
                </small>
            </div>
       </span>
<?php
    }
?>
        <span class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1" style="color:black;">Kijelentkezés</h6>
            </div>
            
            <div style="margin-left:15px;">
                <small class="text-muted" >A menüpont használatával kijelentkezik a rendszerből, újbóli használathoz ismételten bejelentkezés szükségeltetik.
                </small>
            </div>
       </span>
        
        
        
    </div>

    <?php          

    
    
    
    
  echo '</div>';
?>
 
<?php
  // lábléc beszúrása
  require_once('footer.php');
?>
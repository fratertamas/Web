<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Felhasználók kezelése';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    
?>
<?php
if(isset($_SESSION['beosztasnev']) && (($_SESSION['beosztasnev'] == "intézményvezető") ||
        $_SESSION['beosztasnev'] == "intézményvezető helyettes")){
$dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
           or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
$dbkapcs->query("SET NAMES utf8;");?>
<?php
    if (isset($_POST['submit']) && isset($_POST['ftorol'])){
        foreach ($_POST['ftorol'] as $torlendo_id){
            $query = "DELETE FROM felhasznalo WHERE felhasznalo_id = $torlendo_id";
            mysqli_query($dbkapcs, $query); 
        }
        $uzenetcim = "Felhasználó(k) törlés";
        $uzenet .= "A kiválasztott felhasználó(k) törlve lettek!<br />";
        ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
            </script><?php
    }
?>
    <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Felhasználók adatainak kezelése</h4><br />
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table class="table table-hover szegelymentes">
        <thead>
            <tr>
                <?php
                    if($_SESSION['beosztasnev'] == "intézményvezető"){
                        echo '<th></th>';
                    }
                ?>
                
                
                <th style="text-align: center;">Felhasználónév</th>
                <th style="text-align: center;">Vezetéknév</th>
                <th style="text-align: center;">Keresztnév</th>
                <th style="text-align: center;">Beosztás</th>
                <th style="text-align: center;">Csoport</th>
                <th></th>
            </tr>    
        </thead>
        <tbody>
        
    <?php    

        $query = "SELECT felhasznalo.felhasznalo_id as id, felhasznalonev, f_vezeteknev, f_keresztnev,beosztas_nev,csoport_nev  FROM felhasznalo_regadatok INNER JOIN felhasznalo ON felhasznalo.felhasznalo_id = felhasznalo_regadatok.felhasznalo_id INNER JOIN csoport ON felhasznalo.f_csoport = csoport.csoport_id INNER JOIN beosztas ON felhasznalo.f_beosztas = beosztas.beosztas_id ORDER BY f_vezeteknev ASC, f_keresztnev;";
        $data = mysqli_query($dbkapcs, $query);
        while ($sor = mysqli_fetch_array($data)) {     
              echo '<tr>';
                if($_SESSION['beosztasnev'] == "intézményvezető"){
                    echo '<td class="align-middle" style="text-align:center;">';
                            echo '<input type="checkbox"  name="ftorol[]" value="'.$sor['id'].'">';
                    echo '</td>';
                }
                echo '<td class="align-middle" style="text-align:center;">'.$sor['felhasznalonev'].'</td>';
                echo '<td class="align-middle" style="text-align:center;">'.$sor['f_vezeteknev'].'</td>';
                echo '<td class="align-middle" style="text-align:center;">'.$sor['f_keresztnev'].'</td>';
                echo '<td class="align-middle" style="text-align:center;">'.$sor['beosztas_nev'].'</td>';
                echo '<td class="align-middle" style="text-align:center;">'.$sor['csoport_nev'].'</td>';
                if($_SESSION['beosztasnev'] == "intézményvezető"){
                    echo '<td class="align-middle" style="text-align:center;">'
                            .'<div class="btn-group">'
                            .'<button type="button" class="btn btn-dark  dropdown-toggle" data-toggle="dropdown">Műveletek</button>'
                            .'<div class="dropdown-menu">'
                              .'<a class="dropdown-item" href="szerkesztfelhasznalo.php?id='.$sor['id'].
                         '"">Szerkeszt</a>'
                              .'<a class="dropdown-item" href="felhasznalojelszovalt.php?id='.$sor['id'].'">Jelszó módosítása</a>'
                            .'</div>'
                        .'</div>'
                            . '</td>';
                }else if($_SESSION['beosztasnev'] == "intézményvezető helyettes"){
                    echo '<td class="align-middle" style="text-align:center;"><a href="szerkesztfelhasznalo.php?id='.$sor['id'].
                         '"><input type="button" class="btn btn-dark" value="Adatok módosítása"></a></td>';
                }
                echo '</tr>';  

        }
            echo '</tbody></table>';
            mysqli_close($dbkapcs);
            
    
        if($_SESSION['beosztasnev'] == "intézményvezető"){
        ?>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button id="submit" name="submit" type="submit" class="btn btn-dark" >Kijelöltek törlése</button>
                </div>
            </div>
        <?php } ?>
    </form>
    </div>

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

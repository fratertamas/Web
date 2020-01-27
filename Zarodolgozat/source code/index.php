<?php
    require_once('dbkapcsolat.php');
    //Munkamenet elindítása
    session_start();
    //üres hibaüzenet
    $hibauzenet = "";
    $uzenetcim = "";
    $uzenet = "";
    //Ha a felhasználó nincs bejelentkezve, megpróbáljuk beléptetni
    if (!isset($_SESSION['felhasznalo_id'])) {
        if (isset($_POST['submit'])) {
            //Kapcsolódás az adatbázishoz
            $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                    or die('Hiba a MySQL szerverhez való kapcsolódáskor!');

            //A felhasználó által megadott bejelentkezési adatok
            $user_felhasznalonev = mysqli_real_escape_string($dbkapcs, trim($_POST['felhasznalonev']));   
            $user_jelszo = mysqli_real_escape_string($dbkapcs, trim($_POST['jelszo']));
            
          
            if (!empty($user_felhasznalonev) && !empty($user_jelszo)) {
                //Felhasználónév és jelszó vizsgálata az adatbázisban
                $hashelt=hash("sha512", $user_jelszo);
                $query = "SELECT felhasznalo_id, felhasznalonev FROM felhasznalo_regadatok WHERE felhasznalonev = '$user_felhasznalonev' AND jelszo = '$hashelt'";
                $data = mysqli_query($dbkapcs, $query);
                
                
                if (mysqli_num_rows($data) == 1) {
                    //A bejelentkezés OK, beállításra kerül a felhasznaloid és
                    //felhasználónév munkamenet változók (valamint sütik), majd
                    //átirányításra kerül a kezdőlapra
                    $sor = mysqli_fetch_array($data);
                    $_SESSION['felhasznalo_id'] = $sor['felhasznalo_id'];
                    $_SESSION['felhasznalonev'] = $sor['felhasznalonev'];
                    setcookie('felhasznalo_id', $sor['felhasznalo_id'], time() + (60 * 60 * 24 * 30));    // 30 nap múlva jár le
                    setcookie('felhasznalonev', $sor['felhasznalonev'], time() + (60 * 60 * 24 * 30));  // 30 nap múlva jár le                   
                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/kezdolap.php';
                    header('Location: ' . $home_url);
                    
                }else {
                    //Hibás felhasználónév vagy jelszó megadása
                    $hibauzenet = 'A belépéshez kérem adjon meg érvényes felhasználónév és jelszó párost!';
                }
            }else {
                //Hibás felhasználónév vagy jelszó megadása
                $hibauzenet = 'A belépéshez kérem adjon meg érvényes felhasználónév és jelszó párost!';
            }
        }
    }

    //Fejléc beszúrása és cím beállítása
    $oldalcime = 'Bejelentkezés';
    require_once('header.php');
    
    if (empty($_SESSION['felhasznalo_id'])) {
?>

 <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="egyszeru-bejelentkezesi-container">
            <h2>Bejelentkezés</h2>
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="text" name="felhasznalonev" class="form-control" placeholder="Felhasználónév" value="<?php if (!empty($user_felhasznalonev)) echo $user_felhasznalonev; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="password" name="jelszo" placeholder="Jelszó" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="submit" name="submit" class="btn btn-block btn-login" placeholder="Bejelentkezés" value="Bejelentkezés">
                    <div style="text-align: center; color:red;">
                        <?php echo $hibauzenet;?>
                    </div>
                </div>
            </div>

        </div>
</form>

<?php
  }
  else {
    // Sikeres bejelentkezés esetén, ha behozza az index oldalt
     $uzenetcim = "Információ";
     $uzenet .= 'Be van jelentkezve: ' . $_SESSION['felhasznalonev'] . ' néven.<br />'
             . 'Kattintson a <a href="kijelentkezes.php" style="color:blue;font-weight: bold;">Kijelentkezés (' . $_SESSION['felhasznalonev'] . ')</a> vagy a <a href="kezdolap.php" style="color:blue;font-weight: bold;">Kezdőlap betöltése</a> feliratok valamelyikére.';
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
     
  }
?>
</body>
</html>
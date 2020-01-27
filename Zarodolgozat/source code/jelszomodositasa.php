<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Jelszó módosítása';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    
if(isset($_SESSION['beosztasnev'])){
?>

<div>
<form id="jelszocsere" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="egyszeru-bejelentkezesi-container" style="margin:0 auto;">
            <h2>Jelszó megváltoztatása</h2>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="ujJelszo1">Új jelszó:</label>
                    <input type="password" id="ujJelszo1" placeholder="Jelszó" name="ujJelszo1" class="form-control" onkeydown="vizsgal(this,event);">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="ujJelszo2">Új jelszó megerősítése:</label>
                    <input type="password" id="ujJelszo2" name="ujJelszo2" placeholder="Jelszó" class="form-control">
                    <p style="text-align: center;" >
                        <span id='egyezes'></span>
                    </p>
                    <!--<input type="hidden" id="mehet" name="mehet" value="false">-->
                </div>
                <!--<span id='message'></span>-->
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button type="submit" id="submit" name="submit" class="btn btn-block btn-dark" placeholder="Jelszó megváltoztatása" disabled >Jelszó megváltoztatása</button>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12 form-group">
                    <h6 style="text-align: center;">Az új jelszó a következőket kell tartamazza:</h6>
                    <ul class="list-group">
                            <li id="betu" class="list-group-item ervenytelen">Legalább <strong>egy betűt</strong></li>
                            <li id="nagybetu" class="list-group-item ervenytelen">Legalább <strong>egy nagy betűt</strong></li>
                            <li id="szam" class="list-group-item ervenytelen">Legalább <strong>egy számot</strong></li>
                            <li id="hossz" class="list-group-item ervenytelen">Legalább <strong>8 karakterből</strong> kell álljon</li>
                    </ul>
                </div>
            </div>
    </div>
</form>
</div>
<script src="funkciok/jelszocsere.js"></script>
<?php
    if(isset($_POST['ujJelszo1']) && isset($_POST['ujJelszo2'])){
        $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                    or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
        $ujJelszo = mysqli_real_escape_string($dbkapcs, trim($_POST['ujJelszo1']));
        $hashelt=hash("sha512", $ujJelszo);
        $query = "UPDATE felhasznalo_regadatok SET jelszo = '$hashelt' WHERE felhasznalo_id = '".$_SESSION['felhasznalo_id']."';";

        if (mysqli_query($dbkapcs, $query)) {
            $uzenet = "A jelszó sikeresen módosításra került.";
?>
            <script>
            $(document).ready(function(){
            $("#visszajelzes").modal('show');});</script>
<?php
        }else {
            $uzenet = "Hiba a frissítés közben: " . mysqli_error($dbkapcs);
?>
            <script>
            $(document).ready(function(){
            $("#visszajelzes").modal('show');});</script>
<?php
        }
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
              <h4 class="modal-title" style="color:black;">Visszajelzés megváltoztatásáról</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal törzs -->
            <div class="modal-body" style="color: #06104c; text-align: center;">
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
    // lábléc beszúrása
    require_once('footer.php');
?>    

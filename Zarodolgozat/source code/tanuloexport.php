    <?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Tanulók adatainak exportálása';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    
if(isset($_SESSION['beosztasnev']) && (($_SESSION['beosztasnev'] == "intézményvezető") 
    || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
    || ($_SESSION['beosztasnev'] == "óvodatitkár"))){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");
 
    
?>    
 <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Tanulók adatainak exportálása</h4><br /><br />
    <div class="egyszeru-bejelentkezesi-container" style="margin:0 auto;">
        
        <form action="exportalasexcel.php" method="post">
            <div class="form-group row">
                <label for="szulido" class="col-4 col-form-label" style="text-align:center;">Dátum</label> 
                <div class="col-8">
                    <input id="expdatum" name="expdatum" class="form-control here" type="date" value="">
                </div>
            </div>
            <div style="text-align: center; font-style: italic;">Adja meg az exportálás dátumát, ha nem ad meg időpontot, akkor az aktuális dátumot veszi alapul a rendszer.</div>
            <div style="width:80%; text-align: center;margin: auto;">
                <button type="submit" id="expsubmit" name="expsubmit" class="btn btn-block btn-dark" placeholder="Exportálás Excelbe" >Exportálás Excelbe</button>
            </div>
        </form>        
    </div> 
        
</div>
<?php
        mysqli_close($dbkapcs);    
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
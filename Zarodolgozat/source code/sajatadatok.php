<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Saját adatok';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
if(isset($_SESSION['beosztasnev'])){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
                    or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");
    $query = "SELECT f_vezeteknev, f_keresztnev, csoport_nev FROM felhasznalo, csoport WHERE felhasznalo.f_csoport = csoport.csoport_id AND felhasznalo.felhasznalo_id = '".$_SESSION['felhasznalo_id'].";'";
        $data = mysqli_query($dbkapcs, $query);
        if (mysqli_num_rows($data) == 1){
            $sor = mysqli_fetch_array($data);
        }
        mysqli_close($dbkapcs);
?>
<div style="width: 80%; margin: auto;">
    <h4>Adataid:</h4>
    <table class="table table-hover szegelymentes" >
    <tbody>
      <tr>
        <td class="felkover">Felhasználónév:</td>
        <td><?php echo $_SESSION['felhasznalonev'] ?></td>
      </tr>
      <tr>
        <td>Vezetéknév:</td>
        <td><?php echo $sor['f_vezeteknev'] ?></td>
      </tr>
      <tr>
        <td>Keresztnév:</td>
        <td><?php echo $sor['f_keresztnev'] ?></td>
      </tr>
      <tr>
        <td>Beosztás:</td>
        <td><?php echo $_SESSION['beosztasnev']; ?></td>
      </tr>
      <tr>
        <td>Csoport:</td>
        <td><?php echo $sor['csoport_nev'] ?></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
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
  // lábléc beszúrása
  require_once('footer.php');
?>
<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Tanuló adatainak megtekintése';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    
if(isset($_SESSION['beosztasnev']) ){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");

    $query = "SELECT * FROM tanulo WHERE tanulo_id = '".$_GET['id']."';";
        $data = mysqli_query($dbkapcs,$query);
        if(mysqli_num_rows($data) == 1){
            $sor = mysqli_fetch_array($data);
        }
?>     
 <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;"><?php echo  $sor['t_nev_elotag'].' '.$sor['t_vnev'].' '.$sor['t_knev']; ?> adatainak megtekintése</h4><br />

    <form>
        <table style="width:100%; margin: auto;">
            <tr>
                <td style="vertical-align: top; margin: auto;">
                    <fieldset>
                        <legend>Alapadatok</legend>
                            <div class="form-group row">
                                <label for="oktazon" class="col-4 col-form-label">Oktatási azonosító</label> 
                                <div class="col-7">
                                    <input id="oktazon" name="oktazon" placeholder="Oktatási azonosító" class="form-control here" type="text" value="<?php echo $sor['t_oktatasi_azon'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tajszam" class="col-4 col-form-label">TAJ szám</label> 
                                <div class="col-7">
                                    <input id="tajszam" name="tajszam" class="form-control here" type="text" value="<?php echo $sor['t_tajszam'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="nevelotag" name="nevelotag" class="form-control here" type="text" value="<?php echo $sor['t_nev_elotag'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vnev" class="col-4 col-form-label">Vezetéknév</label> 
                                <div class="col-7">
                                    <input id="vnev" name="vnev" class="form-control here" type="text" value="<?php echo $sor['t_vnev'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="knev" class="col-4 col-form-label">Keresztnév</label> 
                                <div class="col-7">
                                    <input id="knev" name="knev" class="form-control here" type="text" value="<?php echo $sor['t_knev']; ?>" disabled>
                                </div>
                            </div>                   
                            <div class="form-group row">
                                <label for="allampolgarsag1" class="col-4 col-form-label">1. állampolgárság</label> 
                                <div class="col-7">
                                    <select id="allampolgarsag1" name="allampolgarsag1" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = '".$sor['t_allampolgarsag_1']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_allampolgarsag_1']; ?>" selected ><?php echo $sor2['allampolgarsag']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allampolgarsag2" class="col-4 col-form-label">2. állampolgárság</label> 
                                <div class="col-7">
                                    <select id="allampolgarsag2" name="allampolgarsag2" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = '".$sor['t_allampolgarsag_2']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_allampolgarsag_2']; ?>" selected ><?php echo $sor2['allampolgarsag']; ?></option>
                                    </select>
                                </div>
                            </div>
                            
                    </fieldset>
                    <fieldset>
                        <legend>Születési alapadatok</legend>
                            <div class="form-group row">
                                <label for="szulorszag" class="col-4 col-form-label">Születési ország</label> 
                                <div class="col-7">
                                    <select id="szulorszag" name="szulorszag" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM orszag WHERE orszag_id = '".$sor['t_szul_orszag']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_szul_orszag']; ?>" selected ><?php echo $sor2['orszag_nev']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="szulhely" class="col-4 col-form-label">Születési hely</label> 
                                <div class="col-7">
                                    <input id="szulhely" name="szulhely" placeholder="Születési hely" class="form-control here" type="text" value="<?php echo $sor['t_szul_hely']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="szulido" class="col-4 col-form-label">Születési idő</label> 
                                <div class="col-5">
                                    <input id="szulido" name="szulido" class="form-control here" type="date" value="<?php echo $sor['t_szul_datum']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gyereknem" class="col-4 col-form-label">Nem</label> 
                                <div class="col-3">
                                    <input id="gyereknem" name="gyerek" class="form-control here" type="text" value="<?php if($sor['t_neme'] == 0){echo "Nő";}else{echo "Férfi";} ?>" disabled>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesanya adatai</legend>
                            <div class="form-group row">
                                <label for="anyanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="anyanevelotag" name="anyanevelotag" class="form-control here" type="text" value="<?php echo $sor['t_anya_nev_elotag']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyanev" class="col-4 col-form-label">Édesanya neve</label> 
                                <div class="col-7">
                                    <input id="anyanev" name="anyanev" class="form-control here" type="text" value="<?php echo $sor['t_anya_nev']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyatel" class="col-4 col-form-label">Édesanya telefonszám</label> 
                                <div class="col-7">
                                    <input id="anyatel" name="anyatel" class="form-control here" type="text" value="<?php echo $sor['t_anya_telszam']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyaemail" class="col-4 col-form-label">Édesanya e-mail</label> 
                                <div class="col-7">
                                    <input id="anyaemail" name="anyaemail" class="form-control here" type="text" value="<?php echo $sor['t_anya_email']; ?>" disabled >
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesapa adatai</legend>
                            <div class="form-group row">
                                <label for="apanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="apanevelotag" name="apanevelotag" class="form-control here" type="text" value="<?php echo $sor['t_apa_nev_elotag']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apanev" class="col-4 col-form-label">Édesapa neve</label> 
                                <div class="col-7">
                                    <input id="apanev" name="apanev" class="form-control here" type="text" value="<?php echo $sor['t_apa_nev']; ?>"disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apatel" class="col-4 col-form-label">Édesapa telefonszám</label> 
                                <div class="col-7">
                                    <input id="apatel" name="apatel" class="form-control here" type="text" value="<?php echo $sor['t_apa_telszam']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apaemail" class="col-4 col-form-label">Édesapa e-mail</label> 
                                <div class="col-7">
                                    <input id="apaemail" name="apaemail" class="form-control here" type="text" value="<?php echo $sor['t_apa_email']; ?>" disabled>
                                </div>
                            </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Jogviszony adatok</legend>
                            <div class="form-group row">
                                <label for="jogvkezdete" class="col-4 col-form-label">Jogviszony kezdete</label> 
                                <div class="col-5">
                                    <input id="jogvkezdete" name="jogvkezdete" class="form-control here" type="date" value="<?php echo $sor['t_jogviszony_kezdete']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jogvvege" class="col-4 col-form-label">Jogviszony vége</label> 
                                <div class="col-5">
                                    <input id="jogvvege" name="jogvvege" class="form-control here" type="date" value="<?php echo $sor['t_jogviszony_vege']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tankotelezett" class="col-4 col-form-label">Tankötelezett</label> 
                                <div class="col-3">
                                    <input id="tankotelezett" name="tankotelezett" class="form-control here" type="text" value="<?php if($sor['t_tankoteles_koru'] == 0){echo "Nem";}else{echo "Igen";}?>" disabled>
                                </div>
                            </div>                     
                    </fieldset>                  
                </td>
                <td style="vertical-align: top; margin: auto;">
                    <?php
                        if(($_SESSION['beosztasnev'] == "intézményvezető") 
                        || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                        || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                    ?>
                    <fieldset>
                        <legend>Lakóhely típusa</legend>
                        <div class="form-group row">
                                <label for="lakhelytip" class="col-4 col-form-label">Lakóhely típusa</label> 
                                <div class="col-7">
                                    <select id="lakhelytip" name="lakhelytip" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM lakhely_tipus WHERE lakhely_tip_id = '".$sor['t_lakhely_tip']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_lakhely_tip']; ?>" selected ><?php echo $sor2['lakhely_tip']; ?></option>
                                    </select>
                                </div>
                            </div>
                    </fieldset> 
                        <?php }?>
                    <fieldset>
                        <legend>Állandó lakcím</legend>
                            <div class="form-group row">
                                <label for="allandocimirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-3">
                                    <?php
                                        $query = "SELECT * FROM telepules WHERE telepules_id = '".$sor['t_allando_telepules_kod']."';";
                                        $data = mysqli_query($dbkapcs, $query);
                                        $sor2 = mysqli_fetch_array($data);
                                    ?>
                                    <input id="allandocimirsz" name="allandocimirsz" class="form-control here" type="text" value="<?php echo $sor2['iranyitoszam']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimtelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="allandocimtelepules" name="allandocimtelepules" class="form-control here" type="text" value="<?php echo $sor2['telepulesnev']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztneve" name="allandocimkoztneve" class="form-control here" type="text" value="<?php echo $sor['t_allando_lc_kozterulet_neve']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                    <select id="allandocimkoztjellege" name="allandocimkoztjellege" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = '".$sor['t_allando_lc_kozterulet_jellege']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_allando_lc_kozterulet_jellege']; ?>" selected ><?php echo $sor2['kozterulet_jellege']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztegyeb" name="allandocimkoztegyeb" class="form-control here" type="text" value="<?php echo $sor['t_allando_lc_egyeb']; ?>" disabled>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Tartózkodási hely</legend>
                            <div class="form-group row">
                                <label for="tarthelyirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-3">
                                    <?php
                                        $query = "SELECT * FROM telepules WHERE telepules_id = '".$sor['t_tarthely_telepules_kod']."';";
                                        $data = mysqli_query($dbkapcs, $query);
                                        $sor2 = mysqli_fetch_array($data);
                                    ?>
                                    <input id="tarthelyirsz" name="tarthelyirsz" class="form-control here" type="text" value="<?php echo $sor2['iranyitoszam']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelytelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="tarthelytelepules" name="tarthelytelepules" class="form-control here" type="text" value="<?php echo $sor2['telepulesnev']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztneve" name="tarthelykoztneve" class="form-control here" type="text" value="<?php echo $sor['t_tarthely_kozterulet_neve'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                    <select id="tarthelykoztjellege" name="tarthelykoztjellege" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = '".$sor['t_tarthely_kozterulet_jellege']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_tarthely_kozterulet_jellege']; ?>" selected ><?php echo $sor2['kozterulet_jellege']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztegyeb" name="tarthelykoztegyeb" class="form-control here" type="text" value="<?php echo $sor['t_tarthely_kozterulet_egyeb']; ?>" disabled>
                                </div>
                            </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Egyéb adatok</legend>
                            
                        
                            <div class="form-group row">
                                <label for="sni" class="col-4 col-form-label">Sajátos nevelési igény</label> 
                                <div class="col-3">
                                    <input id="sni" name="sni" class="form-control here" type="text" value="<?php if($sor['t_sni'] == 0){echo "Nem";}else{echo "Igen";}?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="btmn" class="col-4 col-form-label">Beilleszkedési, tanulási, magatartási nehézség</label> 
                                <div class="col-3">
                                    <input id="btmn" name="btmn" class="form-control here" type="text" value="<?php if($sor['t_btmn'] == 0){echo "Nem";}else{echo "Igen";}?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hh" class="col-4 col-form-label">Hátrányos helyzet</label> 
                                <div class="col-3">
                                    <input id="hh" name="hh" class="form-control here" type="text" value="<?php if($sor['t_hh'] == 0){echo "Nem";}else{echo "Igen";}?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hhh" class="col-4 col-form-label">Halmozottan hátrányos helyzet</label> 
                                <div class="col-3">
                                    <input id="hhh" name="hhh" class="form-control here" type="text" value="<?php if($sor['t_hhh'] == 0){echo "Nem";}else{echo "Igen";}?>" disabled>
                                </div>
                            </div> 
                        <?php
                            if(($_SESSION['beosztasnev'] == "intézményvezető") 
                            || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                            || ($_SESSION['beosztasnev'] == "óvodatitkár")){
                        ?>
                            <div class="form-group row">
                                <label for="felekezet" class="col-4 col-form-label">Felekezet</label> 
                                <div class="col-7">
                                    <select id="felekezet" name="felekezet" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM felekezet WHERE felekezet_id = '".$sor['t_felekezet']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_felekezet']; ?>" selected ><?php echo $sor2['felekezet_nev']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="csoport" class="col-4 col-form-label">Csoport</label> 
                                <div class="col-7">
                                    <select id="csoport" name="csoport" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM csoport WHERE csoport_id = '".$sor['t_csoport']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_csoport']; ?>" selected ><?php echo $sor2['csoport_nev']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="etkat" class="col-4 col-form-label">Étkezési kategória</label> 
                                <div class="col-7">
                                    <select id="etkat" name="etkat" class="custom-select" disabled>
                                        <?php
                                            $query = "SELECT * FROM etkezesi_kategoria WHERE etkezesi_kategoria_id = '".$sor['t_etkezesi_kategoria']."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        ?>
                                        <option value="<?php echo $sor['t_etkezesi_kategoria']; ?>" selected ><?php echo $sor2['etkezesi_kategoria_nev']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label for="megjegyzes" class="col-4 col-form-label">Megjegyzés</label> 
                                <div class="col-7">
                                    <textarea class="form-control" rows="2" id="megjegyzes" name="megjegyzes" disabled><?php echo $sor['t_megjegyzes']; ?></textarea>
                                </div>
                            </div>
                    </fieldset>
                </td>
            </tr>
        </table>
    </form>
 
 
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
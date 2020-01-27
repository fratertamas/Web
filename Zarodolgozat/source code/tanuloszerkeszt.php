<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Tanuló adatainak szerkesztése';
    require_once('header.php');
    require_once('menu.php');
    $uzenetcim = "";
    $uzenet = "";
    $hiba = false;
    
if(isset($_SESSION['beosztasnev']) && (($_SESSION['beosztasnev'] == "intézményvezető") || 
        ($_SESSION['beosztasnev'] == "óvodatitkár") || ($_SESSION['beosztasnev'] == "intézményvezető helyettes"))){
    $dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");
    $id = mysqli_real_escape_string($dbkapcs, trim($_GET['id']));
    
    $query = "SELECT * FROM tanulo WHERE tanulo_id = '".$id."';";
        $data = mysqli_query($dbkapcs,$query);
        if(mysqli_num_rows($data) == 1){
            $sor = mysqli_fetch_array($data);
        }
        
      if (isset($_POST['oktazon']) && isset($_POST['tajszam']) && isset($_POST['nevelotag']) &&
          isset($_POST['vnev']) && isset($_POST['knev']) && isset($_POST['allampolgarsag1']) &&
          isset($_POST['allampolgarsag2']) && isset($_POST['szulorszag']) && isset($_POST['szulhely']) && 
          isset($_POST['szulido']) && isset($_POST['gyereknem']) &&
          isset($_POST['anyanevelotag']) && isset($_POST['anyanev']) && isset($_POST['anyatel']) &&
          isset($_POST['anyaemail']) && 
          isset($_POST['apanevelotag']) && isset($_POST['apanev']) &&isset($_POST['apatel']) && 
          isset($_POST['apaemail']) 
          && isset($_POST['jogvkezdete']) && isset($_POST['jogvvege']) 
          && isset($_POST['allandocimirsz']) && isset($_POST['allandocimtelepules']) 
          && isset($_POST['allandocimkoztneve']) && isset($_POST['allandocimkoztjellege'])
          && isset($_POST['allandocimkoztegyeb'])
          && isset($_POST['tarthelyirsz']) && isset($_POST['tarthelytelepules']) 
          && isset($_POST['tarthelykoztneve']) && isset($_POST['tarthelykoztjellege'])
          && isset($_POST['tarthelykoztegyeb'])
          && isset($_POST['lakhelytip']) && isset($_POST['felekezet']) && isset($_POST['csoport'])
          && isset($_POST['etkat']) && isset($_POST['megjegyzes'])

          ){
          
            echo '<div style="width:80%; margin:auto;">'; //tesztmező kezdete
            $oktazon = mysqli_real_escape_string($dbkapcs, trim($_POST['oktazon']));
            $tajszam = mysqli_real_escape_string($dbkapcs, trim($_POST['tajszam']));
            $nevelotag = mysqli_real_escape_string($dbkapcs, trim($_POST['nevelotag']));
            $vezeteknev = mysqli_real_escape_string($dbkapcs, trim($_POST['vnev']));
            $keresztnev = mysqli_real_escape_string($dbkapcs, trim($_POST['knev']));
            $allampolgarsag1 = mysqli_real_escape_string($dbkapcs, trim($_POST['allampolgarsag1']));
            $allampolgarsag2 = mysqli_real_escape_string($dbkapcs, trim($_POST['allampolgarsag2']));
            $szulorszag = mysqli_real_escape_string($dbkapcs, trim($_POST['szulorszag']));
            $szulhely = mysqli_real_escape_string($dbkapcs, trim($_POST['szulhely']));
            $szulido = mysqli_real_escape_string($dbkapcs, trim($_POST['szulido']));
            $gyereknem = mysqli_real_escape_string($dbkapcs, trim($_POST['gyereknem']));
            
            $anyanevelotag = mysqli_real_escape_string($dbkapcs, trim($_POST['anyanevelotag']));
            $anyanev = mysqli_real_escape_string($dbkapcs, trim($_POST['anyanev']));
            $anyatel = mysqli_real_escape_string($dbkapcs, trim($_POST['anyatel']));
            $anyaemail = mysqli_real_escape_string($dbkapcs, trim($_POST['anyaemail']));
            $apanevelotag = mysqli_real_escape_string($dbkapcs, trim($_POST['apanevelotag']));
            $apanev = mysqli_real_escape_string($dbkapcs, trim($_POST['apanev']));
            $apatel = mysqli_real_escape_string($dbkapcs, trim($_POST['apatel']));
            $apaemail = mysqli_real_escape_string($dbkapcs, trim($_POST['apaemail']));
            $jogvkezdete = mysqli_real_escape_string($dbkapcs, trim($_POST['jogvkezdete']));
            $jogvvege = mysqli_real_escape_string($dbkapcs, trim($_POST['jogvvege']));
            
            $allandocimirsz = mysqli_real_escape_string($dbkapcs, trim($_POST['allandocimirsz']));
            $allandocimtelepules = mysqli_real_escape_string($dbkapcs, trim($_POST['allandocimtelepules']));
            $allandocimkoztneve = mysqli_real_escape_string($dbkapcs, trim($_POST['allandocimkoztneve']));
            $allandocimkoztjellege = mysqli_real_escape_string($dbkapcs, trim($_POST['allandocimkoztjellege']));
            $allandocimkoztegyeb = mysqli_real_escape_string($dbkapcs, trim($_POST['allandocimkoztegyeb']));
            $tarthelyirsz = mysqli_real_escape_string($dbkapcs, trim($_POST['tarthelyirsz']));
            $tarthelytelepules = mysqli_real_escape_string($dbkapcs, trim($_POST['tarthelytelepules']));
            $tarthelykoztneve = mysqli_real_escape_string($dbkapcs, trim($_POST['tarthelykoztneve']));
            $tarthelykoztjellege = mysqli_real_escape_string($dbkapcs, trim($_POST['tarthelykoztjellege']));
            $tarthelykoztegyeb = mysqli_real_escape_string($dbkapcs, trim($_POST['tarthelykoztegyeb']));
            
            $lakhelytip = mysqli_real_escape_string($dbkapcs, trim($_POST['lakhelytip']));
            $felekezet = mysqli_real_escape_string($dbkapcs, trim($_POST['felekezet']));
            $csoport = mysqli_real_escape_string($dbkapcs, trim($_POST['csoport']));
            $etkat = mysqli_real_escape_string($dbkapcs, trim($_POST['etkat']));
            $megjegyzes = mysqli_real_escape_string($dbkapcs, trim($_POST['megjegyzes']));
            
 
            //Oktatási azonosítószám ellenőrzése
            if(!is_numeric($oktazon) || ($oktazon[0] != 7) || (strlen($oktazon) != 11)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "Az oktatási azonosítónak 11 darab számjegyből kell állnia, amely számsor 7-essel kezdődik!<br />";
            }else{
                $query3 = "SELECT tanulo_id, t_oktatasi_azon FROM tanulo;";
                $data3 = mysqli_query($dbkapcs, $query3);
                while ($sor3 = mysqli_fetch_array($data3)){
                    if(($id != $sor3['tanulo_id']) && ($sor3['t_oktatasi_azon'] == $oktazon)){
                        $hiba = true;
                        $uzenetcim = "Hibaüzenet";
                        $uzenet .= "A megadott oktatási azonosító szám már szerepel az adatbázisban!<br />";
                    }
                }
            }
            
            //Tajszám ellenőrzése
            if(empty($tajszam) && (($allampolgarsag1 != 112) || $allampolgarsag2 != 112)){
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "<span style=\"color:orange;\">Csak magyar állampolgársággal nem rendelkező esetében lehet elhagyni a TAJ-számot!</span><br />";
            }else{
                if(!is_numeric($tajszam) || (strlen($tajszam) != 9)){
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "A társadalombiztosítási azonosító jelnek 9 db számjegyből kell állnia!<br />";
                }else{
                    $osszegtaj = 0;
                    for ($i=0;$i<8;$i=$i+2){
                        $osszegtaj += ($tajszam[$i]*3)+($tajszam[$i+1]*7);
                    }
                    if($tajszam[8] != ($osszegtaj % 10)){
                        $hiba = true;
                        $uzenetcim = "Hibaüzenet";
                        $uzenet .= "Kérem ellenőrizze, hogy helyesen adta-e meg a TAJ-szám számjegyeit!<br />";
                    }else{
                        $query3 = "SELECT tanulo_id, t_tajszam FROM tanulo;";
                        $data3 = mysqli_query($dbkapcs, $query3);
                        while ($sor3 = mysqli_fetch_array($data3)){
                            if (($id != $sor3['tanulo_id']) && ($tajszam == $sor3['t_tajszam'])) {
                                $hiba = true;
                            $uzenetcim = "Hibaüzenet";
                            $uzenet .= "A megadott TAJ-szám már szerepel az adatbázisban!<br />";
                            }
                        }
                    }
                }
            }
            
            //Vezetéknév ellenőrzése
            if(empty($vezeteknev)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "Nem adta meg a tanuló vezetéknevét!<br />";
            }
            //Keresztnév ellenőrzése
            if(empty($keresztnev)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "Nem adta meg a tanuló keresztnevét!<br />";
            }
            //Állampolgárság ellenőrzése
            if($allampolgarsag1 == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló 1. állampolgárság kiválasztása kötelező!<br />";
            }
            //Születési ország ellenőrzése
            if($szulorszag == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló születési országának kiválasztása kötelező!<br />";
            }            
            //Születési hely ellenőrzése
            if(empty($szulhely)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló születési helyének megadása kötelező!<br />";
            }
            //Születési idő ellenőrzése
            if(empty($szulido)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló születési idejének megadása kötelező!<br />";
            }else{
                if($szulido>=date("Y-m-d")){
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "A tanuló születési ideje nem lehet jövőbeli dátum!<br />";
                }
            }
            //Anya nevének ellenőrzése
            if(empty($anyanev)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló édesanyjának a nevének megadása kötelező!<br />";
            }
            //Telefonszám ellenőrzéshez függvény
            function telefonszamellenorzes($telefonszam){
                //Telefonszámból nem számjegy karakterek eltávolítása
                $tisztitotttelszam = preg_replace('/[^0-9]/', '', $telefonszam);
                
                ////Tisztítás után, csak számjegyeket tartalmazó telefonszámnál
                //preg_match-el egyezés vizsgálata, hogy megfelel-e egy magyar telefonszámnak.
                //
                //Reguláris kifejezés felépítése:
                //^([03]6) - telefonszám kezdetének (minta kezdetén), országhívó rész ellenőrzése 06 vagy 36 
                //(20|30|31|70|1) - Mobil szolgáltatók körzetszámai és Budapesti körzetszám ellenőrzése
                //(\d{7}) - A körzetszám után ebben az esetben 7db számjegy kell jöjjön a minta végén ($-jel miatt)
                //Vidéki körzetszámok
                //2-essel kezdődőek: 2[2-9]; 3-assal kezdődőek: 3[2-7]; 4-essel kezdődőek: 4[024-9]
                //5-össel kezdődőek: 5[234679]; 6-ossal kezdődőek: 6[23689]; 7-essel kezdődőek: 7[2-9]
                //8-assal kezdődőek: 8[02-9]; 9-essel kezdődőek: 9[92-69]
                //(\d{6}) - a nem mobilos és bp-i körzetek után pedig 6 db decimális számjegy kell álljon a minta végén ($-jel miatt)
                preg_match('/^([03]6)((20|30|31|70|1)(\d{7})|(2[2-9]|3[2-7]|4[024-9]|5[234679]|6[23689]|7[2-9]|8[02-9]|9[92-69])(\d{6}))$/', $tisztitotttelszam, $telefonegyezes);
                
                if($telefonegyezes == true){
                    $formazotttelefonszam=($telefonegyezes[1] == 36)?"06":$telefonegyezes[1];
                    $formazotttelefonszam.=$telefonegyezes[3].$telefonegyezes[4];
                    
                    return array(true,$formazotttelefonszam);                    
                }else{
                    return array(false,"");
                }
            }
            //Anya telefonszám ellenőrzés
            if(!empty($anyatel) && (telefonszamellenorzes($anyatel)[0] == true)){
                
            }else if(!empty($anyatel)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A megadott telefonszám, nem tűnik magyar telefonszámnak! Kérem ellenőrizze, hogy helyesen adta-e meg a tanuló édesanyjának a telefonszámát!<br />";
            }
            //Anya e-mail címének ellenőrzése
            if(!empty($anyaemail)){
                //Minden nem oda való karakter eltávolítása a címből
                $anyaemail = filter_var($anyaemail, FILTER_SANITIZE_EMAIL);

                //E-mail cím ellenőrzése
                if (!filter_var($anyaemail, FILTER_VALIDATE_EMAIL)) {
                   $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "A megadott e-mail cím nem tűnik formailag helyesnek! Kérem ellenőrizze, hogy helyesen adta-e meg a tanuló édesanyjának e-mail címét!<br />";

                } else {
                }
            }
            
            //Apa telefonszám ellenőrzés
            if(!empty($apatel) && (telefonszamellenorzes($apatel)[0] == true)){
                
            }else if(!empty($apatel)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A megadott telefonszám, nem tűnik magyar telefonszámnak! Kérem ellenőrizze, hogy helyesen adta-e meg a tanuló édesapjának a telefonszámát!<br />";
            }
            //Apa e-mail címének ellenőrzése
            if(!empty($apaemail)){
                //Minden nem oda való karakter eltávolítása a címből
                $apaemail = filter_var($apaemail, FILTER_SANITIZE_EMAIL);

                //E-mail cím ellenőrzése
                if (!filter_var($apaemail, FILTER_VALIDATE_EMAIL)) {
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "A megadott e-mail cím nem tűnik formailag helyesnek! Kérem ellenőrizze, hogy helyesen adta-e meg a tanuló édesapjának e-mail címét!<br />";

                } else {
                }
            }
            
            //Jogviszony kezdetének ellenőrzése
            if(empty($jogvkezdete)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló jogviszonyának a kezdetének megadása kötelező!<br />";
            }else if($jogvkezdete<=$szulido){
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "A tanuló jogviszonyának kezdete nem lehet korábbi, mint a születési ideje!<br />";
            }
            //Jogviszony végének ellenőrzése
            if(!empty($jogvvege) && ($jogvvege<=$jogvkezdete)){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló jogviszonyának vége nem lehet korábbi, mint a jogviszony kezdetének ideje!<br />";
            }
            //Tankötelezettség ellenőrzése
            $tankotelezett = 0;
            if(isset($_POST['checkboxlista'])){                
                foreach ($_POST['checkboxlista'] as $lista){
                    if($lista == "tankotelezett"){
                        $tankotelezett = 1;
                    }
                }
            }
            //Lakhely típusának ellenőrzése
            if($lakhelytip == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A tanuló lakóhelyének típusának kiválasztása kötelező!<br />";
            }
            
            //Lakcím ellenőrzések
            $allandotelepuleskod = "NULL";
            $tarthelytelepuleskod= "NULL";
            if((empty($allandocimirsz) || empty($allandocimtelepules) || empty($allandocimkoztneve) ||
                 empty($allandocimkoztegyeb)) && (empty($tarthelyirsz) || empty($tarthelytelepules) || empty($tarthelykoztneve) ||
                 empty($tarthelykoztegyeb))){
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "Nem adta meg a tanuló címét!<br />";
            }elseif ((empty($allandocimirsz) || empty($allandocimtelepules) || empty($allandocimkoztneve) ||
                 empty($allandocimkoztegyeb)) && ($allampolgarsag1 == 112) && ($allampolgarsag2 == 0)) {
                    $hiba = true;
                    $uzenetcim = "Hibaüzenet";
                    $uzenet .= "Csak magyar állampolgársággal rendelkező esetében rendelkeznie kell állandó lakcímmel!<br />";
            }else{
                //állandó ellenőrzése, ha valamelyik nem egyenlő üressel, akkor szándékban állt kitölteni
                if (!empty($allandocimirsz) && !empty($allandocimtelepules)) {
                    $query = "SELECT * FROM telepules WHERE iranyitoszam='".$allandocimirsz."' AND telepulesnev='".$allandocimtelepules."';";
                    $data = mysqli_query($dbkapcs, $query);
                    
                    if (mysqli_num_rows($data) != 1) {
                        echo 'rossz irsz és település';
                        $hiba = true;
                        $uzenetcim = "Hibaüzenet";
                        $uzenet .= "Kérem ellenőrizze, hogy az állandó lakcímnél jó az irányítószámot és a településnevet adott-e meg!<br />";
                    }else{
                        $sor = mysqli_fetch_array($data);
                        $allandotelepuleskod = $sor['telepules_id'];
                    }
                }
                if(!empty($tarthelyirsz) && !empty($tarthelytelepules)){
                    $query = "SELECT * FROM telepules WHERE iranyitoszam='".$tarthelyirsz."' AND telepulesnev='".$tarthelytelepules."';";
                    $data = mysqli_query($dbkapcs, $query);
                    
                    if (mysqli_num_rows($data) != 1) {
                        echo 'rossz irsz és település';
                        $hiba = true;
                        $uzenetcim = "Hibaüzenet";
                        $uzenet .= "Kérem ellenőrizze, hogy a tartózkodási helynél jó az irányítószámot és a településnevet adott-e meg!<br />";
                    }else{
                        $sor = mysqli_fetch_array($data);
                        $tarthelytelepuleskod=$sor['telepules_id'];
                    }
                }
            }
            //SNI BTMN HH HHH ellenőrzése
            $sni = 0;
            $btmn = 0;
            $hh = 0;
            $hhh = 0;
            if(isset($_POST['checkboxlista'])){
//                echo'<br />CSEKBOXOK<br />';
                
                foreach ($_POST['checkboxlista'] as $lista){
                    if($lista == "sni"){
                        $sni = 1;
                    }elseif ($lista == "btmn") {
                        $btmn = 1;                   
                    }elseif($lista == "hh"){
                        $hh = 1;
                    }elseif($lista =="hhh"){
                        $hhh = 1;
                    }
                    
//                    echo $lista .' | ';
                }
            }
            //Felekezet ellenőrzése:
            if($felekezet == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "A felekezet listájában nem választott ki elemet!<br />";
            }
            //Csoport ellenőrzése:
            if($csoport == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "Nem választotta ki, hogy a tanuló melyik csoportba tartozik!<br />";
            }
            //Étkezési kategória:
            if($etkat == 0){
                $hiba = true;
                $uzenetcim = "Hibaüzenet";
                $uzenet .= "Nem választotta ki a tanuló étkezési kategóriáját!<br />";
            }
            
   
        echo '</div>'; //teszt div vége
        
        if ($hiba == TRUE) {
            ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
            </script><?php
        }else{
            if($allampolgarsag2 == 0){
                $allampolgarsag2 = "NULL";
            }
            if($gyereknem == "no"){
                $gyereknem = 0;
            }else{
                $gyereknem = 1;
            }
            if($allandocimkoztjellege == 0){
                $allandocimkoztjellege = "NULL";
            }
            if($tarthelykoztjellege == 0){
                $tarthelykoztjellege = "NULL";
            }
            
            
            $query = "UPDATE tanulo SET t_oktatasi_azon = '".$oktazon."', t_nev_elotag = '".$nevelotag."',"
                    . "t_vnev ='".$vezeteknev."', t_knev ='".$keresztnev."', "
                    . "t_szul_orszag =".$szulorszag.", t_szul_hely ='".$szulhely."', t_szul_datum ='".$szulido."',"
                    . "t_allampolgarsag_1 =".$allampolgarsag1.", t_allampolgarsag_2 =".$allampolgarsag2.","
                    . "t_tajszam ='".$tajszam."', t_neme =".$gyereknem.", t_anya_nev_elotag ='".$anyanevelotag."',"
                    . "t_anya_nev ='".$anyanev."',t_anya_telszam ='".telefonszamellenorzes($anyatel)[1]."',"
                    . "t_anya_email ='".$anyaemail."', t_apa_nev_elotag ='".$apanevelotag."',t_apa_nev ='".$apanev."',"
                    . "t_apa_telszam ='".telefonszamellenorzes($apatel)[1]."', t_apa_email ='".$apaemail."',"
                    . "t_lakhely_tip =".$lakhelytip.", t_allando_telepules_kod =".$allandotelepuleskod.","
                    . "t_allando_lc_kozterulet_neve ='".$allandocimkoztneve."', t_allando_lc_kozterulet_jellege =".$allandocimkoztjellege.","
                    . "t_allando_lc_egyeb ='".$allandocimkoztegyeb."', t_tarthely_telepules_kod =".$tarthelytelepuleskod.","
                    . "t_tarthely_kozterulet_neve ='".$tarthelykoztneve."', t_tarthely_kozterulet_jellege =".$tarthelykoztjellege.","
                    . "t_tarthely_kozterulet_egyeb ='".$tarthelykoztegyeb."', t_tankoteles_koru =".$tankotelezett.","
                    . "t_jogviszony_kezdete ='".$jogvkezdete."', t_jogviszony_vege ='".$jogvvege."', t_sni =".$sni.","
                    . "t_btmn =".$btmn.", t_hh =".$hh.", t_hhh =".$hhh.", t_csoport =".$csoport.","
                    . "t_felekezet =".$felekezet.", t_etkezesi_kategoria =".$etkat.", t_megjegyzes ='".$megjegyzes."' "
                    . "WHERE tanulo_id = ".$id.";";
            

            mysqli_query($dbkapcs, $query);
            
    
            $uzenetcim = "Visszajelzés";
            $uzenet = "A tanuló adatainak módosítása sikeresen végrehajtódott!<br />A tanulók listázása oldal automatikusan betölt 3mp múlva.";
            ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
                setTimeout("location.href='tanuloklistaz.php'",3000);
            </script><?php
        }
    }

  
?>    
 <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Tanuló adatainak szerkesztése</h4><br />
    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id; ?>" method="post">
        <table style="width:100%; margin: auto;">
            <tr>
                <td style="vertical-align: top; margin: auto;">
                    <fieldset>
                        <legend>Alapadatok</legend>
                            <div class="form-group row">
                                <label for="oktazon" class="col-4 col-form-label">Oktatási azonosító</label> 
                                <div class="col-7">
                                    <input id="oktazon" name="oktazon" placeholder="Oktatási azonosító" class="form-control here" type="text" value="<?php if(isset($oktazon) && ($hiba == true)){ echo $oktazon; }else{ echo $sor['t_oktatasi_azon'];} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tajszam" class="col-4 col-form-label">TAJ szám</label> 
                                <div class="col-7">
                                    <input id="tajszam" name="tajszam" placeholder="TAJ szám" class="form-control here" type="text" value="<?php if(isset($tajszam) && ($hiba == true)){echo $tajszam;}else{ echo $sor['t_tajszam'];}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="nevelotag" name="nevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($nevelotag) && ($hiba==true)){echo $nevelotag;}else{echo $sor['t_nev_elotag'];}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vnev" class="col-4 col-form-label">Vezetéknév</label> 
                                <div class="col-7">
                                    <input id="vnev" name="vnev" placeholder="Vezetéknév" class="form-control here" type="text" value="<?php if(isset($vezeteknev) && ($hiba==true)){echo $vezeteknev;}else{ echo $sor['t_vnev']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="knev" class="col-4 col-form-label">Keresztnév</label> 
                                <div class="col-7">
                                    <input id="knev" name="knev" placeholder="Keresztnév" class="form-control here" type="text" value="<?php if(isset($keresztnev) && ($hiba == true)){echo $keresztnev;}else{ echo $sor['t_knev']; }?>">
                                </div>
                            </div>                   
                            <div class="form-group row">
                                <label for="allampolgarsag1" class="col-4 col-form-label">1. állampolgárság</label> 
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_allampolgarsag_1']) && !isset($allampolgarsag1)){
                                        echo '<select id="allampolgarsag1" name="allampolgarsag1" class="custom-select">';
                                     
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = ".$sor['t_allampolgarsag_1'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_allampolgarsag_1'].'" selected>'.$sor2['allampolgarsag'].'</option>';
                                            $query = "SELECT * FROM allampolgarsag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['allampolgarsag_id'] != $sor['t_allampolgarsag_1']){
                                                    echo '<option value="'.$sor2['allampolgarsag_id'].'">'.$sor2['allampolgarsag'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($allampolgarsag1)){                         
                                          echo '<select id="allampolgarsag1" name="allampolgarsag1" class="custom-select">';
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id ='".$allampolgarsag1."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($allampolgarsag1) && ($allampolgarsag1 != 0)){
                                                $allampolgarsagid = $allampolgarsag1;
                                                $allampolgarsag = $sor2['allampolgarsag'];
                                            }else{
                                                $allampolgarsagid = 0;
                                                $allampolgarsag = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$allampolgarsagid.'" selected>'.$allampolgarsag.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM allampolgarsag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['allampolgarsag_id'].'">'.$sor2['allampolgarsag'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allampolgarsag2" class="col-4 col-form-label">2. állampolgárság</label> 
                                <div class="col-7">
                                <?php
                                    if(!isset($allampolgarsag2)){
                                        echo '<select id="allampolgarsag2" name="allampolgarsag2" class="custom-select">';
                                     
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = ".$sor['t_allampolgarsag_2'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            
                                            if(empty($sor['t_allampolgarsag_2'])){
                                                $query = "SELECT * FROM allampolgarsag;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0" selected>Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['allampolgarsag_id'] != $sor['t_allampolgarsag_2']){
                                                        echo '<option value="'.$sor2['allampolgarsag_id'].'">'.$sor2['allampolgarsag'].'</option>';
                                                    }
                                                }
                                            }else{
                                                echo '<option value="'.$sor['t_allampolgarsag_2'].'" selected>'.$sor2['allampolgarsag'].'</option>';
                                                $query = "SELECT * FROM allampolgarsag;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0">Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['allampolgarsag_id'] != $sor['t_allampolgarsag_2']){
                                                        echo '<option value="'.$sor2['allampolgarsag_id'].'">'.$sor2['allampolgarsag'].'</option>';
                                                    }
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($allampolgarsag2)){                         
                                          echo '<select id="allampolgarsag2" name="allampolgarsag2" class="custom-select">';
                                            $query = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id ='".$allampolgarsag2."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($allampolgarsag2) && ($allampolgarsag2 != 0)){
                                                $allampolgarsagid = $allampolgarsag2;
                                                $allampolgarsag = $sor2['allampolgarsag'];
                                            }else{
                                                $allampolgarsagid = 0;
                                                $allampolgarsag = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$allampolgarsagid.'" selected>'.$allampolgarsag.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM allampolgarsag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['allampolgarsag_id'].'">'.$sor2['allampolgarsag'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                            
                    </fieldset>
                    <fieldset>
                        <legend>Születési alapadatok</legend>
                            <div class="form-group row">
                                <label for="szulorszag" class="col-4 col-form-label">Születési ország</label> 
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_szul_orszag']) && !isset($szulorszag)){
                                        echo '<select id="szulorszag" name="szulorszag" class="custom-select">';
                                     
                                            $query = "SELECT * FROM orszag WHERE orszag_id = ".$sor['t_szul_orszag'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_szul_orszag'].'" selected>'.$sor2['orszag_nev'].'</option>';
                                            $query = "SELECT * FROM orszag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['orszag_id'] != $sor['t_szul_orszag']){
                                                    echo '<option value="'.$sor2['orszag_id'].'">'.$sor2['orszag_nev'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($szulorszag)){                         
                                          echo '<select id="szulorszag" name="szulorszag" class="custom-select">';
                                            $query = "SELECT * FROM orszag WHERE orszag_id ='".$szulorszag."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($szulorszag) && ($szulorszag != 0)){
                                                $szulorszagid = $szulorszag;
                                                $szulorszagnev = $sor2['orszag_nev'];
                                            }else{
                                                $szulorszagid = 0;
                                                $szulorszagnev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$szulorszagid.'" selected>'.$szulorszagnev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM orszag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['orszag_id'].'">'.$sor2['orszag_nev'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="szulhely" class="col-4 col-form-label">Születési hely</label> 
                                <div class="col-7">
                                    <input id="szulhely" name="szulhely" placeholder="Születési hely" class="form-control here" type="text" value="<?php if(isset($szulhely) && ($hiba==true)){echo $szulhely;}else{ echo $sor['t_szul_hely']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="szulido" class="col-4 col-form-label">Születési idő</label> 
                                <div class="col-4">
                                    <input id="szulido" name="szulido" class="form-control here" type="date" value="<?php if(isset($szulido) && ($hiba==true)){echo $szulido;}else{ echo $sor['t_szul_datum']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gyereknem" class="col-4 col-form-label">Nem</label> 
                                <div class="col-7">
                                    <?php  
                                        if(isset($sor['t_neme']) && !isset($gyereknem)){
                                            if($sor['t_neme'] == 1){
                                                echo '<div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">';
                                                echo '<label class="form-check-label">';
                                                    echo '<input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="ferfi" checked>Férfi';
                                                echo '</label>';
                                                echo '</div>';
                                                echo '<div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">';
                                                echo '<label class="form-check-label">';
                                                    echo '<input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="no" >Nő';
                                                echo '</label>';
                                                echo '</div>';
                                            }else{
                                                echo '<div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">';
                                                echo '<label class="form-check-label">';
                                                    echo '<input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="ferfi">Férfi';
                                                echo '</label>';
                                                echo '</div>';
                                                echo '<div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">';
                                                echo '<label class="form-check-label">';
                                                    echo '<input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="no" checked>Nő';
                                                echo '</label>';
                                                echo '</div>';
                                            }
                                        }else{
                                        ?>
                                            <div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="ferfi" <?php if(isset($sor['t_neme']) && !isset($gyereknem) && ($sor['t_neme'] == 1)){ echo 'checked';}else if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="ferfi")){ echo 'checked';} ?>>Férfi
                                                </label>
                                            </div>
                                            <div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="no" <?php if(isset($sor['t_neme']) && !isset($gyereknem) && ($sor['t_neme'] == 0)){ echo 'checked';}else if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="no")){echo 'checked';}elseif(!isset ($gyereknem)){ echo 'checked';}?>>Nő<!--? php if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="no")){echo 'checked';}elseif(isset($gyereknem) && ($gyereknem!="ferfi")){ echo 'checked';}else{echo 'checked';} ?-->
                                                </label>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesanya adatai</legend>
                            <div class="form-group row">
                                <label for="anyanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="anyanevelotag" name="anyanevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($anyanevelotag) && ($hiba == true)){echo $anyanevelotag;}else{ echo $sor['t_anya_nev_elotag']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyanev" class="col-4 col-form-label">Édesanya neve</label> 
                                <div class="col-7">
                                    <input id="anyanev" name="anyanev" placeholder="Édesanya neve" class="form-control here" type="text" value="<?php if(isset($anyanev) && ($hiba == true)){echo $anyanev;}else{ echo $sor['t_anya_nev']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyatel" class="col-4 col-form-label">Édesanya telefonszám</label> 
                                <div class="col-7">
                                    <input id="anyatel" name="anyatel" placeholder="Telefonszám" class="form-control here" type="text" value="<?php if(isset($anyatel) && ($hiba == true)){echo $anyatel;}else{ echo $sor['t_anya_telszam']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyaemail" class="col-4 col-form-label">Édesanya e-mail</label> 
                                <div class="col-7">
                                    <input id="anyaemail" name="anyaemail" placeholder="E-mail cím" class="form-control here" type="text" value="<?php if(isset($anyaemail) && ($hiba == true)){echo $anyaemail;}else{ echo $sor['t_anya_email']; } ?>">
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesapa adatai</legend>
                            <div class="form-group row">
                                <label for="apanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="apanevelotag" name="apanevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($apanevelotag) && ($hiba == true)){echo $apanevelotag;}else { echo $sor['t_apa_nev_elotag']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apanev" class="col-4 col-form-label">Édesapa neve</label> 
                                <div class="col-7">
                                    <input id="apanev" name="apanev" placeholder="Édesapa neve" class="form-control here" type="text" value="<?php if(isset($apanev) && ($hiba == true)){echo $apanev;}else{ echo $sor['t_apa_nev']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apatel" class="col-4 col-form-label">Édesapa telefonszám</label> 
                                <div class="col-7">
                                    <input id="apatel" name="apatel" placeholder="Telefonszám" class="form-control here" type="text" value="<?php if(isset($apatel) && ($hiba == true)){echo $apatel;}else{ echo $sor['t_apa_telszam']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apaemail" class="col-4 col-form-label">Édesapa e-mail</label> 
                                <div class="col-7">
                                    <input id="apaemail" name="apaemail" placeholder="E-mail cím" class="form-control here" type="text" value="<?php if(isset($apaemail) && ($hiba == true)){echo $apaemail;}else{ echo $sor['t_apa_email']; } ?>">
                                </div>
                            </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Jogviszony adatok</legend>
                            <div class="form-group row">
                                <label for="jogvkezdete" class="col-4 col-form-label">Jogviszony kezdete</label> 
                                <div class="col-4">
                                    <input id="jogvkezdete" name="jogvkezdete" class="form-control here" type="date" value="<?php if(isset($jogvkezdete) && ($hiba == true)){echo $jogvkezdete;}else{ echo $sor['t_jogviszony_kezdete']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jogvvege" class="col-4 col-form-label">Jogviszony vége</label> 
                                <div class="col-4">
                                    <input id="jogvvege" name="jogvvege" class="form-control here" type="date" value="<?php if(isset($jogvvege) && ($hiba == true)){echo $jogvvege;}else{ echo $sor['t_jogviszony_vege']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tankotelezett" class="col-4 col-form-label">Tankötelezett</label>
                                <?php
                                    if(!isset($tankotelezett) && isset($sor['t_tankoteles_koru'])){
                                        if($sor['t_tankoteles_koru'] == 1){
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="tankotelezett" name="checkboxlista[]" value="tankotelezett" checked>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="tankotelezett" name="checkboxlista[]" value="tankotelezett">';
                                            echo '</div>';
                                        }
                                    }else{
                                        ?>
                                        <div class="col-8" style="vertical-align: middle;margin:auto;">
                                            <input type="checkbox" id="tankotelezett" name="checkboxlista[]" value="tankotelezett" <?php if(isset($tankotelezett) && ($tankotelezett == 1)){echo "checked";} ?>>
                                        </div>
                                <?php
                                    }
                                ?>
                                
                            </div>                          
                    </fieldset>                  
                </td>
                <td style="vertical-align: top; margin: auto;"> 
                   <fieldset>
                        <legend>Lakóhely típusa</legend>
                        <div class="form-group row">
                                <label for="lakhelytip" class="col-4 col-form-label">Lakóhely típusa</label> 
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_lakhely_tip']) && !isset($lakhelytip)){
                                        echo '<select id="lakhelytip" name="lakhelytip" class="custom-select">';
                                     
                                            $query = "SELECT * FROM lakhely_tipus WHERE lakhely_tip_id = ".$sor['t_lakhely_tip'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_lakhely_tip'].'" selected>'.$sor2['lakhely_tip'].'</option>';
                                            $query = "SELECT * FROM lakhely_tipus;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['lakhely_tip_id'] != $sor['t_lakhely_tip']){
                                                    echo '<option value="'.$sor2['lakhely_tip_id'].'">'.$sor2['lakhely_tip'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($lakhelytip)){                         
                                          echo '<select id="lakhelytip" name="lakhelytip" class="custom-select">';
                                            $query = "SELECT * FROM lakhely_tipus WHERE lakhely_tip_id ='".$lakhelytip."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($lakhelytip) && ($lakhelytip != 0)){
                                                $lakhelytipusid = $lakhelytip;
                                                $lakhelytipusnev = $sor2['lakhely_tip'];
                                            }else{
                                                $lakhelytipusid = 0;
                                                $lakhelytipusnev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$lakhelytipusid.'" selected>'.$lakhelytipusnev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM lakhely_tipus;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['lakhely_tip_id'].'">'.$sor2['lakhely_tip'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                    </fieldset>  
                    <fieldset>

                        <legend>Állandó lakcím</legend>
                            <?php
                                if((!isset($allandocimirsz) || !isset($allandocimtelepules)) && isset($sor['t_allando_telepules_kod'])){
                                    $query = "SELECT * FROM telepules WHERE telepules_id = '".$sor['t_allando_telepules_kod']."';";
                                    $data = mysqli_query($dbkapcs, $query);
                                    $sor2 = mysqli_fetch_array($data);
                                }
                            ?>                                
                            <div class="form-group row">
                                <label for="allandocimirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-2">
                                    <input id="allandocimirsz" name="allandocimirsz" placeholder="" class="form-control here" type="text" value="<?php if(isset($allandocimirsz) && ($hiba == true)){echo $allandocimirsz;}else if(!isset($allandocimirsz) && isset($sor['t_allando_telepules_kod'])){ echo $sor2['iranyitoszam']; }?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimtelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="allandocimtelepules" name="allandocimtelepules" placeholder="Településnév" class="form-control here" type="text" value="<?php if(isset($allandocimtelepules) && ($hiba == true)){echo $allandocimtelepules;}else if(!isset($allandocimtelepules) && isset($sor['t_allando_telepules_kod'])){ echo $sor2['telepulesnev']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztneve" name="allandocimkoztneve" placeholder="Közterület neve" class="form-control here" type="text" value="<?php if(isset($allandocimkoztneve) && ($hiba == true)){echo $allandocimkoztneve;}else{ echo $sor['t_allando_lc_kozterulet_neve']; } ?>">
                                </div>
                            </div>
                       
                            <div class="form-group row">
                                <label for="allandocimkoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                <?php
                                    if(!isset($allandocimkoztjellege)){
                                        echo '<select id="allandocimkoztjellege" name="allandocimkoztjellege" class="custom-select">';
                                     
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = ".$sor['t_allando_lc_kozterulet_jellege'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            
                                            if(empty($sor['t_allando_lc_kozterulet_jellege'])){
                                                $query = "SELECT * FROM kozterulet_jellege;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0" selected>Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['kozterulet_jellege_id'] != $sor['t_allando_lc_kozterulet_jellege']){
                                                        echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                                    }
                                                }
                                            }else{
                                                echo '<option value="'.$sor['t_allando_lc_kozterulet_jellege'].'" selected>'.$sor2['kozterulet_jellege'].'</option>';
                                                $query = "SELECT * FROM kozterulet_jellege;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0">Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['kozterulet_jellege_id'] != $sor['t_allando_lc_kozterulet_jellege']){
                                                        echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                                    }
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($allandocimkoztjellege)){                         
                                          echo '<select id="allandocimkoztjellege" name="allandocimkoztjellege" class="custom-select">';
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id ='".$allandocimkoztjellege."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($allandocimkoztjellege) && ($allandocimkoztjellege != 0)){
                                                $allandocimkoztjellegeid = $allandocimkoztjellege;
                                                $allandocimkoztjellegenev = $sor2['kozterulet_jellege'];
                                            }else{
                                                $allandocimkoztjellegeid = 0;
                                                $allandocimkoztjellegenev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$allandocimkoztjellegeid.'" selected>'.$allandocimkoztjellegenev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM kozterulet_jellege;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label for="allandocimkoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztegyeb" name="allandocimkoztegyeb" placeholder="További adatok" class="form-control here" type="text" value="<?php if(isset($allandocimkoztegyeb) && ($hiba == true)){echo $allandocimkoztegyeb;}else{ echo $sor['t_allando_lc_egyeb']; } ?>">
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Tartózkodási hely</legend>
                            <?php
                                if((!isset($tarthelyirsz) || !isset($tarthelytelepules)) && isset($sor['t_tarthely_telepules_kod'])){
                                    $query = "SELECT * FROM telepules WHERE telepules_id = '".$sor['t_tarthely_telepules_kod']."';";
                                    $data = mysqli_query($dbkapcs, $query);
                                    $sor2 = mysqli_fetch_array($data);
                                }
                            ?> 
                            <div class="form-group row">
                                <label for="tarthelyirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-2">
                                    <input id="tarthelyirsz" name="tarthelyirsz" placeholder="" class="form-control here" type="text" value="<?php if(isset($tarthelyirsz) && ($hiba == true)){echo $tarthelyirsz;}else if(!isset($tarthelyirsz) && isset($sor['t_tarthely_telepules_kod'])){ echo $sor2['iranyitoszam']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelytelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="tarthelytelepules" name="tarthelytelepules" placeholder="Településnév" class="form-control here" type="text" value="<?php if(isset($tarthelytelepules) && ($hiba == true)){echo $tarthelytelepules;}else if(!isset($tarthelytelepules) && isset($sor['t_tarthely_telepules_kod'])){ echo $sor2['telepulesnev']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztneve" name="tarthelykoztneve" placeholder="Közterület neve" class="form-control here" type="text" value="<?php if(isset($tarthelykoztneve) && ($hiba == true)){echo $tarthelykoztneve;}else{ echo $sor['t_tarthely_kozterulet_neve']; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                <?php
                                    if(!isset($tarthelykoztjellege)){
                                        echo '<select id="tarthelykoztjellege" name="tarthelykoztjellege" class="custom-select">';
                                     
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = ".$sor['t_tarthely_kozterulet_jellege'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            
                                            if(empty($sor['t_tarthely_kozterulet_jellege'])){
                                                $query = "SELECT * FROM kozterulet_jellege;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0" selected>Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['kozterulet_jellege_id'] != $sor['t_tarthely_kozterulet_jellege']){
                                                        echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                                    }
                                                }
                                            }else{
                                                echo '<option value="'.$sor['t_tarthely_kozterulet_jellege'].'" selected>'.$sor2['kozterulet_jellege'].'</option>';
                                                $query = "SELECT * FROM kozterulet_jellege;";
                                                $data = mysqli_query($dbkapcs, $query);
                                                echo '<option value="0">Nincs kiválasztva</option>';
                                                while ($sor2 = mysqli_fetch_array($data)){
                                                    if($sor2['kozterulet_jellege_id'] != $sor['t_tarthely_kozterulet_jellege']){
                                                        echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                                    }
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($tarthelykoztjellege)){                         
                                          echo '<select id="tarthelykoztjellege" name="tarthelykoztjellege" class="custom-select">';
                                            $query = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id ='".$tarthelykoztjellege."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($tarthelykoztjellege) && ($tarthelykoztjellege != 0)){
                                                $tarthelykoztjellegeid = $tarthelykoztjellege;
                                                $tarthelykoztjellegenev = $sor2['kozterulet_jellege'];
                                            }else{
                                                $tarthelykoztjellegeid = 0;
                                                $tarthelykoztjellegenev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$tarthelykoztjellegeid.'" selected>'.$tarthelykoztjellegenev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM kozterulet_jellege;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['kozterulet_jellege_id'].'">'.$sor2['kozterulet_jellege'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztegyeb" name="tarthelykoztegyeb" placeholder="További adatok" class="form-control here" type="text" value="<?php if(isset($tarthelykoztegyeb) && ($hiba == true)){echo $tarthelykoztegyeb;}else{ echo $sor['t_tarthely_kozterulet_egyeb']; } ?>">
                                </div>
                            </div>

                    </fieldset>
                    
                    <fieldset>
                        <legend>Egyéb adatok</legend>

                        
                            <div class="form-group row">
                                <label for="sni" class="col-4 col-form-label">Sajátos nevelési igény</label> 
                                <?php   
                                    if(!isset($sni) && isset($sor['t_sni'])){
                                        if($sor['t_sni'] == 1){
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="sni" name="checkboxlista[]" value="sni" checked>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="sni" name="checkboxlista[]" value="sni">';
                                            echo '</div>';
                                        }
                                    }else{
                                ?>
                                        <div class="col-8" style="vertical-align: middle;margin:auto;">
                                            <input type="checkbox" id="sni"  name="checkboxlista[]" value="sni" <?php if(isset($sni) && ($sni == 1)){echo "checked";}?>>
                                        </div>
                                <?php
                                    }
                                ?>    
                            </div>
                            <div class="form-group row">
                                <label for="btmn" class="col-4 col-form-label">Beilleszkedési, tanulási, magatartási nehézség</label> 
                                <?php
                                    if(!isset($btmn) && isset($sor['t_btmn'])){
                                        if($sor['t_btmn'] == 1){
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="btmn" name="checkboxlista[]" value="btmn" checked>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="btmn" name="checkboxlista[]" value="btmn">';
                                            echo '</div>';
                                        }
                                    }else{
                                ?>
                                        <div class="col-8" style="vertical-align: middle;margin:auto;">
                                            <input type="checkbox" id="btmn"  name="checkboxlista[]" value="btmn" <?php if(isset($btmn) && ($btmn == 1)){echo "checked";}?>>
                                        </div>
                                <?php
                                    }
                                ?>     
                            </div>
                            <div class="form-group row">
                                <label for="hh" class="col-4 col-form-label">Hátrányos helyzet</label> 
                                <?php
                                    if(!isset($hh) && isset($sor['t_hh'])){
                                        if($sor['t_hh'] == 1){
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="hh" name="checkboxlista[]" value="hh" checked>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="hh" name="checkboxlista[]" value="hh">';
                                            echo '</div>';
                                        }
                                    }else{
                                ?>
                                        <div class="col-8" style="vertical-align: middle;margin:auto;">
                                            <input type="checkbox" id="hh"  name="checkboxlista[]" value="hh" <?php if(isset($hh) && ($hh == 1)){echo "checked";}?>>
                                        </div>
                                <?php
                                    }
                                ?> 
                            </div>
                            <div class="form-group row">
                                <label for="hhh" class="col-4 col-form-label">Halmozottan hátrányos helyzet</label> 
                                <?php
                                    if(!isset($hhh) && isset($sor['t_hhh'])){
                                        if($sor['t_hhh'] == 1){
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="hhh" name="checkboxlista[]" value="hhh" checked>';
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-8" style="vertical-align: middle;margin:auto;">';
                                                echo '<input type="checkbox" id="hhh" name="checkboxlista[]" value="hhh">';
                                            echo '</div>';
                                        }
                                    }else{
                                ?>
                                        <div class="col-8" style="vertical-align: middle;margin:auto;">
                                            <input type="checkbox" id="hhh"  name="checkboxlista[]" value="hhh" <?php if(isset($hhh) && ($hhh == 1)){echo "checked";}?>>
                                        </div>
                                <?php
                                    }
                                ?> 
                            </div>
                        
                            <div class="form-group row">
                                <label for="felekezet" class="col-4 col-form-label">Felekezet</label> 
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_felekezet']) && !isset($felekezet)){
                                        echo '<select id="felekezet" name="felekezet" class="custom-select">';
                                     
                                            $query = "SELECT * FROM felekezet WHERE felekezet_id = ".$sor['t_felekezet'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_felekezet'].'" selected>'.$sor2['felekezet_nev'].'</option>';
                                            $query = "SELECT * FROM felekezet;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['felekezet_id'] != $sor['t_felekezet']){
                                                    echo '<option value="'.$sor2['felekezet_id'].'">'.$sor2['felekezet_nev'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($felekezet)){                         
                                          echo '<select id="felekezet" name="felekezet" class="custom-select">';
                                            $query = "SELECT * FROM felekezet WHERE felekezet_id ='".$felekezet."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($felekezet) && ($felekezet != 0)){
                                                $felekezetid = $felekezet;
                                                $felekezetnev = $sor2['felekezet_nev'];
                                            }else{
                                                $felekezetid = 0;
                                                $felekezetnev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$felekezetid.'" selected>'.$felekezetnev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM felekezet;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['felekezet_id'].'">'.$sor2['felekezet_nev'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="csoport" class="col-4 col-form-label">Csoport</label> 
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_csoport']) && !isset($csoport)){
                                        echo '<select id="csoport" name="csoport" class="custom-select">';
                                     
                                            $query = "SELECT * FROM csoport WHERE csoport_id = ".$sor['t_csoport'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_csoport'].'" selected>'.$sor2['csoport_nev'].'</option>';
                                            $query = "SELECT * FROM csoport;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['csoport_id'] != $sor['t_csoport']){
                                                    echo '<option value="'.$sor2['csoport_id'].'">'.$sor2['csoport_nev'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($csoport)){                         
                                          echo '<select id="csoport" name="csoport" class="custom-select">';
                                            $query = "SELECT * FROM csoport WHERE csoport_id ='".$csoport."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($csoport) && ($csoport != 0)){
                                                $csoportid = $csoport;
                                                $csoportnev = $sor2['csoport_nev'];
                                            }else{
                                                $csoportid = 0;
                                                $csoportnev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$csoportid.'" selected>'.$csoportnev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM csoport;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['csoport_id'].'">'.$sor2['csoport_nev'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label for="etkat" class="col-4 col-form-label">Étkezési kategória</label>
                                <div class="col-7">
                                <?php
                                    if(!empty($sor['t_etkezesi_kategoria']) && !isset($etkat)){
                                        echo '<select id="etkat" name="etkat" class="custom-select">';
                                     
                                            $query = "SELECT * FROM etkezesi_kategoria WHERE etkezesi_kategoria_id = ".$sor['t_etkezesi_kategoria'].";";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                        
                                            echo '<option value="'.$sor['t_etkezesi_kategoria'].'" selected>'.$sor2['etkezesi_kategoria_nev'].'</option>';
                                            $query = "SELECT * FROM etkezesi_kategoria;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            while ($sor2 = mysqli_fetch_array($data)){
                                                if($sor2['etkezesi_kategoria_id'] != $sor['t_etkezesi_kategoria']){
                                                    echo '<option value="'.$sor2['etkezesi_kategoria_id'].'">'.$sor2['etkezesi_kategoria_nev'].'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    }else{
                                        if(isset($etkat)){                         
                                          echo '<select id="etkat" name="etkat" class="custom-select">';
                                            $query = "SELECT * FROM etkezesi_kategoria WHERE etkezesi_kategoria_id ='".$etkat."';";
                                            $data = mysqli_query($dbkapcs, $query);
                                            $sor2 = mysqli_fetch_array($data);
                                            if(isset($etkat) && ($etkat != 0)){
                                                $etkatid = $etkat;
                                                $etkatnev = $sor2['etkezesi_kategoria_nev'];
                                            }else{
                                                $etkatid = 0;
                                                $etkatnev = "Nincs kiválasztva";
                                            }
                                            echo '<option value="'.$etkatid.'" selected>'.$etkatnev.'</option>';
                                            echo '<option value="0">Nincs kiválasztva</option>';
                                            $query =  "SELECT * FROM etkezesi_kategoria;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            while($sor2 = mysqli_fetch_array($data)){
                                                echo '<option value="'.$sor2['etkezesi_kategoria_id'].'">'.$sor2['etkezesi_kategoria_nev'].'</option>';
                                            }
                                          echo '</select>';  
                                                  
                                        }
                                    }            
                                ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="megjegyzes" class="col-4 col-form-label">Megjegyzés</label> 
                                <div class="col-7">
                                    <textarea class="form-control" rows="2" id="megjegyzes" name="megjegyzes"><?php if(isset($megjegyzes) && ($hiba == true)){echo $megjegyzes;}else{ echo $sor['t_megjegyzes']; } ?></textarea>
                                </div>
                            </div>
                    </fieldset>

                    <div class="form-group row">
                        <label for="hh" class="col-2 col-form-label"></label> 
                        <div class="col-7" >
                            <button type="submit" id="submit" name="submit" class="btn btn-block btn-dark" placeholder="Módosít" >Módosít</button>
                        </div>
                    </div>   
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
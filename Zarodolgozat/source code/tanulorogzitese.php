<?php
    require_once('dbkapcsolat.php');
    require_once('munkamenetinditasa.php');
    $oldalcime = 'Új tanuló adatatainak rögzítése';
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
                $query = "SELECT t_oktatasi_azon FROM tanulo WHERE t_oktatasi_azon='".$oktazon."';";
                if (mysqli_num_rows(mysqli_query($dbkapcs, $query)) == 1) {
                        $hiba = true;
                        $uzenetcim = "Hibaüzenet";
                        $uzenet .= "A megadott oktatási azonosító szám már szerepel az adatbázisban!<br />";
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
                        $query = "SELECT t_tajszam FROM tanulo WHERE t_tajszam='".$tajszam."';";
                        if (mysqli_num_rows(mysqli_query($dbkapcs, $query)) == 1) {
                            $hiba = true;
                            $uzenetcim = "Hibaüzenet";
                            $uzenet .= "A megadott TAJ-szám már szerepel az adatbázisban!<br />";
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
            
            $query = "INSERT INTO tanulo (t_oktatasi_azon, t_nev_elotag, t_vnev, t_knev,"
                    . "t_szul_orszag, t_szul_hely, t_szul_datum, t_allampolgarsag_1, t_allampolgarsag_2,"
                    . "t_tajszam, t_neme, t_anya_nev_elotag, t_anya_nev, t_anya_telszam, t_anya_email,"
                    . "t_apa_nev_elotag, t_apa_nev, t_apa_telszam, t_apa_email, t_lakhely_tip,"
                    . "t_allando_telepules_kod, t_allando_lc_kozterulet_neve, t_allando_lc_kozterulet_jellege,"
                    . "t_allando_lc_egyeb, t_tarthely_telepules_kod, t_tarthely_kozterulet_neve,"
                    . "t_tarthely_kozterulet_jellege, t_tarthely_kozterulet_egyeb, t_tankoteles_koru,"
                    . "t_jogviszony_kezdete, t_jogviszony_vege, t_sni, t_btmn, t_hh, t_hhh,"
                    . "t_csoport, t_felekezet, t_etkezesi_kategoria, t_megjegyzes) "
                    . "VALUES ('".$oktazon."','".$nevelotag."','".$vezeteknev."','".$keresztnev."',".$szulorszag.",'".$szulhely."','".$szulido."',"
                    . "".$allampolgarsag1.",".$allampolgarsag2.",'".$tajszam."',".$gyereknem.",'".$anyanevelotag."','".$anyanev."','".telefonszamellenorzes($anyatel)[1]."',"
                    . "'".$anyaemail."','".$apanevelotag."','".$apanev."','".telefonszamellenorzes($apatel)[1]."','".$apaemail."',"
                    . "".$lakhelytip.",".$allandotelepuleskod.",'".$allandocimkoztneve."',".$allandocimkoztjellege.",'".$allandocimkoztegyeb."',"
                    . "".$tarthelytelepuleskod.",'".$tarthelykoztneve."',".$tarthelykoztjellege.",'".$tarthelykoztegyeb."',".$tankotelezett.","
                    . "'".$jogvkezdete."','".$jogvvege."',".$sni.",".$btmn.",".$hh.",".$hhh.",".$csoport.",".$felekezet.",".$etkat.",'".$megjegyzes."');";
            mysqli_query($dbkapcs, $query);
            
    
            $uzenetcim = "Visszajelzés";
            $uzenet = "Az új tanuló adatai sikeresen rögzítésre kerültek a rendszerben!";
            ?><script>
                    $(document).ready(function(){
                    $("#visszajelzes").modal('show');});
            </script><?php
        }
    }

  
?>    
 <div style="width: 80%; margin: auto;">
    <h4 style="text-align: center;">Új gyerek adatainak felvitele</h4><br />
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table style="width:100%; margin: auto;">
            <tr>
                <td style="vertical-align: top; margin: auto;">
                    <fieldset>
                        <legend>Alapadatok</legend>
                            <div class="form-group row">
                                <label for="oktazon" class="col-4 col-form-label">Oktatási azonosító</label> 
                                <div class="col-7">
                                    <input id="oktazon" name="oktazon" placeholder="Oktatási azonosító" class="form-control here" type="text" value="<?php if(isset($oktazon) && ($hiba == true)){ echo $oktazon; } ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tajszam" class="col-4 col-form-label">TAJ szám</label> 
                                <div class="col-7">
                                    <input id="tajszam" name="tajszam" placeholder="TAJ szám" class="form-control here" type="text" value="<?php if(isset($tajszam) && ($hiba == true)){echo $tajszam;}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="nevelotag" name="nevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($nevelotag) && ($hiba==true)){echo $nevelotag;}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vnev" class="col-4 col-form-label">Vezetéknév</label> 
                                <div class="col-7">
                                    <input id="vnev" name="vnev" placeholder="Vezetéknév" class="form-control here" type="text" value="<?php if(isset($vezeteknev) && ($hiba==true)){echo $vezeteknev;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="knev" class="col-4 col-form-label">Keresztnév</label> 
                                <div class="col-7">
                                    <input id="knev" name="knev" placeholder="Keresztnév" class="form-control here" type="text" value="<?php if(isset($keresztnev) && ($hiba == true)){echo $keresztnev;} ?>">
                                </div>
                            </div>                   
                            <div class="form-group row">
                                <label for="allampolgarsag1" class="col-4 col-form-label">1. állampolgárság</label> 
                                <div class="col-7">
                                    <select id="allampolgarsag1" name="allampolgarsag1" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM allampolgarsag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($allampolgarsag1) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = ".$allampolgarsag1.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($allampolgarsag1) &&  ($hiba == true)){ echo $allampolgarsag1. ' selected';} else {echo 0;}?>><?php if (isset($allampolgarsag1) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['allampolgarsag'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['allampolgarsag_id'].'">'.$sor['allampolgarsag'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allampolgarsag2" class="col-4 col-form-label">2. állampolgárság</label> 
                                <div class="col-7">
                                    <select id="allampolgarsag2" name="allampolgarsag2" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM allampolgarsag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($allampolgarsag2) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM allampolgarsag WHERE allampolgarsag_id = ".$allampolgarsag2.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($allampolgarsag2) &&  ($hiba == true)){ echo $allampolgarsag2. ' selected';} else {echo 0;}?>><?php if (isset($allampolgarsag2) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['allampolgarsag'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['allampolgarsag_id'].'">'.$sor['allampolgarsag'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                    </fieldset>
                    <fieldset>
                        <legend>Születési alapadatok</legend>
                            <div class="form-group row">
                                <label for="szulorszag" class="col-4 col-form-label">Születési ország</label> 
                                <div class="col-7">
                                    <select id="szulorszag" name="szulorszag" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM orszag;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($szulorszag) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM orszag WHERE orszag_id = ".$szulorszag.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($szulorszag) &&  ($hiba == true)){ echo $szulorszag. ' selected';} else {echo 0;}?>><?php if (isset($szulorszag) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['orszag_nev'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['orszag_id'].'">'.$sor['orszag_nev'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="szulhely" class="col-4 col-form-label">Születési hely</label> 
                                <div class="col-7">
                                    <input id="szulhely" name="szulhely" placeholder="Születési hely" class="form-control here" type="text" value="<?php if(isset($szulhely) && ($hiba==true)){echo $szulhely;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="szulido" class="col-4 col-form-label">Születési idő</label> 
                                <div class="col-4">
                                    <input id="szulido" name="szulido" class="form-control here" type="date" value="<?php if(isset($szulido) && ($hiba==true)){echo $szulido;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gyereknem" class="col-4 col-form-label">Nem</label> 
                                <div class="col-7">
                                    <div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="ferfi" <?php if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="ferfi")){ echo 'checked';} ?>>Férfi
                                        </label>
                                    </div>
                                    <div class="form-check-inline" style="vertical-align: middle;margin:7px auto;">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="gyereknem" name="gyereknem" value="no" <?php if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="no")){echo 'checked';}elseif(!isset ($gyereknem)){ echo 'checked';}?>>Nő<!--? php if(isset($gyereknem) && ($hiba==true) && ($gyereknem=="no")){echo 'checked';}elseif(isset($gyereknem) && ($gyereknem!="ferfi")){ echo 'checked';}else{echo 'checked';} ?-->
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesanya adatai</legend>
                            <div class="form-group row">
                                <label for="anyanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="anyanevelotag" name="anyanevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($anyanevelotag) && ($hiba == true)){echo $anyanevelotag;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyanev" class="col-4 col-form-label">Édesanya neve</label> 
                                <div class="col-7">
                                    <input id="anyanev" name="anyanev" placeholder="Édesanya neve" class="form-control here" type="text" value="<?php if(isset($anyanev) && ($hiba == true)){echo $anyanev;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyatel" class="col-4 col-form-label">Édesanya telefonszám</label> 
                                <div class="col-7">
                                    <input id="anyatel" name="anyatel" placeholder="Telefonszám" class="form-control here" type="text" value="<?php if(isset($anyatel) && ($hiba == true)){echo $anyatel;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="anyaemail" class="col-4 col-form-label">Édesanya e-mail</label> 
                                <div class="col-7">
                                    <input id="anyaemail" name="anyaemail" placeholder="E-mail cím" class="form-control here" type="text" value="<?php if(isset($anyaemail) && ($hiba == true)){echo $anyaemail;} ?>">
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Édesapa adatai</legend>
                            <div class="form-group row">
                                <label for="apanevelotag" class="col-4 col-form-label">Név előtag</label> 
                                <div class="col-3">
                                    <input id="apanevelotag" name="apanevelotag" placeholder="Név előtag" class="form-control here" type="text" value="<?php if(isset($apanevelotag) && ($hiba == true)){echo $apanevelotag;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apanev" class="col-4 col-form-label">Édesapa neve</label> 
                                <div class="col-7">
                                    <input id="apanev" name="apanev" placeholder="Édesapa neve" class="form-control here" type="text" value="<?php if(isset($apanev) && ($hiba == true)){echo $apanev;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apatel" class="col-4 col-form-label">Édesapa telefonszám</label> 
                                <div class="col-7">
                                    <input id="apatel" name="apatel" placeholder="Telefonszám" class="form-control here" type="text" value="<?php if(isset($apatel) && ($hiba == true)){echo $apatel;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apaemail" class="col-4 col-form-label">Édesapa e-mail</label> 
                                <div class="col-7">
                                    <input id="apaemail" name="apaemail" placeholder="E-mail cím" class="form-control here" type="text" value="<?php if(isset($apaemail) && ($hiba == true)){echo $apaemail;} ?>">
                                </div>
                            </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Jogviszony adatok</legend>
                            <div class="form-group row">
                                <label for="jogvkezdete" class="col-4 col-form-label">Jogviszony kezdete</label> 
                                <div class="col-4">
                                    <input id="jogvkezdete" name="jogvkezdete" class="form-control here" type="date" value="<?php if(isset($jogvkezdete) && ($hiba == true)){echo $jogvkezdete;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jogvvege" class="col-4 col-form-label">Jogviszony vége</label> 
                                <div class="col-4">
                                    <input id="jogvvege" name="jogvvege" class="form-control here" type="date" value="<?php if(isset($jogvvege) && ($hiba == true)){echo $jogvvege;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tankotelezett" class="col-4 col-form-label">Tankötelezett</label> 
                                <div class="col-8" style="vertical-align: middle;margin:auto;">
                                    <input type="checkbox" id="tankotelezett" name="checkboxlista[]" value="tankotelezett" <?php if(isset($tankotelezett) && ($tankotelezett == 1)){echo "checked";} ?>>
                                </div>
                            </div>                     
                    </fieldset>                  
                </td>
                <td style="vertical-align: top; margin: auto;"> 
                    <fieldset>
                        <legend>Lakóhely típusa</legend>
                        <div class="form-group row">
                                <label for="lakhelytip" class="col-4 col-form-label">Lakóhely típusa</label> 
                                <div class="col-7">
                                    <select id="lakhelytip" name="lakhelytip" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM lakhely_tipus;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($lakhelytip) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM lakhely_tipus WHERE lakhely_tip_id = ".$lakhelytip.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($lakhelytip) &&  ($hiba == true)){ echo $lakhelytip. ' selected';} else {echo 0;}?>><?php if (isset($lakhelytip) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['lakhely_tip'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['lakhely_tip_id'].'">'.$sor['lakhely_tip'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    </fieldset> 
                    <fieldset>
                        <legend>Állandó lakcím</legend>
                            <div class="form-group row">
                                <label for="allandocimirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-2">
                                    <input id="allandocimirsz" name="allandocimirsz" placeholder="" class="form-control here" type="text" value="<?php if(isset($allandocimirsz) && ($hiba == true)){echo $allandocimirsz;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimtelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="allandocimtelepules" name="allandocimtelepules" placeholder="Településnév" class="form-control here" type="text" value="<?php if(isset($allandocimtelepules) && ($hiba == true)){echo $allandocimtelepules;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztneve" name="allandocimkoztneve" placeholder="Közterület neve" class="form-control here" type="text" value="<?php if(isset($allandocimkoztneve) && ($hiba == true)){echo $allandocimkoztneve;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                    <select id="allandocimkoztjellege" name="allandocimkoztjellege" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM kozterulet_jellege;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($allandocimkoztjellege) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = ".$allandocimkoztjellege.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($allandocimkoztjellege) &&  ($hiba == true)){ echo $allandocimkoztjellege. ' selected';} else {echo 0;}?>><?php if (isset($allandocimkoztjellege) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['kozterulet_jellege'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['kozterulet_jellege_id'].'">'.$sor['kozterulet_jellege'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allandocimkoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="allandocimkoztegyeb" name="allandocimkoztegyeb" placeholder="További adatok" class="form-control here" type="text" value="<?php if(isset($allandocimkoztegyeb) && ($hiba == true)){echo $allandocimkoztegyeb;} ?>">
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend>Tartózkodási hely</legend>
                            <div class="form-group row">
                                <label for="tarthelyirsz" class="col-4 col-form-label">Irányítószám</label> 
                                <div class="col-2">
                                    <input id="tarthelyirsz" name="tarthelyirsz" placeholder="" class="form-control here" type="text" value="<?php if(isset($tarthelyirsz) && ($hiba == true)){echo $tarthelyirsz;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelytelepules" class="col-4 col-form-label">Településnév</label> 
                                <div class="col-7">
                                    <input id="tarthelytelepules" name="tarthelytelepules" placeholder="Településnév" class="form-control here" type="text" value="<?php if(isset($tarthelytelepules) && ($hiba == true)){echo $tarthelytelepules;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztneve" class="col-4 col-form-label">Közterület neve</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztneve" name="tarthelykoztneve" placeholder="Közterület neve" class="form-control here" type="text" value="<?php if(isset($tarthelykoztneve) && ($hiba == true)){echo $tarthelykoztneve;} ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztjellege" class="col-4 col-form-label">Közterület jellege</label> 
                                <div class="col-7">
                                    <select id="tarthelykoztjellege" name="tarthelykoztjellege" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM kozterulet_jellege;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($tarthelykoztjellege) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM kozterulet_jellege WHERE kozterulet_jellege_id = ".$tarthelykoztjellege.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($tarthelykoztjellege) &&  ($hiba == true)){ echo $tarthelykoztjellege. ' selected';} else {echo 0;}?>><?php if (isset($tarthelykoztjellege) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['kozterulet_jellege'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['kozterulet_jellege_id'].'">'.$sor['kozterulet_jellege'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tarthelykoztegyeb" class="col-4 col-form-label">Épület/Házszám/Ajtó stb...</label> 
                                <div class="col-7">
                                    <input id="tarthelykoztegyeb" name="tarthelykoztegyeb" placeholder="További adatok" class="form-control here" type="text" value="<?php if(isset($tarthelykoztegyeb) && ($hiba == true)){echo $tarthelykoztegyeb;} ?>">
                                </div>
                            </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Egyéb adatok</legend>
                            
                        
                            <div class="form-group row">
                                <label for="sni" class="col-4 col-form-label">Sajátos nevelési igény</label> 
                                <div class="col-8" style="vertical-align: middle;margin:auto;">
                                    <input type="checkbox" id="sni"  name="checkboxlista[]" value="sni" <?php if(isset($sni) && ($sni == 1)){echo "checked";}?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="btmn" class="col-4 col-form-label">Beilleszkedési, tanulási, magatartási nehézség</label> 
                                <div class="col-8" style="vertical-align: middle;margin:auto;">
                                    <input type="checkbox" id="btmn"  name="checkboxlista[]" value="btmn" <?php if(isset($btmn) && ($btmn == 1)){echo "checked";}?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hh" class="col-4 col-form-label">Hátrányos helyzet</label> 
                                <div class="col-8" style="vertical-align: middle;margin:auto;">
                                    <input type="checkbox" id="hh"  name="checkboxlista[]" value="hh" <?php if(isset($hh) && ($hh == 1)){echo "checked";}?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hhh" class="col-4 col-form-label">Halmozottan hátrányos helyzet</label> 
                                <div class="col-8" style="vertical-align: middle;margin:auto;">
                                    <input type="checkbox" id="hhh"  name="checkboxlista[]" value="hhh" <?php if(isset($hhh) && ($hhh == 1)){echo "checked";}?>>
                                </div>
                            </div> 
                        
                            <div class="form-group row">
                                <label for="felekezet" class="col-4 col-form-label">Felekezet</label> 
                                <div class="col-7">
                                    <select id="felekezet" name="felekezet" class="custom-select">
                                        
                                        <?php
                                            $query = "SELECT * FROM felekezet;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($felekezet) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM felekezet WHERE felekezet_id = ".$felekezet.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($felekezet) &&  ($hiba == true)){ echo $felekezet. ' selected';} else {echo 0;}?>><?php if (isset($felekezet) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['felekezet_nev'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['felekezet_id'].'">'.$sor['felekezet_nev'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="csoport" class="col-4 col-form-label">Csoport</label> 
                                <div class="col-7">
                                    <select id="csoport" name="csoport" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM csoport;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($csoport) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM csoport WHERE csoport_id = ".$csoport.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($csoport) &&  ($hiba == true)){ echo $csoport. ' selected';} else {echo 0;}?>><?php if (isset($csoport) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['csoport_nev'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while($sor = mysqli_fetch_array($data)){
                                                if($sor['csoport_id'] != 6){
                                                    echo '<option value="'.$sor['csoport_id'].'">'.$sor['csoport_nev'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="etkat" class="col-4 col-form-label">Étkezési kategória</label> 
                                <div class="col-7">
                                    <select id="etkat" name="etkat" class="custom-select">
                                        <?php
                                            $query = "SELECT * FROM etkezesi_kategoria;";
                                            $data = mysqli_query($dbkapcs, $query);
                                            if (isset($etkat) &&  ($hiba == true)){
                                                $query2 = "SELECT * FROM etkezesi_kategoria WHERE etkezesi_kategoria_id = ".$etkat.";";
                                                $data2 = mysqli_query($dbkapcs, $query2);
                                                $sor2 = mysqli_fetch_array($data2);
                                            }
                                        ?>
                                        <option value=<?php if (isset($etkat) &&  ($hiba == true)){ echo $etkat. ' selected';} else {echo 0;}?>><?php if (isset($etkat) &&  ($hiba == true) && (mysqli_num_rows($data2) == 1)){ echo $sor2['etkezesi_kategoria_nev'];} else {echo "Nincs kiválasztva";}?></option>
                                        <?php
                                            while ($sor = mysqli_fetch_array($data)) {
                                                echo '<option value="'.$sor['etkezesi_kategoria_id'].'">'.$sor['etkezesi_kategoria_nev'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="megjegyzes" class="col-4 col-form-label">Megjegyzés</label> 
                                <div class="col-7">
                                    <textarea class="form-control" rows="2" id="megjegyzes" name="megjegyzes"><?php if(isset($megjegyzes) && ($hiba == true)){echo $megjegyzes;} ?></textarea>
                                </div>
                            </div>
                    </fieldset>

                    <div class="form-group row">
                        <label for="hh" class="col-2 col-form-label"></label> 
                        <div class="col-7" >
                            <button type="submit" id="submit" name="submit" class="btn btn-block btn-dark" placeholder="Rögzít" >Rögzít</button>
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
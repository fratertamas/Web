<?php
require_once('dbkapcsolat.php');
require_once('munkamenetinditasa.php');
$dbkapcs = mysqli_connect(DB_HOST, DB_FNEV, DB_JELSZO, DB_NEV)
            or die('Hiba a MySQL szerverhez való kapcsolódáskor!');
    $dbkapcs->query("SET NAMES utf8;");
    
$expkimenet = '';

if (isset($_POST['expsubmit'])) {
    
  
    if(isset($_POST['expdatum'])){
        if($_POST['expdatum'] == ""){
            $datum = ''.date("Y-m-d");
        }else{
            $datum = $_POST['expdatum'];
        }
    }else{
        $datum = ''.date("Y-m-d");
    }
    
    $query = 'SELECT f_csoport FROM felhasznalo WHERE felhasznalo_id = "'.$_SESSION['felhasznalo_id'].'";';
    $data = mysqli_query($dbkapcs, $query);
    $sor = mysqli_fetch_array($data);
    if(($_SESSION['beosztasnev'] == "intézményvezető") 
                    || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                    || ($_SESSION['beosztasnev'] == "óvodatitkár")){
        $csoportfeltetel =  " t_csoport IS NOT NULL ";
     }else{
        $csoportfeltetel =  " t_csoport = '".$sor['f_csoport']."' "; 
     }
    
    $query = 'SELECT t_oktatasi_azon, t_nev_elotag, t_vnev, t_knev, 
orszag_nev, 
t_szul_hely, t_szul_datum, 
ap1.allampolgarsag as alp1, ap2.allampolgarsag as alp2,
t_tajszam, t_neme, t_anya_nev_elotag, t_anya_nev, t_anya_telszam, t_anya_email, t_apa_nev_elotag, t_apa_nev, t_apa_telszam, t_apa_email, 
lakhely_tip,
tlp1.iranyitoszam as tlp1irsz, tlp1.telepulesnev as tlp1telepulesnev, t_allando_lc_kozterulet_neve, ktj1.kozterulet_jellege as ktj1, t_allando_lc_egyeb, 
tlp2.iranyitoszam as tlp2irsz, tlp2.telepulesnev as tlp2telepulesnev, t_tarthely_kozterulet_neve, ktj2.kozterulet_jellege as ktj2, t_tarthely_kozterulet_egyeb,
t_jogviszony_kezdete, t_jogviszony_vege, t_tankoteles_koru, t_sni, t_btmn, t_hh, t_hhh, 
csoport_nev, felekezet_nev, etkezesi_kategoria_nev, t_megjegyzes
FROM tanulo
INNER JOIN orszag ON t_szul_orszag = orszag_id
INNER JOIN allampolgarsag ap1 ON t_allampolgarsag_1 = ap1.allampolgarsag_id
LEFT JOIN allampolgarsag ap2 ON t_allampolgarsag_2 = ap2.allampolgarsag_id
INNER JOIN lakhely_tipus on lakhely_tip_id = t_lakhely_tip
LEFT JOIN telepules tlp1 ON t_allando_telepules_kod = tlp1.telepules_id
LEFT JOIN telepules tlp2 ON t_tarthely_telepules_kod = tlp2.telepules_id
LEFT JOIN kozterulet_jellege ktj1 ON t_allando_lc_kozterulet_jellege = ktj1.kozterulet_jellege_id
LEFT JOIN kozterulet_jellege ktj2 ON t_tarthely_kozterulet_jellege = ktj2.kozterulet_jellege_id
INNER JOIN csoport ON t_csoport = csoport_id
INNER JOIN felekezet ON t_felekezet = felekezet_id
INNER JOIN etkezesi_kategoria on t_etkezesi_kategoria = etkezesi_kategoria_id
WHERE '.$csoportfeltetel.' AND t_jogviszony_kezdete<"'.$datum.'" AND ("'.$datum.'"<t_jogviszony_vege OR t_jogviszony_vege = "0000-00-00")
ORDER BY t_vnev ASC, t_knev ASC;';
    $data = mysqli_query($dbkapcs, $query);
 
    if(($_SESSION['beosztasnev'] == "intézményvezető") 
       || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
       || ($_SESSION['beosztasnev'] == "óvodatitkár")){
       if(mysqli_num_rows($data) > 0){
           $expkimenet .= ''
                   . '<table class="table" bordered=1>'
                   . '<tr>'
                       . '<th></th>'
                       . '<th>Oktatási azonosító</th>'
                       . '<th>Tanuló neve</th>'
                       . '<th>Születési ország</th>'
                       . '<th>Születési hely</th>'
                       . '<th>Születési idő</th>'
                       . '<th>Állampolgárság 1.</th>'
                       . '<th>Állampolgárság 2.</th>'
                       . '<th>TAJ-szám</th>'
                       . '<th>Tanuló neme</th>'
                       . '<th>Édesanya neve</th>'
                       . '<th>Édesanya telefonszám</th>'
                       . '<th>Édesanya e-mail cím</th>'
                       . '<th>Édesapa neve</th>'
                       . '<th>Édesapa telefonszám</th>'
                       . '<th>Édesapa e-mail cím</th>'
                       . '<th>Lakhely típusa</th>'
                       . '<th>Irányítószám</th>'
                       . '<th>Településnév</th>'
                       . '<th>Közterület adatai</th>'
                       . '<th>Irányítószám</th>'
                       . '<th>Településnév</th>'
                       . '<th>Közterület adatai</th>'
                       . '<th>Jogviszony kezdete</th>'
                       . '<th>Jogviszony vege</th>'
                       . '<th>Tanköteles</th>'
                       . '<th>SNI</th>'
                       . '<th>BTMN</th>'
                       . '<th>HH</th>'
                       . '<th>HHH</th>'
                       . '<th>Csoport</th>'
                       . '<th>Felekezet</th>'
                       . '<th>Étkezési kategória</th>'
                       . '<th>Megjegyzés</th>'
                   . '</tr>';
           $i = 0;
           while ($sor = mysqli_fetch_array($data)){
               $i++;
               $nem = "nő";
               if($sor['t_neme'] != 0){
                   $nem = "férfi";
               }
               $jogviszonyvege = $sor['t_jogviszony_vege'];
               if($sor['t_jogviszony_vege'] == "0000-00-00"){
                   $jogviszonyvege = "";
               }
               $tankoteles="nem";
               if($sor['t_tankoteles_koru'] == 1){
                   $tankoteles = "igen";
               }
               $sni = "nem";
               if($sor['t_sni'] == 1){
                   $sni = "igen";
               }
               $btmn = "nem";
               if($sor['t_btmn'] == 1){
                   $btmn = "igen";
               }
               $hh = "nem";
               if($sor['t_hh'] == 1){
                   $hh="igen";
               }
               $hhh = "nem";
               if($sor['t_hhh'] == 1){
                   $hhh = "igen";
               }

               $expkimenet .= ''
                       . '<tr>'
                       . '<td>'.$i.'</td>'
                           . '<td>'.$sor['t_oktatasi_azon'].'</td>'
                       . '<td>'.$sor['t_nev_elotag'].' '.$sor['t_vnev'].' '.$sor['t_knev'].'</td>'
                       . '<td>'.$sor['orszag_nev'].'</td>'
                       . '<td>'.$sor['t_szul_hely'].'</td>'
                       . '<td>'.$sor['t_szul_datum'].'</td>'
                       . '<td>'.$sor['alp1'].'</td>'
                       . '<td>'.$sor['alp2'].'</td>'
                       . '<td>'.$sor['t_tajszam'].'</td>'
                       . '<td>'.$nem.'</th>'
                       . '<td>'.$sor['t_anya_nev_elotag'].' '.$sor['t_anya_nev'].'</td>'
                       . '<td>'.$sor['t_anya_telszam'].'</td>'
                       . '<td>'.$sor['t_anya_email'].'</td>'
                       . '<td>'.$sor['t_apa_nev_elotag'].' '.$sor['t_apa_nev'].'</td>'
                       . '<td>'.$sor['t_apa_telszam'].'</td>'
                       . '<td>'.$sor['t_apa_email'].'</td>'
                       . '<td>'.$sor['lakhely_tip'].'</td>'
                       . '<td>'.$sor['tlp1irsz'].'</td>'
                       . '<td>'.$sor['tlp1telepulesnev'].'</td>'
                       . '<td>'.$sor['t_allando_lc_kozterulet_neve'].' '.$sor['ktj1'].' '.$sor['t_allando_lc_egyeb'].'</td>'
                       . '<td>'.$sor['tlp2irsz'].'</td>'
                       . '<td>'.$sor['tlp2telepulesnev'].'</td>'
                       . '<td>'.$sor['t_tarthely_kozterulet_neve'].' '.$sor['ktj2'].' '.$sor['t_tarthely_kozterulet_egyeb'].'</td>'
                       . '<td>'.$sor['t_jogviszony_kezdete'].'</td>'
                       . '<td>'.$jogviszonyvege.'</td>'
                       . '<td>'.$tankoteles.'</td>'
                       . '<td>'.$sni.'</td>'
                       . '<td>'.$btmn.'</td>'
                       . '<td>'.$hh.'</td>'
                       . '<td>'.$hhh.'</td>'
                       . '<td>'.$sor['csoport_nev'].'</td>'
                       . '<td>'.$sor['felekezet_nev'].'</td>'
                       . '<td>'.$sor['etkezesi_kategoria_nev'].'</td>'
                       . '<td>'.$sor['t_megjegyzes'].'</td>'

                       . '</tr>';
           }
           $expkimenet .= '</table>';

           date_default_timezone_set('Europe/Budapest');

           header("Content-Type: application/xls");
           header("Content-Disposition: attachment, filename=Tanulo_".date("Y_m_d")."_".date("h_i").".xls");
           echo $expkimenet;
       }
   }else if($_SESSION['beosztasnev'] == "óvodapedagógus"){
       if(mysqli_num_rows($data) > 0){
           $expkimenet .= ''
                   . '<table class="table" bordered=1>'
                   . '<tr>'
                       . '<th></th>'
                       . '<th>Oktatási azonosító</th>'
                       . '<th>Tanuló neve</th>'
                       . '<th>Születési ország</th>'
                       . '<th>Születési hely</th>'
                       . '<th>Születési idő</th>'
                       . '<th>Állampolgárság 1.</th>'
                       . '<th>Állampolgárság 2.</th>'
                       . '<th>TAJ-szám</th>'
                       . '<th>Tanuló neme</th>'
                       . '<th>Édesanya neve</th>'
                       . '<th>Édesanya telefonszám</th>'
                       . '<th>Édesanya e-mail cím</th>'
                       . '<th>Édesapa neve</th>'
                       . '<th>Édesapa telefonszám</th>'
                       . '<th>Édesapa e-mail cím</th>'
                       . '<th>Irányítószám</th>'
                       . '<th>Településnév</th>'
                       . '<th>Közterület adatai</th>'
                       . '<th>Irányítószám</th>'
                       . '<th>Településnév</th>'
                       . '<th>Közterület adatai</th>'
                       . '<th>Jogviszony kezdete</th>'
                       . '<th>Jogviszony vege</th>'
                       . '<th>Tanköteles</th>'
                       . '<th>SNI</th>'
                       . '<th>BTMN</th>'
                       . '<th>HH</th>'
                       . '<th>HHH</th>'
                       . '<th>Megjegyzés</th>'
                   . '</tr>';
           $i = 0;
           while ($sor = mysqli_fetch_array($data)){
               $i++;
               $nem = "nő";
               if($sor['t_neme'] != 0){
                   $nem = "férfi";
               }
               $jogviszonyvege = $sor['t_jogviszony_vege'];
               if($sor['t_jogviszony_vege'] == "0000-00-00"){
                   $jogviszonyvege = "";
               }
               $tankoteles="nem";
               if($sor['t_tankoteles_koru'] == 1){
                   $tankoteles = "igen";
               }
               $sni = "nem";
               if($sor['t_sni'] == 1){
                   $sni = "igen";
               }
               $btmn = "nem";
               if($sor['t_btmn'] == 1){
                   $btmn = "igen";
               }
               $hh = "nem";
               if($sor['t_hh'] == 1){
                   $hh="igen";
               }
               $hhh = "nem";
               if($sor['t_hhh'] == 1){
                   $hhh = "igen";
               }

               $expkimenet .= ''
                       . '<tr>'
                       . '<td>'.$i.'</td>'
                           . '<td>'.$sor['t_oktatasi_azon'].'</td>'
                       . '<td>'.$sor['t_nev_elotag'].' '.$sor['t_vnev'].' '.$sor['t_knev'].'</td>'
                       . '<td>'.$sor['orszag_nev'].'</td>'
                       . '<td>'.$sor['t_szul_hely'].'</td>'
                       . '<td>'.$sor['t_szul_datum'].'</td>'
                       . '<td>'.$sor['alp1'].'</td>'
                       . '<td>'.$sor['alp2'].'</td>'
                       . '<td>'.$sor['t_tajszam'].'</td>'
                       . '<td>'.$nem.'</th>'
                       . '<td>'.$sor['t_anya_nev_elotag'].' '.$sor['t_anya_nev'].'</td>'
                       . '<td>'.$sor['t_anya_telszam'].'</td>'
                       . '<td>'.$sor['t_anya_email'].'</td>'
                       . '<td>'.$sor['t_apa_nev_elotag'].' '.$sor['t_apa_nev'].'</td>'
                       . '<td>'.$sor['t_apa_telszam'].'</td>'
                       . '<td>'.$sor['t_apa_email'].'</td>'
                       . '<td>'.$sor['tlp1irsz'].'</td>'
                       . '<td>'.$sor['tlp1telepulesnev'].'</td>'
                       . '<td>'.$sor['t_allando_lc_kozterulet_neve'].' '.$sor['ktj1'].' '.$sor['t_allando_lc_egyeb'].'</td>'
                       . '<td>'.$sor['tlp2irsz'].'</td>'
                       . '<td>'.$sor['tlp2telepulesnev'].'</td>'
                       . '<td>'.$sor['t_tarthely_kozterulet_neve'].' '.$sor['ktj2'].' '.$sor['t_tarthely_kozterulet_egyeb'].'</td>'
                       . '<td>'.$sor['t_jogviszony_kezdete'].'</td>'
                       . '<td>'.$jogviszonyvege.'</td>'
                       . '<td>'.$tankoteles.'</td>'
                       . '<td>'.$sni.'</td>'
                       . '<td>'.$btmn.'</td>'
                       . '<td>'.$hh.'</td>'
                       . '<td>'.$hhh.'</td>'
                       . '<td>'.$sor['t_megjegyzes'].'</td>'

                       . '</tr>';
           }
           $expkimenet .= '</table>';

           date_default_timezone_set('Europe/Budapest');

           header("Content-Type: application/xls");
           header("Content-Disposition: attachment, filename=Tanulo_".date("Y_m_d")."_".date("h_i").".xls");
           echo $expkimenet;
       }
   }else{
       
   }
}
?>

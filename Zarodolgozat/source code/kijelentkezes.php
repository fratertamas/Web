<?php
  // Ha a felhasználó be van jelentkezve, töröljük a munkamenet változót és kiléptetjük
  session_start();
  if (isset($_SESSION['felhasznalo_id'])) {
    // A $_SESSION tömböt kiűrítjük, ezáltal törlésre kerülnek a munkamenet változók
    $_SESSION = array();

    // Mivel a sütik alapján be lehet állítani a munkamenet változókat,
    // ezért a sütik lejárati idejét egy órával korábbra állítva megszüntetjük őket
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Munkamenetek megsemmisítése
    session_destroy();
  }

  // A felhasznalo_id és felhasználónév sütik törlése (egy órával korábbra állítással a lejárati időt)
  setcookie('felhasznalo_id', '', time() - 3600);
  setcookie('felhasznalonev', '', time() - 3600);

  // Átirányítjuk a felhasználót a kezdő bejelentkezési oldalra 
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  header('Location: ' . $home_url);
?>

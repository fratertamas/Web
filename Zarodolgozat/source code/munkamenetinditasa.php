<?php
  session_start();
  //Ha a munkamenet változók nincsenek beállítva, akkor megpróbáljuk a sütikkel beállítani
  if (!isset($_SESSION['felhasznalo_id'])) {
    if (isset($_COOKIE['felhasznalo_id']) && isset($_COOKIE['felhasznalonev'])) {
      $_SESSION['felhasznalo_id'] = $_COOKIE['felhasznalo_id'];
      $_SESSION['felhasznalonev'] = $_COOKIE['felhasznalonev'];
    }
  }
?>

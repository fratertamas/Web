<?php

?>
<div class="keret">
<!--Menü kezdete-->
<nav class="navigacio">
  <ul>
    <li>
        <a href="kezdolap.php">Kezdőlap</a>
    </li>
    <li>
      <a href="#">Saját adatok</a>
      <ul class="almenu sub-menu">
        <li>
            <a href="sajatadatok.php">Adatok megtekintése</a>
        </li>
        <li>
            <a href="jelszomodositasa.php">Jelszó módosítása</a>
        </li>
      </ul>
    </li>
    <?php
        if(isset($_SESSION['beosztasnev']) && ($_SESSION['beosztasnev'] == "intézményvezető")){?>
    <li>
      <a href="">Felhasználók</a>
      <ul class="almenu sub-menu">
        <li>
            <a href="felhasznalokkezelese.php">Felhasználók kezelése</a>
        </li>
        <li>
            <a href="felhasznalorogzitese.php">Felhasználó hozzáadása</a>
        </li>
      </ul>
        </li><?php }?>
    <li>
    <?php
        if(isset($_SESSION['beosztasnev']) && ($_SESSION['beosztasnev'] == "intézményvezető helyettes")){?>
    <li>
      <a href="felhasznalokkezelese.php">Felhasználók</a>
    </li>
    <?php }?>
    <li>
        <?php
        if(isset($_SESSION['beosztasnev']) && (($_SESSION['beosztasnev'] == "intézményvezető") 
                                           || ($_SESSION['beosztasnev'] == "intézményvezető helyettes")
                                           || ($_SESSION['beosztasnev'] == "óvodatitkár"))){?>
            <a href="">Tanulók</a>
            <ul class="almenu sub-menu">
              <li>
                <a href="tanuloklistaz.php">Tanulók listázása</a>
              </li>
              <li>
                  <a href="tanulorogzitese.php">Új tanuló adatainak felvitele</a>
              </li>
              <li>
                  <a href="tanuloexport.php">Exportálás</a>
        
        </li>
      </ul>
            <?php }else{?>
                <a href="tanuloklistaz.php">Tanulói adatok</a>
        <?php }?>
    </li>
    <li class="utolso">
      <a href="kijelentkezes.php">Kijelentkezés</a>
    </li>
  </ul>
</nav>
<!--Menü vége-->
</div>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>SEND+MORE=MONEY</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="formatum.css" />
        <link rel="stylesheet" type="text/css" href="formatumCsuszka.css" />
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="funkciok.js"></script>
    </head>
    <body>
        <div class="fokeret">
            <div class="bal">
                <?php
                    if (isset($_POST["rangeS"]) && isset($_POST["rangeE"]) &&
                    isset($_POST["rangeN"]) && isset($_POST["rangeD"]) &&
                    isset($_POST["rangeM"]) && isset($_POST["rangeO"]) &&
                    isset($_POST["rangeR"])){
                        $s=$_POST["rangeS"];
                        $e=$_POST["rangeE"];
                        $n=$_POST["rangeN"];
                        $d=$_POST["rangeD"];
                        $m=$_POST["rangeM"];
                        $o=$_POST["rangeO"];
                        $r=$_POST["rangeR"];
                        
                    }
                    
                ?>
                <table>
                    <tr>
                        <td></td>
                        <td>S</td>
                        <td>E</td>
                        <td>N</td>
                        <td>D</td>
                        
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <?php 
                                //kepKi($s);
                                if(isset($s)){
                                    echo "<img src=\"img/num$s.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                            <!--img src="img/full.png" /-->
                        </td>
                        <td>
                            <?php 
                                if(isset($e)){
                                    echo "<img src=\"img/num$e.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($n)){
                                    echo "<img src=\"img/num$n.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($d)){
                                    echo "<img src=\"img/num$d.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>+</td>
                        <td>M</td>
                        <td>O</td>
                        <td>R</td>
                        <td>E</td>
                    </tr>
                     <tr>
                        <td></td>
                        <td>
                            <?php 
                                if(isset($m)){
                                    echo "<img src=\"img/num$m.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($o)){
                                    echo "<img src=\"img/num$o.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($r)){
                                    echo "<img src=\"img/num$r.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($e)){
                                    echo "<img src=\"img/num$e.jpg\" />";
                                }else{
                                    echo '<img src="img/full.png" />';
                                }
                            ?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>O</td>
                        <td>N</td>
                        <td>E</td>
                        <td>Y</td>
                    </tr>
                     <tr>
                        <?php
                            function money($s,$e,$n,$d,$m,$o,$r){
                            
                            return $money;
                         }
                        ?>
                        <td><?php
                        if(isset($s) && isset($e) && isset($n) && isset($d) && 
                           isset($m) && isset($o) && isset($r)){
                            $send=$s.$e.$n.$d;
                            $more=$m.$o.$r.$e;
                            $money=$send+$more;
                            $moneystr = (string)$money;                            
                        }
                        if(isset($moneystr)){
                            if(strlen($moneystr)>4){
                                echo "<img src=\"img/num$moneystr[0].jpg\" />";
                            }else{
                                echo '';
//                                echo '<img src="img/full.png" />';
                            }
                        }else{
                            echo '<img src="img/full.png" />';
                        }  
                        ?>
                        </td>
                        <td>
                        <?php 
                            if(isset($moneystr)){
                                if(strlen($moneystr)>4){
                                    echo "<img src=\"img/num$moneystr[1].jpg\" />";
                                }else{
                                    echo "<img src=\"img/num$moneystr[0].jpg\" />";
                                }
                            }else{
                                echo '<img src="img/full.png" />';
                            }  
                        ?>
                        </td>
                        <td>
                        <?php 
                            if(isset($moneystr)){
                                if(strlen($moneystr)>4){
                                    echo "<img src=\"img/num$moneystr[2].jpg\" />";
                                }else{
                                    echo "<img src=\"img/num$moneystr[1].jpg\" />";
                                }
                            }else{
                                echo '<img src="img/full.png" />';
                            }  
                        ?>
                        </td>
                        <td>
                        <?php 
                            if(isset($moneystr)){
                                if(strlen($moneystr)>4){
                                    echo "<img src=\"img/num$moneystr[3].jpg\" />";
                                }else{
                                    echo "<img src=\"img/num$moneystr[2].jpg\" />";
                                }
                            }else{
                                echo '<img src="img/full.png" />';
                            }  
                        ?>
                        </td>
                        <td>
                        <?php 
                            if(isset($moneystr)){
                                if(strlen($moneystr)>4){
                                    echo "<img src=\"img/num$moneystr[4].jpg\" />";
                                }else{
                                    echo "<img src=\"img/num$moneystr[3].jpg\" />";
                                }
                            }else{
                                echo '<img src="img/full.png" />';
                            }  
                        ?>
                        </td>                     
                    </tr>
                </table>
            </div>
            <div class="jobb">
                <form id="bekuld" action="index.php" method="post" >
                    <fieldset  class="scheduler-border">
                        <legend  class="scheduler-border">Számok kiválasztása:</legend>
                        <table>
                        <tr>
                            <td class="jobbbetu">S</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeS" name="rangeS" min="0" max="9" value=<?php if(isset($s)){echo $s;}else{echo "5";} ?> style="width:10em" onchange="sInfo.value=value">
                                        <output id="sInfo"><?php if(isset($s)){echo $s;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                            <td class="jobbbetu">M</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeM" name="rangeM" min="0" max="9" value=<?php if(isset($m)){echo $m;}else{echo "5";} ?> style="width:10em" onchange="mInfo.value=value">
                                        <output id="mInfo"><?php if(isset($m)){echo $m;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                  </div>
                            </td>  
                        </tr>
                        <tr>
                            <td class="jobbbetu">E</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                          <input type="range" id="rangeE" name="rangeE" min="0" max="9" value=<?php if(isset($e)){echo $e;}else{echo "5";} ?> style="width:10em" onchange="eInfo.value=value">
                                        <output id="eInfo"><?php if(isset($e)){echo $e;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                            <td class="jobbbetu">O</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeO" name="rangeO" min="0" max="9" value=<?php if(isset($o)){echo $o;}else{echo "5";} ?> style="width:10em" onchange="oInfo.value=value">
                                        <output id="oInfo"><?php if(isset($o)){echo $o;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                        </tr>
                        <tr>
                            <td class="jobbbetu">N</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeN" name="rangeN" min="0" max="9" value=<?php if(isset($n)){echo $n;}else{echo "5";} ?> style="width:10em" onchange="nInfo.value=value">
                                        <output id="nInfo"><?php if(isset($n)){echo $n;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                            <td class="jobbbetu">R</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeR" name="rangeR" min="0" max="9" value=<?php if(isset($r)){echo $r;}else{echo "5";} ?> style="width:10em" onchange="rInfo.value=value">
                                        <output id="rInfo"><?php if(isset($r)){echo $r;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                        </tr>
                        <tr>
                            <td class="jobbbetu">D</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                        <input type="range" id="rangeD" name="rangeD" min="0" max="9" value=<?php if(isset($d)){echo $d;}else{echo "5";} ?> style="width:10em" onchange="dInfo.value=value">
                                        <output id="dInfo"><?php if(isset($d)){echo $d;}else{echo '5';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                            <td class="jobbbetu">E</td>
                            <td style="font-size: 1em;">
                                <div class="row" style="margin: auto;">
                                    <div class="col-xs-6">
                                      <div class="range range-info">
                                          <input type="range" name="range" min="0" max="9" value=<?php if(isset($e)){echo $e;}else{echo "5";} ?> style="width:10em" onchange="eInfo.value=value" disabled="on">
                                          <output><?php if(isset($e)){echo $e;}else{echo '-';} ?></output>
                                      </div>
                                    </div>
                                    
                                  </div>
                            </td>  
                        </tr>   
                    </table>                    
                          <br />                        
                          <input class="btn btn-primary" type="submit" value="Elküld">
                    </fieldset>
                </form>
            </div>
        </div>
        <?php
            if (isset($_POST["rangeS"])) {
                //$s = $_POST["rangeS"];
                echo "<script>ellenoriz();</script>";
            }
        ?>  
    </body>
</html>  
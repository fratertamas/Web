/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function szamol(){
    var moneyErtek= parseInt(sendErtek())+parseInt(moreErtek());
    //window.alert("Money értéke: "+moneyErtek);       
    return moneyErtek;     
}
function sendErtek(){
    sErtek=document.getElementById("rangeS").value;
    eErtek=document.getElementById("rangeE").value;
    nErtek=document.getElementById("rangeN").value;
    dErtek=document.getElementById("rangeD").value;
    sendErtek=sErtek+eErtek+nErtek+dErtek;
    //window.alert("Send értéke: "+sendErtek);
    return sendErtek;
}
function moreErtek(){
    mErtek=document.getElementById("rangeM").value;
    oErtek=document.getElementById("rangeO").value;
    rErtek=document.getElementById("rangeR").value;
    moreErtek=mErtek+oErtek+rErtek+eErtek;
    //window.alert("More értéke: "+moreErtek);
    return moreErtek;
}
function ellenorizIsmetlodes(){
    var szamok = [0,0,0,0,0,0,0,0,0,0];
    var ertekek = [sErtek, eErtek,nErtek,dErtek,mErtek,oErtek,rErtek];
    for (var i = 0; i < ertekek.length; i++) {
        szam=ertekek[i];
        szamok[szam]++;
    }
    var ismetlodes = false
    for(var i=0;i<szamok.length;i++){
	if(szamok[i]>1){
            ismetlodes = true;
        }
    }
    return ismetlodes;
}
function ellenorizBetuk(){
    betuIsmetlodes = false;
    num = parseInt(sendErtek)+parseInt(moreErtek);
    numstr=''+num
    //window.alert("MONEY: "+numstr.length);
    if(numstr.length>4){
        if((moreErtek[0] == numstr[0]) && (moreErtek[1] == numstr[1]) 
                && (sendErtek[2] == numstr[2]) && (sendErtek[1] == numstr[3])){
            //window.alert("NAGYOBB 4 és a betűk jó ág!");
            betuIsmetlodes = true;
        }else{
            //window.alert("NAGYOBB 4 és a betűk rossz ág!");
            betuIsmetlodes = false;
        }
    }else{
        if((moreErtek[1] == numstr[0]) && (sendErtek[2] == numstr[1]) 
            && (sendErtek[1] == numstr[2])){  
            //window.alert("KISEBB 4 és a betűk jó ág!");
            betuIsmetlodes = true;
        }else{
            //window.alert("KISEBB 4 és a betűk rossz ág!");
            betuIsmetlodes = false;
            
        }
    }
    //window.alert("BISM ertek: "+betuIsmetlodes);
    return betuIsmetlodes;
}

function ellenoriz(){
    //window.alert("ellenőrzés indul...");    
    if((szamol()) && (ellenorizIsmetlodes() == false) && (ellenorizBetuk() == true)){
        alert("Sikeres megoldás!");
        return true;
    }else{
        if(ellenorizIsmetlodes() == true){
            //alert("Van-e ismétlődés? - "+ellenorizIsmetlodes());
            //alert("ELL B: "+ellenorizBetuk());
            //window.alert(ellenorizErtekek());
            alert("Ismétlődés van! A betűk értékének megadásánál több egymástól különböző betűhöz is ugyanazt a számot rendelte. Valamennyi betû egy-egy 0-tól 9-ig terjedõ számjegyet jelölhet, azonos betű ugyanazt a számot kell jelölje.");
            return false;      
        }else{
            alert("Hiba az összegben! Az összegben kapott (MONEY) betűkhöz rendelt értékek nem egyeznek, az értékeket úgy adja meg, hogy azonos betű ugyanazt a számot kell jelölje!");
            return false;
        }
    }           
}


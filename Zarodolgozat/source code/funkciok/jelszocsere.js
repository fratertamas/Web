$(document).ready(function(){
    $(document.getElementById("ujJelszo1")).keyup(function() {
        var jelszo = $(this).val();
        var jelszovizsgalat = false;

        //a hossznak az ellenőrzése
        if ( jelszo.length < 8 ) {
                $('#hossz').removeClass('ervenyes').addClass('ervenytelen');
                $jelszovizsgalat=false;
        } else {
                $('#hossz').removeClass('ervenytelen').addClass('ervenyes');
                $jelszovizsgalat=true;
        }

        //betű ellenőrzése
        if ( jelszo.match(/[A-z]/) ) {
                $('#betu').removeClass('ervenytelen').addClass('ervenyes');
                $jelszovizsgalat=true;
        } else {
                $('#betu').removeClass('ervenyes').addClass('ervenytelen');
                $jelszovizsgalat=false;
        }

        //nagybetű ellenőrzése
        if ( jelszo.match(/[A-Z]/) ) {
                $('#nagybetu').removeClass('ervenytelen').addClass('ervenyes');
                $jelszovizsgalat=true;
        } else {
                $('#nagybetu').removeClass('ervenyes').addClass('ervenytelen');
                $jelszovizsgalat=false;
        }

        //szám ellenőrzése
        if ( jelszo.match(/\d/) ) {
                $('#szam').removeClass('ervenytelen').addClass('ervenyes');
                $jelszovizsgalat=true;
        } else {
                $('#szam').removeClass('ervenyes').addClass('ervenytelen');
                $jelszovizsgalat=false;
        }
    });
    $('#ujJelszo1, #ujJelszo2').on('keyup', function () {
        if (($('#ujJelszo1').val() == $('#ujJelszo2').val()) && ($jelszovizsgalat == true)) {
            $('#egyezes').html('A jelszavak megegyeznek').css('color', 'green');
            $('#submit').removeAttr('disabled');
        } else{
            $('#egyezes').html('A jelszavak nem egyeznek meg, vagy a megfogalmazott feltételek valamelyike nem teljesül!').css('color', 'red');
        }
    });
      
});


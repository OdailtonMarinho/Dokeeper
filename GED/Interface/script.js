$(document).ready(function(){
    $('#config').click(function(){
        $('.panel').slideToggle('slow');
        });
    $('.panel').click(function(){
        $('.panel').slideToggle('slow');
        });
    });

$(document).ready(function(){
    $('#cadnivel').click(function(){
		$('.panel2').slideToggle('slow');
	});     
    $('#entrar').click(function(){
	        $('.panel2').slideToggle('slow');
	    });
    });
	    
	    
$(document).ready(function(){
    $('#adddoc').click(function(){
        $('.panel3').slideToggle('slow');
    });     
    $('#entrar').click(function(){
            $('.panel3').slideToggle('slow');
        });
    });

$(document).ready(function(){
    $('#editnivel').click(function(){
        $('.panel4').slideToggle('slow');
    });     
    $('#entrar').click(function(){
            $('.panel4').slideToggle('slow');
        });
    });

$(document).ready(function(){
    $('#req').click(function(){
        $('.panel5').slideToggle('slow');
    });     
    $('#req').click(function(){
            $('#entrar1').slideToggle('slow');
        });
    });

$(document).ready(function(){
    $('.sob').click(function(){
        $('.panel6').slideToggle('slow');
    });     
    $('.sob').click(function(){
            $('#entrar').slideToggle('slow');
        });
    });

$(document).ready(function(){
    $(".lista").dropper({
        action: "mandarPoDB.php"
    });
});
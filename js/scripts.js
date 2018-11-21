// ANIMATION MENU AND MENU BUTTON
			$(document).ready(function(){
				$('#nav-icon3').click(function(){
					$("#nav-icon3").toggleClass('open');
					$("#Menu-Left").toggleClass("show");
				});
				
				// SCRIPT MENU LINE E PULSE1 -->
				
				$("#home").hover(function(){
					$("#linea").addClass('BarraHome');
					$(this).addClass('animated pulse1');
				}, function(){
					$("#linea").removeClass('BarraHome');
					$(this).removeClass('animated pulse1');
				});		
				$("#modulo").hover(function(){
					$("#linea").addClass('BarraModulo');
					$(this).addClass('animated pulse1');
				}, function(){
					$("#linea").removeClass('BarraModulo');
					$(this).removeClass('animated pulse1');
				});
			});
				
//<!-- SCRIPT SCORRIMENTO MENUBUTTON AL CARICAMENTO PAGINA -->	
// MENU BUTTON EFFECT ON PAGE LOAD

	$(document).ready(function(){
		$('.MenuButton').addClass('animated bounceInRight').delay(300).queue(function(){
			$('.MenuButton').removeClass('animated bounceInRight');
		});

	});

// EXPORT PROPRIETIES
    function export_transictions()
{
    var conf = confirm("Export all transictions to CSV?");
    if(conf == true)
    {
        window.open("export.php?transictions", '_self');
    }
}
function export_cr()
{
    var conf = confirm("Export Customer Report to CSV?");
    if(conf == true)
    {
        window.open("export.php?c_report", '_self');
    }
}
//EDIT STATUS MODE ALERT
function edit_mode()
{
	alert('WARNING: You are going into Edit Mode');
}

// CHANGES PAGE ON VALUE CHANGE
function change_invoice_page(){
	var x = document.getElementById("sel_page").value;
	window.location.href = "index.php?page="+x;
}
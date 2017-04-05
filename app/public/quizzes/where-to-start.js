var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

const NumSets = 2;
var CurrentSet = 1;

$j(document).on('click', '#nextbut', function () {

	CurrentSet++;

	$j('.set' + (CurrentSet-1)).fadeOut(200, function() {
        $j('.set' + CurrentSet).fadeIn(200);
    });

    var formPos = $j('#quiz-form').offset();
    var formPos2 = formPos.top;

    $j('html, body').animate({ scrollTop: formPos2 - 60 }, 500);

	if (CurrentSet == 2){
        $j('.setprev').show();
    }

	if (CurrentSet == NumSets) {
        $j('.setnext').hide();
        $j('.setres').show();
    }

});

$j(document).on('click', '#prevbut', function () {

	CurrentSet--;

	$j('.set' + (CurrentSet+1)).fadeOut(200, function() {
        $j('.set' + CurrentSet).fadeIn(200);
    });

    var formPos = $j('#quiz-form').offset();
    var formPos2 = formPos.top;

    $j('html, body').animate({ scrollTop: formPos2 - 60 }, 500);

	if (CurrentSet == 1){
        $j('.setnext').show();
    }

	if (CurrentSet < NumSets) {
        $j('.setres').hide();
    }

});

$j(document).on('click', '#submbut', function () {

	$j('#quiz-form').attr("action", "where-to-start-summary.html");
	$j('#quiz-form').submit();

});

$j(document).on('click', '#submbut-detail', function () {

	$j('#summary-form').attr("action", "where-to-start-results.html");
	$j('#summary-form').submit();

});
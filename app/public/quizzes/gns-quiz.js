var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

const NUM_QUESTIONS = 29;
const NumSets = 11;
const ProgressBarInterval = 100 / NumSets;
var CurrentSet = 1;
const G = 0;
const N = 1;
const S = 2;
const G_MAX_PTS = 75
const N_MAX_PTS = 75;
const S_MAX_PTS = 75;
// answer array
var answers = new Array(NUM_QUESTIONS);
for (i=0; i < NUM_QUESTIONS; i++) {
	answers[i] = new Array(3);
	answers[i][G] = 0;
	answers[i][N] = 0;
	answers[i][S] = 0;		
}

$j( document ).ready(function() {

});

$j(document).on('click', '#nextbut', function () {

	CurrentSet++;

	$j('.set' + (CurrentSet-1)).fadeOut(200, function() {
        $j('.set' + CurrentSet).fadeIn(200);
    });

    var progressValue = CurrentSet - 1;

    $j('.progress-tick').animate({
		left: (progressValue * ProgressBarInterval) + '%'
    }, { duration: 300, queue: false });

    $j('.progress-bar').animate({
        width: (progressValue * ProgressBarInterval) + '%'
    }, { duration: 300, queue: false });

    $j('.progress-tick').html(Math.round(progressValue * ProgressBarInterval) + '%');

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
	
	var progressValue = CurrentSet - 1;

    $j('.progress-tick').animate({
		left: (progressValue * ProgressBarInterval) + '%'
    }, { duration: 300, queue: false });

    $j('.progress-bar').animate({
        width: (progressValue * ProgressBarInterval) + '%'
    }, { duration: 300, queue: false });

    $j('.progress-tick').html(Math.round(progressValue * ProgressBarInterval) + '%');

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

    var sliderWidth = $j('.progress').width();

    $j('.progress-tick').animate({
		left: (sliderWidth - 21) + 'px'
    }, 300);

    $j('.progress-bar').animate({
        width: '100%'
    }, 300);

    $j('.progress-tick').html('100%');

	$j('#submbut').html('<span>PLEASE WAIT...</span>');
	$j("#submbut").attr('disabled','disabled');
	
	var geekPoints = 0;
	var nerdPoints = 0;
	var suitPoints = 0;
	var geekScore = 0;
	var nerdScore = 0;
	var suitScore = 0;
	// tally points
	for (q = 0; q < NUM_QUESTIONS; q++) { 
		geekPoints = geekPoints + answers[q][G];
		nerdPoints = nerdPoints + answers[q][N];
		suitPoints = suitPoints + answers[q][S];
	}
	geekScore = Math.round(100 * geekPoints / G_MAX_PTS);
	nerdScore = Math.round(100 * nerdPoints / N_MAX_PTS);
	suitScore = Math.round(100 * suitPoints / S_MAX_PTS);
	
// 	alert('Geek score: ' + geekScore + ', Nerd score: ' + nerdScore + ', Suit score: ' + suitScore);
	
	var gns_result;
	if (geekScore == Math.max(geekScore, nerdScore, suitScore)){
		gns_result = "geek";
	}
	else if (nerdScore == Math.max(geekScore, nerdScore, suitScore)){
		gns_result = "nerd";
	}
	else if (suitScore == Math.max(geekScore, nerdScore, suitScore)){
		gns_result = "suit";
	}
	
	var result_url;
	result_url = gns_result + ".html?g=" + geekScore + "&n=" + nerdScore + "&s=" + suitScore;

	$j('#quiz-form').attr("action", result_url);
	$j('#quiz-form').submit();

});

function setAnswer(question, cat, newval) {
//     $j('#a' + index).val(newval);
//     answers[index-1, cat] = newval;
	answers[question-1][cat] = newval;
//     alert('q: ' + index + ', cat: ' + cat + ', val: ' + newval);
}

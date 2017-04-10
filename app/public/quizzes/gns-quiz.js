var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

const NUM_QUESTIONS = 29;
const NumSets = 11;
const ProgressBarInterval = 100 / NumSets;
var CurrentSet = 1;
const G = 0;
const N = 1;
const S = 2;
// Define maximum possible points for Geek, Nerd, and Suit,
//	excluding the tiebreaker question
const G_MAX_PTS = 70
const N_MAX_PTS = 70;
const S_MAX_PTS = 70;
// Question 26 (functional areas) is the tiebreaker question
const TIEBREAKER_INDEX = 25; // answer array is zero-based
const TIEBREAKER_PTS = 1; // in case of tiebreaker, we give winner one additional point
// answer array
var answer_points = new Array(NUM_QUESTIONS);
for (i=0; i < NUM_QUESTIONS; i++) {
	answer_points[i] = new Array(3);
	answer_points[i][G] = 0;
	answer_points[i][N] = 0;
	answer_points[i][S] = 0;
}

$j( document ).ready(function() {

});

$j(document).on('click', '#nextbut', function () {

	// verify all questions in current set have been answered
	if( !isSetComplete(CurrentSet) ){
		$j('.missing_response_error').show();
		$j('.missing_response_error').fadeOut(4000);
		return false;
	}

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

	// verify all questions in current set have been answered
	if( !isSetComplete(CurrentSet) ){
		$j('.missing_response_error').show();
		$j('.missing_response_error').fadeOut(4000);
		return false;
	}

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
		if (q != TIEBREAKER_INDEX){
			geekPoints = geekPoints + answer_points[q][G];
			nerdPoints = nerdPoints + answer_points[q][N];
			suitPoints = suitPoints + answer_points[q][S];
		}
	}
	geekScore = Math.round(100 * geekPoints / G_MAX_PTS);
	nerdScore = Math.round(100 * nerdPoints / N_MAX_PTS);
	suitScore = Math.round(100 * suitPoints / S_MAX_PTS);
	
// 	alert('Geek score: ' + geekScore + ', Nerd score: ' + nerdScore + ', Suit score: ' + suitScore);
	
	var gns_result;
	if (geekScore > Math.max(nerdScore, suitScore) || 
		(geekScore == Math.max(nerdScore, suitScore) && answer_points[TIEBREAKER_INDEX][G] > 0) ) {
		gns_result = "geek";
		if (geekScore == Math.max(nerdScore, suitScore) ) {
			geekScore = geekScore + TIEBREAKER_PTS;
		}
	}
	else if (nerdScore > Math.max(geekScore, suitScore) || 
		(nerdScore == Math.max(geekScore, suitScore) && answer_points[TIEBREAKER_INDEX][N] > 0) ) {
		gns_result = "nerd";
		if (nerdScore == Math.max(geekScore, suitScore) ) {
			nerdScore = nerdScore + TIEBREAKER_PTS;
		}
	}
	else if (suitScore > Math.max(geekScore, nerdScore) || 
		(suitScore == Math.max(geekScore, nerdScore) && answer_points[TIEBREAKER_INDEX][S] > 0) ) {
		gns_result = "suit";
		if (suitScore == Math.max(geekScore, nerdScore) ) {
			suitScore = suitScore + TIEBREAKER_PTS;
		}
	}
	
	var result_url;
	result_url = gns_result + ".html?g=" + geekScore + "&n=" + nerdScore + "&s=" + suitScore;

	$j('#quiz-form').attr("action", result_url);
	$j('#quiz-form').submit();

});

function isSetComplete(setIndex){
	// ranking questions
	var rank_questions = $j('.set' + setIndex + ' .btn-group' );
	for (i=0; i < rank_questions.length; i++){
		if( $j(rank_questions[i]).find('.active').length == 0 ){
			return false;
		}
  	}
  	// multiple choice questions
	var multichoice_questions = $j('.set' + setIndex + ' .multi_choice' );
	for (i=0; i < multichoice_questions.length; i++){
		if( $j(multichoice_questions[i]).find('input:checked').length == 0 ){
			return false;
		}
  	}
	return true;
}

function setAnswer(question, cat, newval) {
	answer_points[question-1][cat] = newval;
}

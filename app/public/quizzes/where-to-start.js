var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

const NUM_CHAPTERS = 15;
const NumSets = 2;
const BIZ_CHALLENGE = 0;
const CUSTOMER_CHALLENGE = 1;
const NUM_BUCKETS = 5;

var CurrentSet = 1;

// chapter_scores
var chapter_scores = new Array(NUM_CHAPTERS);
for (i=0; i < NUM_CHAPTERS; i++) {
	chapter_scores[i] = new Array(2);
	chapter_scores[i][BIZ_CHALLENGE] = 0;
	chapter_scores[i][CUSTOMER_CHALLENGE] = 0;
}

$j(document).on('click', '#nextbut', function () {

	CurrentSet++;

	$j('.set' + (CurrentSet-1)).fadeOut(200, function() {
        $j('.set' + CurrentSet).fadeIn(200);
    });

    $j('html, body').animate({ scrollTop: 0}, 500);

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


    $j('html, body').animate({ scrollTop: 0}, 500);

	if (CurrentSet == 1){
        $j('.setnext').show();
    }

	if (CurrentSet < NumSets) {
        $j('.setres').hide();
    }

});

$j(document).on('click', '#goto-summary', function () {

// 	$j('#quiz-form').attr("action", "where-to-start-summary.html");
// 	$j('#quiz-form').submit();

	$j('.quiz').hide();
	createResultSummaryTable();
	$j('.result-summary').show();	
	$j('html, body').animate({ scrollTop: 0}, 500);

});

$j(document).on('click', '#goto-detail', function () {

// 	$j('#summary-form').attr("action", "where-to-start-results.html");
// 	$j('#summary-form').submit();

	$j('.result-summary').hide();	
	createResultDetailTable();
	$j('.result-detail').show();	
	$j('html, body').animate({ scrollTop: 0}, 500);

});

$j(document).on('click', '#back-to-summary', function () {

	$j('.result-detail').hide();
	$j('.result-summary').show();	
	$j('html, body').animate({ scrollTop: 0}, 500);

});

function setChapterScore(chapter, cat, newval) {
	chapter_scores[chapter-1][cat] = parseInt(newval);
}

function createResultSummaryTable() {

 var myTableDiv = document.getElementById("summary-table-container");
 var table = document.createElement('TABLE');
 var tableBody = document.createElement('TBODY');

 table.border = '1'
 table.appendChild(tableBody);
 
 var heading = new Array(NUM_BUCKETS);
 heading[0] = "10: NON-NEGOTIABLES";
 heading[1] = "8-9: BURNING HOT";
 heading[2] = "6-7: NICE-TO-HAVES";
 heading[3] = "1 - 5: BACKBURNER";
 heading[4] = "0: NOTHING TO DO";
 
 var chapter_titles = new Array(NUM_CHAPTERS);
 chapter_titles[0] = "I Can’t Prove Value Without Investing First";
 chapter_titles[1] = "Nice To Meet You Again, Again";
 chapter_titles[2] = "Practice Dating Your Customers";
 chapter_titles[3] = "Help, I’m Drowning In Data";
 chapter_titles[4] = "We Don’t Need Data Because Our Products Are Amazing";
 chapter_titles[5] = "You Are Not Your Customer";
 chapter_titles[6] = "Let’s Focus On These 11 Things";
 chapter_titles[7] = "Illumination Doesn’t Come From A Tiny Flashlight";
 chapter_titles[8] = "Averages Are Evil";
 chapter_titles[9] = "The Funnel To Nowhere";
 chapter_titles[10] = "Hello, We’d Like To Remind You That We Send Emails";
 chapter_titles[11] = "Test And Learn Shouldn’t Hurt";
 chapter_titles[12] = "Let’s Get Personal";
 chapter_titles[13] = "Marketing Is Just The Invitation To The Party";
 chapter_titles[14] = "Loyalty Is Not A Program";

 var bucket_chapters = new Array(NUM_BUCKETS);
 var chapters_per_bucket = new Array(NUM_BUCKETS);
 for (i=0; i < NUM_BUCKETS; i++) {
 	bucket_chapters[i] = new Array(NUM_CHAPTERS);
 	chapters_per_bucket[i] = 0;
 	for(j=0; j < NUM_CHAPTERS; j++) {
 		bucket_chapters[i][j] = "";
 		chapters_per_bucket[i] = 0;
 	}
 }
 
 for (chapter_index=0; chapter_index < NUM_CHAPTERS; chapter_index++) {
	var bucket_index;
 	switch(chapter_scores[chapter_index][BIZ_CHALLENGE] + chapter_scores[chapter_index][CUSTOMER_CHALLENGE]) {
		case 0:
			bucket_index = 4;
			break;			
		case 1: case 2: case 3: case 4: case 5:
			bucket_index = 3;
			break;
		case 6: case 7:
			bucket_index = 2;
			break;
		case 8: case 9:
			bucket_index = 1;
			break;
		case 10:
			bucket_index = 0;
			break;
	}
	bucket_chapters[bucket_index][chapters_per_bucket[bucket_index]] = chapter_titles[chapter_index];
	chapters_per_bucket[bucket_index]++;
 }

 //TABLE HEADER
 var tr = document.createElement('TR');
 tr.className = 'header';
 tableBody.appendChild(tr);
 for (i = 0; i < heading.length; i++) {
	 var th = document.createElement('TH')
	 th.className = 'col-md-2';
	 th.appendChild(document.createTextNode(heading[i]));
	 tr.appendChild(th);
 }

 // TABLE ROWS
 for (row_index = 0; row_index < Math.max.apply(null, chapters_per_bucket); row_index++) {
  var tr = document.createElement('TR');
  for (bucket_index = 0; bucket_index < NUM_BUCKETS; bucket_index++) {
	  var td = document.createElement('TD');
	  td.appendChild(document.createTextNode(bucket_chapters[bucket_index][row_index]));
	  tr.appendChild(td);
  }
  tableBody.appendChild(tr);
 }

 myTableDiv.appendChild(table);

}

function createResultDetailTable() {
 // <table class="table">
//    <thead>
// 	<tr class="header">
// 	 <th class="col-md-1"><h1>CHAPTER</h1></th>
// 	 <th class="col-md-4">
// 	   <h1>BUSINESS CHALLENGE</h1>
// 	 </th>
// 	 <th class="col-md-1"><h1>YOUR SCORE</h1></th>
// 	 <th class="col-md-4">
// 	   <h1>CUSTOMER CHALLENGE</h1>	  	
// 	 </th>
// 	 <th class="col-md-1"><h1>YOUR SCORE</h1></th>
// 	 <th class="col-md-1"><h1>TOTAL</h1></th>
// 	</tr>
//    </thead>	 
//    
//   </table>

}
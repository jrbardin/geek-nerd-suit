var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

const NUM_CHAPTERS = 15;
const CHAPTER_TITLES = new Array(NUM_CHAPTERS);
CHAPTER_TITLES[0] = "I Can’t Prove Value Without Investing First";
CHAPTER_TITLES[1] = "Nice To Meet You Again, Again";
CHAPTER_TITLES[2] = "Practice Dating Your Customers";
CHAPTER_TITLES[3] = "Help, I’m Drowning In Data";
CHAPTER_TITLES[4] = "We Don’t Need Data Because Our Products Are Amazing";
CHAPTER_TITLES[5] = "You Are Not Your Customer";
CHAPTER_TITLES[6] = "Let’s Focus On These 11 Things";
CHAPTER_TITLES[7] = "Illumination Doesn’t Come From A Tiny Flashlight";
CHAPTER_TITLES[8] = "Averages Are Evil";
CHAPTER_TITLES[9] = "The Funnel To Nowhere";
CHAPTER_TITLES[10] = "Hello, We’d Like To Remind You That We Send Emails";
CHAPTER_TITLES[11] = "Test And Learn Shouldn’t Hurt";
CHAPTER_TITLES[12] = "Let’s Get Personal";
CHAPTER_TITLES[13] = "Marketing Is Just The Invitation To The Party";
CHAPTER_TITLES[14] = "Loyalty Is Not A Program";

const NUM_SETS = 2;
const BIZ_CHALLENGE = 0;
const CUSTOMER_CHALLENGE = 1;
const NUM_BUCKETS = 5;

const BIZ_CHALLENGES = [
 "Nobody will fund anything because they don’t believe it will work",
 "Our systems aren’t integrated, so we can’t track customers across channels",
 "We don’t have a formal plan for what customer data to collect",
 "We have so much data, but aren’t doing anything useful with it",
 "Our team doesn’t consider customer insight when making decisions",
 "Our executives aren’t in touch with our customers",
 "We have too many priorities, and don’t know where to focus",
 "We rely too heavily on a single source of customer insight",
 "We know customers in aggregate, but not as individuals",
 "We focus on acquisition, but not retention",
 "We aren’t managing the frequency of communication across all channels",
 "We don’t have a test and learn program that ends up making a difference",
 "Our personalization efforts aren’t very good",
 "We aren’t managing the end-to-end customer experience",
 "We don’t have a good way to measure how loyal our customers are"
];
const CUSTOMER_CHALLENGES = [
 "This company’s systems are outdated and frustrating",
 "This company doesn’t seem to remember me",
 "This company seems to ask me for random or irrelevant information",
 "This company knows a lot about me, but doesn’t seem to use any of it",
 "I think this company makes decisions without considering my personal interests",
 "It seems like the leaders running this business don’t know who I am or what I value",
 "It seems like this company is a bit all over the place when it comes to priorities",
 "This company seems to know one thing about me, and one thing only",
 "I seem to just get lumped in with other customers, rather than being seen as an individual",
 "This company spent a lot of time trying to get me to make a purchase, but I haven’t heard from them since",
 "I seem to be getting bombarded with marketing that has no rhyme or reason to it",
 "This company seems to keep doing the same things over and over again, and they don’t work",
 "This company hardly personalizes anything, and gets it wrong when they try",
 "This company is inconsistent in how it treats me across channels or over time",
 "I feel like I’m not being recognized or rewarded for my loyalty"
];

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

	if (CurrentSet == NUM_SETS) {
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

	if (CurrentSet < NUM_SETS) {
        $j('.setres').hide();
    }

});

$j(document).on('click', '#goto-summary', function () {

	$j('.quiz').hide();
	createResultSummaryTables();
	$j('.result-summary').show();	
	$j('html, body').animate({ scrollTop: 0}, 500);

});

$j(document).on('click', '#goto-detail', function () {

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

// -------------------------------------
// FUNCTION: setChapterScore 
// -------------------------------------
function setChapterScore(chapter, cat, newval) {
	chapter_scores[chapter-1][cat] = parseInt(newval);
}

// -------------------------------------
// FUNCTION: createResultSummaryTables 
// -------------------------------------
function createResultSummaryTables() {

 // SUMMARY TABLE
 var myTableDiv = document.getElementById("summary-table-container");
 $j('#summary-table-container').empty();
 var table = document.createElement('TABLE');
 var tableBody = document.createElement('TBODY');

 table.border = '1';
 table.width = '100%';
 table.appendChild(tableBody);
 
 var heading = new Array(NUM_BUCKETS);
 heading[0] = "10: NON-NEGOTIABLES";
 heading[1] = "8-9: BURNING HOT";
 heading[2] = "6-7: NICE-TO-HAVES";
 heading[3] = "1 - 5: BACKBURNER";
 heading[4] = "0: NOTHING TO DO";

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
	bucket_chapters[bucket_index][chapters_per_bucket[bucket_index]] = 
	 "Ch. " + (chapter_index+1) + ": " + CHAPTER_TITLES[chapter_index];
	chapters_per_bucket[bucket_index]++;
 }

 //TABLE HEADER
 var tr = document.createElement('TR');
 tr.className = 'header';
 tableBody.appendChild(tr);
 for (i = 0; i < heading.length; i++) {
	 var th = document.createElement('TH');
	 th.className = 'col-xs-2';
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

 // CUSTOMER HOT BUTTON TABLE
 var myTableDiv = document.getElementById("hotbuttons-table-container");
 $j('#hotbuttons-table-container').empty();

 var cust_hotbutton_chapters = [];
 for (chapter_index=0; chapter_index < NUM_CHAPTERS; chapter_index++) {
  if (chapter_scores[chapter_index][CUSTOMER_CHALLENGE] == 5) {
   cust_hotbutton_chapters.push(chapter_index);
  }
 }
 
 if (cust_hotbutton_chapters.length > 0) {
 
  var table = document.createElement('TABLE');
  var tableBody = document.createElement('TBODY');

  table.border = '1';
  table.width = '100%';
  table.appendChild(tableBody);

  //TABLE HEADER
  var tr = document.createElement('TR');
  tr.className = 'header';
  tableBody.appendChild(tr);

  var th = document.createElement('TH')
  th.className = 'col-md-6';
  th.appendChild(document.createTextNode("CHAPTER"));
  tr.appendChild(th);

  var th = document.createElement('TH')
  th.className = 'col-md-6';
  th.appendChild(document.createTextNode("CUSTOMER CHALLENGE"));
  tr.appendChild(th);

  for (row_index=0; row_index < cust_hotbutton_chapters.length; row_index++) {
	var tr = document.createElement('TR');
	var td = document.createElement('TD');
	td.appendChild(document.createTextNode("Ch. " + (cust_hotbutton_chapters[row_index]+1) + ": " + 
	 CHAPTER_TITLES[cust_hotbutton_chapters[row_index]]));
	tr.appendChild(td);
	var td = document.createElement('TD');
	td.appendChild(document.createTextNode(CUSTOMER_CHALLENGES[cust_hotbutton_chapters[row_index]]));
	tr.appendChild(td);
	tableBody.appendChild(tr);
  }

  myTableDiv.appendChild(table);

  $j('#customer-hotbuttons').show();	

 }
 
}

// -------------------------------------
// FUNCTION: createResultDetailTable 
// -------------------------------------
function createResultDetailTable() {

 var myTableDiv = document.getElementById("detail-table-container");
 $j('#detail-table-container').empty();
 var table = document.createElement('TABLE');
 var tableBody = document.createElement('TBODY');

 table.border = '1'
 table.appendChild(tableBody);

 //TABLE HEADER
 var tr = document.createElement('TR');
 tr.className = 'header';
 tableBody.appendChild(tr);

 var th = document.createElement('TH')
 th.className = 'col-md-1';
 th.appendChild(document.createTextNode("CHAPTER"));
 tr.appendChild(th);

 var th = document.createElement('TH')
 th.className = 'col-md-4';
 th.appendChild(document.createTextNode("BUSINESS CHALLENGE"));
 tr.appendChild(th);
 
 var th = document.createElement('TH')
 th.className = 'col-md-1';
 th.appendChild(document.createTextNode("YOUR SCORE"));
 tr.appendChild(th);

 var th = document.createElement('TH')
 th.className = 'col-md-4';
 th.appendChild(document.createTextNode("CUSTOMER CHALLENGE"));
 tr.appendChild(th);
 
 var th = document.createElement('TH')
 th.className = 'col-md-1';
 th.appendChild(document.createTextNode("YOUR SCORE"));
 tr.appendChild(th);

 var th = document.createElement('TH')
 th.className = 'col-md-1';
 th.appendChild(document.createTextNode("TOTAL"));
 tr.appendChild(th);

 // TABLE ROWS
 for (chapter_index = 0; chapter_index < NUM_CHAPTERS; chapter_index++) {
 
  var tr = document.createElement('TR');
  
  // CHAPTER
  var td = document.createElement('TD');
  td.appendChild(document.createTextNode("Ch. " + (chapter_index+1) + ": " + CHAPTER_TITLES[chapter_index]));  
  tr.appendChild(td);
  
  // BIZ CHALLENGE
  var td = document.createElement('TD');
  td.appendChild(document.createTextNode(BIZ_CHALLENGES[chapter_index])); 
  tr.appendChild(td);
  
  // BIZ CHALLENGE SCORE
  var td = document.createElement('TD');
  td.align = 'middle';
  td.appendChild(document.createTextNode(chapter_scores[chapter_index][BIZ_CHALLENGE]));  
  tr.appendChild(td);

  // CUSTOMER CHALLENGE
  var td = document.createElement('TD');
  td.appendChild(document.createTextNode(CUSTOMER_CHALLENGES[chapter_index])); 
  tr.appendChild(td);
  
  // CUSTOMER CHALLENGE SCORE
  var td = document.createElement('TD');
  td.align = 'middle';
  td.appendChild(document.createTextNode(chapter_scores[chapter_index][CUSTOMER_CHALLENGE]));  
  tr.appendChild(td);
    
  // TOTAL SCORE
  var td = document.createElement('TD');
  td.align = 'middle';
  td.appendChild(document.createTextNode(chapter_scores[chapter_index][BIZ_CHALLENGE] + chapter_scores[chapter_index][CUSTOMER_CHALLENGE]));    
  tr.appendChild(td);

  tableBody.appendChild(tr);
 }

 myTableDiv.appendChild(table);

}
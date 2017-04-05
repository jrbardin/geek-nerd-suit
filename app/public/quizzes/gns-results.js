var $j = jQuery.noConflict();
$j.ajaxSetup({ cache: false });

var geekScore = 0;
var nerdScore = 0;
var suitScore = 0;

$j( document ).ready(function() {
    geekScore = getParam( "g" );
    nerdScore = getParam( "n" );
	suitScore = getParam( "s" );
	
/* NEW */
// 	 google.charts.load('current', {'packages':['gauge']});
//      google.charts.setOnLoadCallback(drawChart);
// 
//       function drawChart() {
// 
//         var data = google.visualization.arrayToDataTable([
//           ['Label', 'Value'],
//           ['GEEK', geekScore],
//           ['NERD', nerdScore],
//           ['SUIT', suitScore]
//         ]);
// 
//         var options = {
//           width: 400, height: 120,
//           redFrom: 25, redTo: 50,
//           yellowFrom: 50, yellowTo: 75,
//           greenFrom: 75, greenTo: 100,
//           minorTicks: 5
//         };
// 
//         var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
// 
//         chart.draw(data, options);
// 
//        
//       }
/* END NEW */
	
	$j("#geek-score").text(Math.round(geekScore));
	$j("#nerd-score").text(Math.round(nerdScore));
	$j("#suit-score").text(Math.round(suitScore));
	
	var geekChart = new Chartist.Pie('#geek-chart', {
	  series: [geekScore, (100-geekScore)],
	  labels: ["G", ""]
	}, {
	  donut: true,
	  donutWidth: 20,
	  startAngle: 0,
	  showLabel: false
	});
	var nerdChart = new Chartist.Pie('#nerd-chart', {
	  series: [nerdScore, (100-nerdScore)],
	  labels: ["N", ""]
	}, {
	  donut: true,
	  donutWidth: 20,
	  startAngle: 0,  
	  showLabel: false
	});
	var suitChart = new Chartist.Pie('#suit-chart', {
	  series: [suitScore, (100-suitScore)],
	  labels: ["S", ""]
	}, {
	  donut: true,
	  donutWidth: 20,
	  startAngle: 0,  
	  showLabel: false
	});
	
});

// return a parameter value from the current URL
function getParam ( sname )
{
  var params = location.search.substr(location.search.indexOf("?")+1);
  var sval = "";
  params = params.split("&");
    // split param and value into individual pieces
    for (var i=0; i<params.length; i++)
       {
         temp = params[i].split("=");
         if ( [temp[0]] == sname ) { sval = temp[1]; }
       }
  return sval;
}

geekChart.on('draw', function(data) {
  if(data.type === 'slice') {
    // Get the total path length in order to use for dash array animation
    var pathLength = data.element._node.getTotalLength();

    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
    data.element.attr({
      'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
    });

    // Create animation definition while also assigning an ID to the animation for later sync usage
    var animationDefinition = {
      'stroke-dashoffset': {
        id: 'anim' + data.index,
        dur: 1000,
        from: -pathLength + 'px',
        to:  '0px',
        easing: Chartist.Svg.Easing.easeOutQuint,
        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
        fill: 'freeze'
      }
    };

    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
    if(data.index !== 0) {
      animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
    }

    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
    data.element.attr({
      'stroke-dashoffset': -pathLength + 'px'
    });

    // We can't use guided mode as the animations need to rely on setting begin manually
    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
    data.element.animate(animationDefinition, false);
  }
});
nerdChart.on('draw', function(data) {
  if(data.type === 'slice') {
    // Get the total path length in order to use for dash array animation
    var pathLength = data.element._node.getTotalLength();

    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
    data.element.attr({
      'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
    });

    // Create animation definition while also assigning an ID to the animation for later sync usage
    var animationDefinition = {
      'stroke-dashoffset': {
        id: 'anim' + data.index,
        dur: 1000,
        from: -pathLength + 'px',
        to:  '0px',
        easing: Chartist.Svg.Easing.easeOutQuint,
        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
        fill: 'freeze'
      }
    };

    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
    if(data.index !== 0) {
      animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
    }

    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
    data.element.attr({
      'stroke-dashoffset': -pathLength + 'px'
    });

    // We can't use guided mode as the animations need to rely on setting begin manually
    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
    data.element.animate(animationDefinition, false);
  }
});
suitChart.on('draw', function(data) {
  if(data.type === 'slice') {
    // Get the total path length in order to use for dash array animation
    var pathLength = data.element._node.getTotalLength();

    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
    data.element.attr({
      'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
    });

    // Create animation definition while also assigning an ID to the animation for later sync usage
    var animationDefinition = {
      'stroke-dashoffset': {
        id: 'anim' + data.index,
        dur: 1000,
        from: -pathLength + 'px',
        to:  '0px',
        easing: Chartist.Svg.Easing.easeOutQuint,
        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
        fill: 'freeze'
      }
    };

    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
    if(data.index !== 0) {
      animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
    }

    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
    data.element.attr({
      'stroke-dashoffset': -pathLength + 'px'
    });

    // We can't use guided mode as the animations need to rely on setting begin manually
    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
    data.element.animate(animationDefinition, false);
  }
});
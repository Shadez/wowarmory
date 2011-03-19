// JavaScript Document
$(function () {
    var d = [[1201647600000, 1521], [1201734000000, 1477], [1201820400000, 1442], [1201906800000, 1252], [1201993200000, 1236], [1202079600000, 1525], [1202166000000, 1477], [1202252400000, 1386], [1202338800000, 1409], [1202425200000, 1408], [1202511600000, 1237], [1202598000000, 1193], [1202684400000, 1357], [1202770800000, 1414], [1202857200000, 1393], [1202943600000, 1353], [1203030000000, 1364], [1203116400000, 1215], [1203202800000, 1214], [1203289200000, 1456], [1203375600000, 1399], [1203462000000, 1434], [1203548400000, 1348], [1203634800000, 1243], [1203721200000, 1126], [1203807600000, 1500]];

    // first correct the timestamps - they are recorded as the daily
    // midnights in UTC+0100, but Flot always displays dates in UTC
    // so we have to add one hour to hit the midnights in the plot
    for (var i = 0; i < d.length; ++i)
      d[i][0] += 60 * 60 * 1000;

    // helper for returning the weekends in a period
    function weekendAreas(axes) {
        var markings = [];
        var d = new Date(axes.xaxis.min);
        // go to the first Saturday
        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
        d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var i = d.getTime();
        do {
            // when we don't set yaxis the rectangle automatically
            // extends to infinity upwards and downwards
            markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
            i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
    }
    
    var options = {
        xaxis: { mode: "time" },
		selection: { mode: "xy" },
		lines: { show: true, fill: 0.5 },
		points: { show: true },
		yaxis: { min: 800, max: 2000 },
        grid: { markings: weekendAreas, hoverable: true, clickable: true, labelMargin: 10 },
		colors: ["#639ecb"], //639ecb //e03c42 
		shadowSize: 2
    };
  	function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y - 35,
            left: x + 0,
			color: '#333',
            border: '1px solid #999',
            padding: '2px',
            'background-color': '#EFEFEF',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
	
    var plot = $.plot($("#placeholder"), [d], options);
    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                               y + "visitors");
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });
});
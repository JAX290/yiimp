<?php

$algo = user()->getState('yaamp-algo');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile('/yaamp/ui/js/auto_refresh.js');

$height = '240px';

echo <<<end

<div id='resume_update_button' style='color: #444; background-color: #ffd; border: 1px solid #eea;
	padding: 10px; margin-left: 20px; margin-right: 20px; margin-top: 15px; cursor: pointer; display: none;'
	onclick='auto_page_resume();' align=center>
<b>Auto refresh is paused - Click to resume</b></div>

<table cellspacing=20 width=100%>
<tr><td valign=top width=50%>

<div id='mining_results'>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
</div>
end;

if($algo != 'all')
echo <<<end
<div class="main-left-box">
<div class="main-left-title">Last 24 Hours Hashrate ($algo)</div>
<div class="main-left-inner"><br>
<div id='pool_hashrate_results' style='height: $height;'></div><br>
</div></div><br>

<div class="main-left-box">
<div class="main-left-title">Last 7 Days Hashrate ($algo)</div>
<div class="main-left-inner"><br>
<div id='pool_hashrate_7d_results' style='height: $height;'></div><br>
</div></div><br>
end;

echo <<<end
</td><td valign=top>

<div id='pool_current_results'>
<br><br><br><br><br><br><br><br><br><br>
</div>

<div id='found_results'>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
</div>

</td></tr></table>

<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>

<script>

var global_algo = '$algo';

function select_algo(algo)
{
	window.location.href = '/site/gomining?algo='+algo;
}

function page_refresh()
{
	pool_current_refresh();
	mining_refresh();
	found_refresh();

	if(global_algo != 'all')
	{
		pool_hashrate_refresh();
		pool_hashrate_7d_refresh();
	}
}

////////////////////////////////////////////////////

function pool_current_ready(data)
{
	$('#pool_current_results').html(data);
}

function pool_current_refresh()
{
	var url = "/site/current_results";
	$.get(url, '', pool_current_ready);
}

////////////////////////////////////////////////////

function mining_ready(data)
{
	$('#mining_results').html(data);
}

function mining_refresh()
{
	var url = "/site/mining_results";
	$.get(url, '', mining_ready);
}

////////////////////////////////////////////////////

function found_ready(data)
{
	$('#found_results').html(data);
}

function found_refresh()
{
	var url = "/site/found_results";
	$.get(url, '', found_ready);
}

///////////////////////////////////////////////////////////////////////

function pool_hashrate_ready(data)
{
	pool_hashrate_graph_init(data);
}

function pool_hashrate_refresh()
{
	var url = "/site/graph_hashrate_results";
	$.get(url, '', pool_hashrate_ready);
}

function pool_hashrate_graph_init(data)
{
	$('#pool_hashrate_results').empty();

	var t = $.parseJSON(data);
	var plot1 = $.jqplot('pool_hashrate_results', t,
	{
		title: '<b>Pool Hashrate (Mh/s)</b>',
		axes: {
			xaxis: {
				tickInterval: 3600,
				renderer: $.jqplot.DateAxisRenderer,
				tickOptions: {formatString: '<font size=1>%#Hh</font>'}
			},
			yaxis: {
				min: 0,
				tickOptions: { formatString: '<font size=1>%d</font>' }
			}
		},

		seriesDefaults:
		{
			markerOptions: { style: 'none' }
		},

		grid:
		{
			borderWidth: 1,
			shadowWidth: 0,
			shadowDepth: 0,
			background: '#41464b'
		},

		highlighter:
		{
			show: true
		},

	});
}

///////////////////////////////////////////////////////////////////////

function pool_hashrate_7d_ready(data)
{
	pool_hashrate_7d_graph_init(data);
}

function pool_hashrate_7d_refresh()
{
	var url = "/site/graph_hashrate_7d_results";
	$.get(url, '', pool_hashrate_7d_ready);
}

function pool_hashrate_7d_graph_init(data)
{
	$('#pool_hashrate_7d_results').empty();

	var t = $.parseJSON(data);
	var plot1 = $.jqplot('pool_hashrate_7d_results', t,
	{
		title: '<b>Pool Hashrate (Mh/s)</b>',
		axes: {
			xaxis: {
				tickInterval: 8*3600,
				renderer: $.jqplot.DateAxisRenderer,
				tickOptions: {formatString: '<font size=1>%#Hh</font>'}
			},
			yaxis: {
				min: 0,
				tickOptions: { formatString: '<font size=1>%d</font>' }
			}
		},

		seriesDefaults:
		{
			markerOptions: { style: 'none' }
		},

		grid:
		{
			borderWidth: 1,
			shadowWidth: 0,
			shadowDepth: 0,
			background: '#41464b'
		},

		highlighter:
		{
			show: true
		},

	});
}

</script>

end;




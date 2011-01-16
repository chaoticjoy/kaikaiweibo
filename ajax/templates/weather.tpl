<div id="weather-box">
	<img src="{$weather['current_conditions']['icon']['@attributes']['data']}" class="weather-icon"/>
	<div class="weather-content">
	<h2>{$weather['forecast_information']['postal_code']['@attributes']['data']}天气</h2>
	<p>实时： {$weather['current_conditions']['temp_c']['@attributes']['data']}℃ {$weather['current_conditions']['condition']['@attributes']['data']}  {$weather['current_conditions']['humidity']['@attributes']['data']}</p>
	<p>明天： {$weather['forecast_conditions']['1']['low']['@attributes']['data']}～{$weather['forecast_conditions']['1']['high']['@attributes']['data']}℃ {$weather['forecast_conditions']['1']['condition']['@attributes']['data']}</p>
	</div>
</div>
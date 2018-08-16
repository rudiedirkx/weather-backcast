<?php

use rdx\weather\Prediction;

require __DIR__ . '/inc.bootstrap.php';

$json = file_get_contents('https://api.buienradar.nl/data/forecast/1.1/all/' . WEATHER_LOCATION_ID);
$forecast = json_decode($json, true);

$now = time();
$batch = strtotime($forecast['timestamp']);

$db->begin();

foreach ( $forecast['days'] as $day ) {
	foreach ( $day['hours'] ?? [] as $hour ) {
		$predicted = strtotime($hour['datetime']);

		Prediction::insert([
			'taken_on' => $now,
			'predicted_for' => $predicted,
			'batch_on' => $batch,
			'temperature' => $hour['temperature'],
			'precipitation' => $hour['precipitation'],
			'sunshine' => $hour['sunshine'],
		]);
	}
}

$db->commit();

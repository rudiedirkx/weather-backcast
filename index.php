<?php

use rdx\weather\Prediction;

require __DIR__ . '/inc.bootstrap.php';

$selectors = [
	'count(1) total',
	'count(distinct taken_on) measurements',
	'min(taken_on) first_meas',
	'max(taken_on) last_meas',
	'count(distinct predicted_for) hours',
	'min(predicted_for) first_hour',
	'max(predicted_for) last_hour',
	'count(distinct batch_on) batches',
];
$stats = $db->fetch('select ' . implode(', ', $selectors) . ' from predictions')->first();

include 'tpl.header.php';

$int = function($int) {
	return number_format($int, 0, '.', ' ');
};

?>
<table border="1" cellspacing="0" cellpadding="6">
	<tr>
		<th>Predictions</th>
		<td><?= $int($stats->total) ?></td>
		<td></td>
	</tr>
	<tr>
		<th>Measurements</th>
		<td><?= $int($stats->measurements) ?></td>
		<td>
			<?= date('Y-m-d H:i', $stats->first_meas) ?> -
			<?= date('Y-m-d H:i', $stats->last_meas) ?>
		</td>
	</tr>
	<tr>
		<th>Hours</th>
		<td><?= $int($stats->hours) ?></td>
		<td>
			<?= date('Y-m-d H:i', $stats->first_hour) ?> -
			<?= date('Y-m-d H:i', $stats->last_hour) ?>
		</td>
	</tr>
	<tr>
		<th>Their batches</th>
		<td><?= $int($stats->batches) ?></td>
		<td></td>
	</tr>
</table>

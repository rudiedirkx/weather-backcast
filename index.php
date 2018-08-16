<?php

use rdx\weather\Prediction;

require __DIR__ . '/inc.bootstrap.php';

$measurements = $db->fetch("
	select
		strftime('%Y-%m-%d %H:00', datetime(predicted_for, 'unixepoch')) hour,
		count(1) measurements,
		max(temperature) max,
		min(temperature) min,
		(max(temperature) - min(temperature)) diff,
		((max(taken_on) - min(taken_on)) / 3600) timespan
	from predictions
	group by hour
	order by hour
");

header('Content-type: text/html; charset=utf-8');

?>
<table border="1" cellspacing="0" cellpadding="6">
	<thead>
		<tr>
			<th>Datetime</th>
			<th>Max</th>
			<th>Min</th>
			<th>Diff</th>
			<th align="right"># measured</th>
			<th>In # hours</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($measurements as $measurement): ?>
			<tr>
				<td><?= $measurement->hour ?></td>
				<td><?= number_format($measurement->max, 1) ?></td>
				<td><?= number_format($measurement->min, 1) ?></td>
				<td><?= number_format($measurement->diff, 1) ?></td>
				<td align="right"><?= $measurement->measurements ?></td>
				<td><?= round($measurement->timespan) ?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

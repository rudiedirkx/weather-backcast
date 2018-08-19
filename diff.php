<?php

use rdx\weather\Prediction;

require __DIR__ . '/inc.bootstrap.php';

$measurements = $db->fetch("
	select
		hours_ahead,
		round(avg(tempdiff), 1) tempdiff,
		round(avg(sundiff), 1) sundiff,
		round(avg(raindiff), 1) raindiff,
		sum(measurements) measurements
	from (
		select
			a.predicted_for,
			a.taken_on,
			round((a.predicted_for - a.taken_on) / 3600) hours_ahead,
			count(1) measurements,
			round(max(b.temperature) - min(b.temperature), 1) tempdiff,
			round(max(b.sunshine) - min(b.sunshine), 1) sundiff,
			round(max(b.precipitation) - min(b.precipitation), 1) raindiff
		from predictions a
		join predictions b on b.predicted_for = a.predicted_for and b.taken_on > a.taken_on and b.taken_on < a.taken_on + 86400/2
		group by a.predicted_for, a.taken_on, hours_ahead
		having measurements > 1
	) x
	group by hours_ahead
	order by hours_ahead desc
");

include 'tpl.header.php';

?>
<table border="1" cellspacing="0" cellpadding="6">
	<thead>
		<tr>
			<th>Hours ahead</th>
			<th>Avg temp diff</th>
			<th>Avg sun diff</th>
			<th>Avg rain diff</th>
			<th align="right"># measured</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($measurements as $measurement): ?>
			<tr>
				<td><?= number_format($measurement->hours_ahead, 0) ?></td>
				<td><?= number_format($measurement->tempdiff, 1) ?></td>
				<td><?= number_format($measurement->sundiff, 1) ?></td>
				<td><?= number_format($measurement->raindiff, 1) ?></td>
				<td align="right"><?= number_format($measurement->measurements, 0) ?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

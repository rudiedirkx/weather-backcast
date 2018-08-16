<?php

return [
	'version' => 1,
	'tables' => [
		'predictions' => [
			'id' => ['pk' => true],
			'taken_on' => ['type' => 'integer'],
			'predicted_for' => ['type' => 'integer'],
			'batch_on' => ['type' => 'integer'],
			'temperature' => ['type' => 'real'],
			'precipitation' => ['type' => 'real'],
			'sunshine' => ['type' => 'real'],
		],
	],
];

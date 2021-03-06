<?php

namespace Refurbed\ResultField;

use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;

class Refurbed extends ResultFields
{
	private $arrayHelper;

	public function __construct(ArrayHelper $arrayHelper)
	{
		$this->arrayHelper = $arrayHelper;
	}

	public function generateResultFields(array $formatSettings = []):array
	{
		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');
		$lang = $settings->get('lang') ?: 'de';
	
		$fields = [
			'itemBase' => ['id'],
			'itemDescription' => [
				'params' => [
					'language' => $lang
				],
				'fields' => ['urlContent']
			],
			'variationBase' => ['id', 'content'],
			'variationRetailPrice' => [
				'fields' => [
					'currency',
					'price',
					'vatValue'
				],
			],
			'variationStock' => [
				'params' => [
					'type' => 'virtual',
				],
				'fields' => ['stockNet']
			]
		];
		return $fields;
	}
}

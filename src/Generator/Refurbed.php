<?php

namespace Refurbed\Generator;

use ElasticExport\Helper\ElasticExportHelper;
use Plenty\Modules\DataExchange\Contracts\CSVGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Plugin\Log\Loggable;

class Refurbed extends CSVGenerator
{
	use Loggable;

	private $elasticExportHelper;
	
	private $arrayHelper;

	private $defaultShippingList = [];


	public function __construct(ElasticExportHelper $elasticExportHelper,
		ArrayHelper $arrayHelper)
	{
		$this->elasticExportHelper = $elasticExportHelper;
		$this->arrayHelper = $arrayHelper;
	}

	protected function generateContent($resultData, array $formatSettings = [])
	{
		if(!($resultData instanceof RecordList)) {
			$this->getLogger(__METHOD__)->error(
				'Refurbed::instanceOf',
				['error' => 'not an instance of RecordList']);
			return;
		}
		
		$this->setDelimiter(',');

		// Refurbed SKU not important now - don't add it to the output.
		$this->addCSVContent([
			//'sku',
			'internal_sku',
			'stock_net',
			'currency',
			'price_gross',
			'vat'
		]);
		
		foreach($resultData as $record) {
			// Each variation gets a globally unique id we call
			// internal SKU.
			$intlSku = $record->itemBase->id.'-'.$record->variationBase->id;
			$stockNet = $record->variationStock->stockNet;
			$currency = $record->variationRetailPrice->currency;
			$priceGross = $record->variationRetailPrice->price;
			$vat = $record->variationRetailPrice->vatValue;
			//$url = $record->itemDescription->urlContent;
	
			$data = [
				//'sku' => $intlId,
				'internal_sku' => $intlSku,
				'stock_net' => $stockNet ?: 0,
				'currency' => $currency,
				'price_gross' => $priceGross,
				'vat' => $vat
			];
			$this->addCSVContent(array_values($data));
		}
	}
}

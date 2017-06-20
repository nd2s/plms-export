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
		
		$this->setDelimiter(';');
		$this->addCSVContent([
			'refurbed_sku',
			'stock_net',
			'currency',
			'price_gross',
			'vat'
		]);
		
		foreach($resultData as $record) {
			$intlId = $record->itemBase->id.'-'.$record.variationBase->unitId;
			$stockNet = $record->variationStock->stockNet;
			$currency = $record->variationRetailPrice->currency;
			$priceGross = $record->variationRetailPrice->price;
			$vat = $record->variationRetailPrice->vatValue;
			
			$data = [
				'refurbed_id' => $intlId,
				'internal_id' => $intlId,
				'stock_net' => $stockNet ?: 0,
				'currency' => $currency,
				'price_gross' => $priceGross,
				'vat' => $vat,
			];
			$this->addCSVContent(array_values($data));
		}
	}
}

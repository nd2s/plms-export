<?php
namespace Refurbed\Generator;

use ElasticExport\Helper\ElasticExportHelper;
use Plenty\Modules\DataExchange\Contracts\CSVGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\DataExchange\Models\FormatSetting;

class Refurbed extends CSVGenerator
{
	use Loggable;

	const DELIMITER = ";";

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
		
		$this->setDelimiter(self::DELIMITER);
		$this->addCSVContent(array('sku', 'name', 'price', 'stock'));
		
		
		foreach($resultData as $item) {
			$data = [
				'sku' => $item->itemBase->id,
				'name' => 'bla',
				'price' => 100.00,
				'stock' => $item->variationStock->stockNet,
			];
			$this->addCSVContent(array_values($data));
		}
	}
}

<?php
namespace Refurbed\Generator;

//use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;
//use ElasticExport\Helper\ElasticExportStockHelper;
//use Refurbed\Helper\PriceHelper;
//use Refurbed\Helper\PropertyHelper;
//use Refurbed\Helper\StockHelper;

class Refurbed extends CSVPluginGenerator
{
	use Loggable;

	const DELIMITER = ";";

	const HEAD = ['sku', 'name', 'price', 'stock'];

	//private $elasticExportCoreHelper;

	private $arrayHelper;

	//private $priceHelper;

	//private $propertyHelper;

	//private $stockHelper;

	private $defaultShippingList = [];

	//private $elasticExportStockHelper;


	/**
	 * Refurbed constructor.
	 *
	 * @param ArrayHelper $arrayHelper
	 * @param PriceHelper $priceHelper
	 * @param PropertyHelper $propertyHelper
	 * @param StockHelper $stockHelper
	 */
	public function __construct(ArrayHelper $arrayHelper)
	{
		//	PriceHelper $priceHelper, PropertyHelper $propertyHelper,
		//	StockHelper $stockHelper)
		$this->arrayHelper = $arrayHelper;
		//$this->priceHelper = $priceHelper;u
		//$this->propertyHelper = $propertyHelper;
		//$this->stockHelper = $stockHelper;
	}

	/**
	 * Generates and populates the data into the CSV file.
	 *
	 * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
	 * @param array $formatSettings
	 * @param array $filter
	 */
	protected function generatePluginContent($elasticSearch,
		array $formatSettings = [], array $filter = [])
	{
		//$this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);
		//$this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);

		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		$this->setDelimiter(self::DELIMITER);
		$this->addCSVContent(self::HEAD);
		$this->addCSVContent(['fuck', 'fuck', 234, 4]);

		$this->getLogger(__METHOD__)->error(
			'Refurbed::fucks',
			['Message' => "doing stuff"]);
		$fucks = [
			["sku"=>"fuck", "name"=>"fuck", "price"=>234, "stock"=>4],
			["sku"=>"wed", "name"=>"werg", "price"=>12, "stock"=>1],
			["sku"=>"ewrg", "name"=>"sadc", "price"=>93, "stock"=>17],
		]
		
		foreach($fucks as $fuck) {
			$this->buildRow($settings, $fuck);
		}
	
		if(!($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)) {
			throw new Exception("not an instance");
			return;
		}

		do {
			// Get the data from Elastic Search
			$resultList = $elasticSearch->execute();
			
			if(count($resultList['error']) > 0) {
				$this->getLogger(__METHOD__)->error(
					'Refurbed::item.occurredElasticSearchErrors',
					['Error message' => $resultList['error']]);
				break;
			}

			if(!is_array($resultList['documents'])
				|| count($resultList['documents']) == 0) {
				
				break;
			}
		
			foreach($resultList['documents'] as $result) {
				$this->buildRow($settings, $result);
			}
			//$this->constructData($settings, $result);
			// Pass the items to the CSV printer
		} while ($elasticSearch->hasNext());
	}


	/**
	 * Creates the item row and prints it into the CSV file.
	 *
	 * @param KeyValue $settings
	 * @param array $variation
	 */
	private function buildRow(KeyValue $settings, $variation) {
		$this->getLogger(__METHOD__)->debug(
			'Refurbed::item.itemExportConstructGroup',
			['Data row duration' => 'Row printing start']);
		
		$data = [
			'sku' => $variation['sku'],
			'name' => $variation['name'],
			'price' => $variation['price'],
			'stock' => $variation['stock'],
		];
		$this->addCSVContent(array_values($data));
	}
}

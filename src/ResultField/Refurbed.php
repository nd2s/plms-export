<?php
namespace Refurbed\ResultField;

use Cache\Util\Key;
use Plenty\Modules\Cloud\ElasticSearch\Lib\ElasticSearch;
use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\kModels\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;

class Refurbed extends ResultFields
{
	//private $arrayHelper;

	public function __construct(ArrayHelper $arrayHelper)
	{
		//$this->arrayHelper = $arrayHelper;
	}

	public function generateResultFields(array $formatSettings = []):array
	{
		//$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		//$reference = $settings->get('referrerId') ? $settings->get('referrerId') : self::IDEALO_DE;
		$this->setOrderByList(['item.id', ElasticSearch::SORTING_ORDER_ASC]);

		$fields = [
			'itemBase' => ['id'],
			'variationBase' => ['unitId', 'content'],
			'variationStock' => [
				'params' => [
					'type' => 'virtual',
				],
				'fields' => ['stockNet']
			]
		];
		/*[
			[
				'item.id',
				//'skus.sku',
				
				// Variation.
				'id',
			],
			[],
		];*/
		return $fields;
	}
}

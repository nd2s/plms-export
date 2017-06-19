<?php
namespace Refurbed\ResultField;

use Cache\Util\Key;
use Plenty\Modules\Cloud\ElasticSearch\Lib\ElasticSearch;
use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;

class Refurbed extends ResultFields
{
	private $arrayHelper;

	public function __construct(ArrayHelper $arrayHelper)
	{
		$this->arrayHelper = $arrayHelper;
	}

	public function generateResultFields(array $formatSettings = []):array
	{
		$seuttings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		//$reference = $settings->get('referrerId') ? $settings->get('referrerId') : self::IDEALO_DE;

		$this->setOrderByList(['item.id', ElasticSearch::SORTING_ORDER_ASC]);

		$fields = [
			[
				//item
				'item.id',
				'item.manufacturer.id',
				'item.amazonFedas',

				//variation
				'id',
				'variation.availability.id',
				'variation.stockLimitation',
				'variation.vatId',
				'variation.model',
				'variation.isMain',
				'variation.weightG',
				'variation.number',

				//sku
				'skus.sku',

				//defaultCategories
				'defaultCategories.id',

				//attributes
				'attributes.attributeValueSetId',
				'attributes.attributeId',
				'attributes.valueId',

				'properties.property.id',
				'properties.property.valueType',
				'properties.selection.name',
				'properties.texts.value',
				'properties.valueInt',
				'properties.valueFloat',
			],
			[],
		];
		return $fields;
	}

	private function getKeyList()
	{
		$keyList = [
			'item.id',
			'item.manufacturer.id',
			'item.amazonFedas',

			'variation.availability.id',
			'variation.stockLimitation',
			'variation.vatId',
			'variation.model',
			'variation.isMain',
			'variation.weightG',
			'variation.number',

			'unit.content',
			'unit.id',
		];
		return $keyList;
	}

	private function getNestedKeyList()
	{
		$nestedKeyList['keys'] = [
			//sku
			'skus',

			//attributes
			'attributes',

			//properties
			'properties'
		];

		$nestedKeyList['nestedKeys'] = [
			//sku
			'skus' => [
				'sku'
			],

			//attributes
			'attributes' => [
				'attributeValueSetId',
				'attributeId',
				'valueId',
			],

			//proprieties
			'properties' => [
				'property.id',
				'property.valueType',
				'selection.name',
				'texts.value',
				'valueInt',
				'valueFloat',
			]
		];
		return $nestedKeyList;
	}
}

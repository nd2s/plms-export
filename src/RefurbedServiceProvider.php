<?php

namespace Refurbed;

//use Refurbed\Helper\PriceHelper;
//use Refurbed\Helper\PropertyHelper;
//use Refurbed\Helper\StockHelper;
use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;

class RefurbedServiceProvider extends DataExchangeServiceProvider
{
	public function register()
	{
	}

	public function exports(ExportPresetContainer $container)
	{
		$container->add(
			'Refurbed-Plugin',
			'Refurbed\ResultField\Refurbed',
			'Refurbed\Generator\Refurbed',
			'', // filterClass
			true, // isPlugin
			true // generatorExecute
		);
	}
}

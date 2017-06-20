<?php

namespace Refurbed;

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
			'Refurbed',
			'Refurbed\ResultField\Refurbed',
			'Refurbed\Generator\Refurbed',
			'' // filterClass
		);
	}
}

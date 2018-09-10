<?php

class umlExpandAllPluginConfiguration extends sfPluginConfiguration {
	public static
		$summary = 'UMl Expand All Plugin',
		$version = '1.0.0';

	public function contextLoadFactories(sfEvent $event)
	{
		$context = $event->getSubject();
		$context->response->addJavaScript('umlExpandAll.js', 'last');

	}

	public function initialize() {
		$this->dispatcher->connect( 'context.load_factories', array( $this, 'contextLoadFactories' ) );

		$enabledModules   = sfConfig::get( 'sf_enabled_modules' );
		$enabledModules[] = 'uml_expand_all';
		sfConfig::set( 'sf_enabled_modules', $enabledModules );
	}
}

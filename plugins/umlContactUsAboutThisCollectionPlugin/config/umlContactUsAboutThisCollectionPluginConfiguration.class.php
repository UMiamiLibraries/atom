<?php


class umlContactUsAboutThisCollectionPluginConfiguration extends sfPluginConfiguration {
	public static
		$summary = 'UML Contact us about this collection',
		$version = '1.0.0';
	const REGEX_ID   = '\d+';

	public function initialize() {
		$enabledModules   = sfConfig::get( 'sf_enabled_modules' );
		$enabledModules[] = 'umlContactUsAboutThisCollectionPlugin';
		sfConfig::set( 'sf_enabled_modules', $enabledModules );

		// Connect event listener to add routes
		$this->dispatcher->connect( 'routing.load_configuration', array( $this, 'routingLoadConfiguration' ) );
	}

	public function routingLoadConfiguration( sfEvent $event ) {
		$this->routing = $event->getSubject();

		$this->addRoute( 'GET', '/contactus/email/:id', array(
			'module' => 'contactus',
			'action' => 'email',
			'params' => array('id' => self::REGEX_ID)
		) );
	}

	function addRoute( $method, $pattern, array $options = array() ) {
		$defaults = $requirements = array();

		// Allow routes to only apply to specific HTTP methods
		if ( $method != '*' ) {
			$requirements['sf_method'] = explode( ',', $method );
		}

		if ( isset( $options['module'] ) ) {
			$defaults['module'] = $options['module'];
		}

		if ( isset( $options['action'] ) ) {
			$defaults['action'] = $options['action'];
			$name               = 'api_' . $options['action'];
		} else {
			$name = 'api_' . str_replace( '/', '_', $pattern );
		}

		if ( isset( $options['params'] ) ) {
			$params = $options['params'];
			foreach ( $params as $field => $regex ) {
				$requirements[ $field ] = $regex;
			}
		}

		// Add route before slug;default_index
		$this->routing->insertRouteBefore( 'slug;default_index', $name,
			new sfRequestRoute( $pattern, $defaults, $requirements ) );
	}

}

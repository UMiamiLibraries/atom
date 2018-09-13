<?php

class ContactusEmailAction extends sfAction
{
	public function execute($request)
	{
		var_dump($request->id);
		die();

		$config = sfContext::getInstance()->getConfiguration();

		return array('version' => $config::VERSION);
	}

}

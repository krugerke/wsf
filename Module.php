<?php
namespace Wsf;

use Zend\Mvc\MvcEvent;

class Module {

	public function onBootstrap(EventInterface $event) {

	}

	public function getConfig() {
		return include ./config/module.config.php';
	}

}
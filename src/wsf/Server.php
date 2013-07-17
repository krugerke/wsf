<?php
namespace Wso2;

use Zend\Server\Reflection;
use \WSService;
use Wso2\Exception\InvalidArgumentException;

class Server extends WSService {

	protected $_classNames  = array();
	
	protected $_methodNames = array();
	
	protected $_opParams = 'MIXED';
	
	protected $_reflection = null;
	
	protected $_config = array();
	
	public function __construct($classes = null) {	
		switch ($classes) {
			case null:
				throw new InvalidArgumentException("Invalid class or object passed to ".__CLASS__."().");
			break;
			
			case (is_object($classes) || is_string($classes)):
				$this->_reflection = Reflection::reflectClass($classes);
			break;
			
			/** NOT YET IMPLEMENTED
			case is_array($classes):
				foreach($classes as $class) {
					if(!is_object($classes) && !is_string($classes)) {
						throw new InvalidArgumentException("Invalid class or object passed to '".__CLASS__."()'. Must be either class name, object or single dimension array containing a combination of either.");
						break;
					}
					$this->_reflection = $this->_reflection = Reflection::reflectClass($classes);
				}
			break;
			**/
			
			default:
				throw new InvalidArgumentException("Invalid class or object passed to '".__CLASS__."()'.");
			break;
		}
		
		$this->_classNames[] = $this->_reflection->getName();
		
		foreach($this->_classNames  as $className) {
			foreach($this->_reflection->getMethods() as $method) {
				$methodNames[] = $method->getName();
			}
			
			$classesAndMethods[$className] = array('operations' => $methodNames);
		}
		
		$this->_config = array('classes' => $classesAndMethods, "opParams" => $this->_opParams);	
	}
	
	public function reply() {
		parent::__construct($this->_config);

		if(isset($_GET['wsdl'])) {
			header('Content-type: text/xml');
		}

		parent::reply();
	}
	
	public function getClassNames() {
		return $this->_classNames;
	}

	public function setClassNames($classNames) {
		$this->_classNames = $classNames;
		return $this;
	}

	public function getMethodNames() {
		return $this->_methodNames;
	}

	public function setMethodNames($methodNames) {
		$this->_methodNames = $methodNames;
		return $this;
	}

	public function getOpParams() {
		return $this->_opParams;
	}

	public function setOpParams($opParams) {
		$this->_opParams = $opParams;
		return $this;
	}

	public function getReflection() {
		return $this->_reflection;
	}

	public function setReflection($reflection) {
		$this->_reflection = $reflection;
		return $this;
	}
	
}
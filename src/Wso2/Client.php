<?php
namespace Wso2;

use Soa\Model\RightFax\Request\CheckConnectivity;

class Client extends \WSClient {

    protected $_proxy = null;
    
    public function __construct($wsdl = null, array $options) {
        
        if(isset($options['location']) && !isset($options['to'])) {
            $options['to'] = $options['location'];
            unset($options['location']);
        }
        
        if($wsdl !== null) {
            $options = array_merge_recursive($options, array('wsdl' => $wsdl));
        }
        
        $options["useSOAP"] = "1.2";
        
        $options['useWSA']  = true;
        
        $options['useMTOM'] = true;
        
        parent::__construct($options);
        
        $this->getProxy();
    }
    
    public function __soapCall($methodName, $arguments = null, $options = null, $inputHeaders = null, $outputHeaders = null) {
        return $this->__call($methodName, $arguments);
    }
    
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->_proxy, $name), $arguments);
    }
    
    public function getProxy() {
        if($this->_proxy === null) {
            $this->_proxy = parent::getProxy();
        }
        return $this->_proxy;
    }
}
?>

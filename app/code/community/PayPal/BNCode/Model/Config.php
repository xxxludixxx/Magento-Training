<?php

/**
 * Main Model
 *
 * @category   Project
 * @package    Project_PayPal
 * @copyright  Copyright (c) 2014 Creatuity Corp. (http://www.creatuity.com)
 * @license    http://creatuity.com/license/
 */
class PayPal_BNCode_Model_Config extends Mage_Paypal_Model_Config {

    const EDITION_COMMUNITY = 'Community';
    const EDITION_ENTERPRISE = 'Enterprise';

    public function getBuildNotationCode($countryCode = null) {
        switch($this->_getEdition()) {
            case self::EDITION_COMMUNITY;
                $productCode = 'MagentoCE';
                break;
            case self::EDITION_ENTERPRISE;
                $productCode = 'MagentoEE';
                break;
            default :
                $productCode = 'Custom';
        }
        return sprintf('CC_SI_%s', $productCode);
    }
    
    protected function _getEdition() {
        if(method_exists('Mage', 'getEdition')) {
            return Mage::getEdition();
        } else {
            return $this->_isEntepriseEdition() ? self::EDITION_ENTERPRISE : self::EDITION_COMMUNITY;
        }
    }
    
    protected function _isEntepriseEdition() {
        $version = Mage::getVersion();
        if(version_compare ( $version, '1.10.0', '>=' )
            && version_compare ( $version, '1.13.0', '<=' )) {
            return true;
       }
       return false;
    }
    
    public function setCorrectModuleClass() {
        Mage::getConfig()->setNode('global/models/paypal/rewrite/config', 'PayPal_BNCode_Model_Config');
    }

}

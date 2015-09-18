<?php
/**
 * File: Store.php
 *
 *   Source model for stores, including "All" option
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 16.09.15 10:47
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Adminhtml_Form_Source_Store
{
    /**
     * Prepare and return array of stores ids and their names
     *
     * @param bool $withAll Whether to prepend "All Stores" option on not
     * @return array
     */
    public function toOptionArray($withAll = true)
    {
        /** @var Mage_Adminhtml_Model_System_Store $stores */
        $stores = Mage::getSingleton('adminhtml/system_store')->getStoreOptionHash($withAll);
//        if ($withAll) {
//            $stores = array(0 => Mage::helper('itanium_referral')->__('All Stores'))
//                + $stores;
//        }
        return $stores;
    }
}
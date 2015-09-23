<?php
/**
 * File: Abstract.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 16.09.15 10:42
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Getter
     *
     * @return Katai_Reports_Model_Entity
     */
    public function getReport()
    {
        return Mage::registry('current_katai_report_entity');
    }

    /**
     * Return the select fields array
     * @return array
     */
    public function getSelectFields()
    {
        $customOptions = $this->getReport()->getCustomOptions();
        if ( isset($customOptions['select_fields'])) {
            return $customOptions['select_fields'];
        }

        return [];
    }


    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('report/katai/reports/' . $action);
    }


    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
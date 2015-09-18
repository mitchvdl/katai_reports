<?php
/**
 * File: Edit.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 16.09.15 10:37
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Internal constructor
     */
    protected function _construct()
    {

        $this->setTemplate('katai/reports/widget/form/tab/container.phtml');

        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'katai_reports';
        $this->_controller = 'adminhtml_katai_reports';
        $this->_mode = 'edit';

        parent::_construct();

        if ($this->_isAllowedAction('save')) {

            $this->_updateButton('save', 'label', Mage::helper('katai_reports')->__('Save eeee'));
            $this->_addButton('saveandcontinue', array(
                'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick'   => 'saveAndContinueEdit(\''.$this->_getSaveAndContinueUrl().'\')',
                'class'     => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }

        if ($this->_isAllowedAction('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('katai_reports')->__('Delete Report'));
        } else {
            $this->_removeButton('delete');
        }
    }
    /**
     * Getter.
     * Return header text in order to create or edit report
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_katai_report_entity')->getId()) {
            return Mage::helper('katai_reports')->__('Edit Report');
        } else {
            return Mage::helper('katai_reports')->__('New Report');
        }
    }

    /**
     * report validation URL getter
     *
     */
    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return true;
        return Mage::getSingleton('admin/session')->isAllowed('report/katai/reports/' . $action);
    }

}
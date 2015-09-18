<?php
/**
 * File: Custom.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 18.09.15 11:59
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Tab_Custom extends Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Prepare form
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('report_');

        $fieldset = $form->addFieldset('custom_fieldset', array('legend' => Mage::helper('katai_reports')->__('Custom')));

        for ( $i = 0; $i < 5 ; $i++) {
            $field = $fieldset->addField('title' . $i, 'text', array(
                'name'   => 'title' . $i,
                'title'  => Mage::helper('katai_reports')->__('Title'),
                'label'  => Mage::helper('katai_reports')->__('Title'),
//                'class'     => 'required-entry',
//                'required'  => true,
//            'readonly'=> true,
//            'disabled'=> true,
                'tabindex' => 30,
            ));
        }

        Mage::dispatchEvent('adminhtml_katai_reports_edit_tab_custom_prepare_form', array('form' => $form));

        $form->setUseContainer(true);
        $form->setValues($this->getReport()->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('katai_reports')->__('Custom');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('katai_reports')->__('Custom');
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

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('katai/reports/' . $action);
    }
}
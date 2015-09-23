<?php
/**
 * File: Report.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 18.09.15 11:59
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Tab_Report extends Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract
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

        $fieldset = $form->addFieldset('report_fieldset', array('legend' => Mage::helper('katai_reports')->__('Report Details')));

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

        Mage::dispatchEvent('adminhtml_katai_reports_edit_tab_report_prepare_form', array('form' => $form));

//        $form->setUseContainer(true);
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
        return Mage::helper('katai_reports')->__('Report Details');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('katai_reports')->__('Report Details');
    }

}
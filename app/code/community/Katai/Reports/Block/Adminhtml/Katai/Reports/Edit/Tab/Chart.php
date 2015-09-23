<?php
/**
 * File: Chart.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Tab_Chart extends Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract
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

        $fieldset = $form->addFieldset('chart_fieldset', array('legend' => Mage::helper('katai_reports')->__('Chart Details'), 'class' => 'fieldset-wide'));

        $field = $fieldset->addField('custom_options_chart_type', 'select', array(
            'name'   => 'custom_options[chart_type]',
            'title'  => Mage::helper('katai_reports')->__('Chart Type'),
            'label'  => Mage::helper('katai_reports')->__('Chart Type'),
            'class'     => 'required-entry input-select',
            'required'  => true,
            'options'    => Mage::getSingleton('katai_reports/adminhtml_form_source_chart_type')->toOptionArray(false),
            'tabindex' => 30,
        ));

        $fieldset->addField('custom_options_chart_options', 'textarea', array(
            'name'   => 'custom_options[chart_options]',
            'label'     => Mage::helper('katai_reports')->__('Custom Chart Options'),
            'id'        => 'sql_query',
            'title'     => Mage::helper('katai_reports')->__('Custom Chart Options, Array style'),
            'class'     => 'input-textarea',
            'required'  => true,
            'tabindex'  => 40
        ));


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
        return Mage::helper('katai_reports')->__('Chart Details');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('katai_reports')->__('Chart Details');
    }

}
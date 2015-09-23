<?php
/**
 * File: Query.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 18.09.15 11:59
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Tab_Query extends Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract
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

        $fieldset = $form->addFieldset('query_fieldset', array('legend' => Mage::helper('katai_reports')->__('Query'), 'class' => 'fieldset-wide'));

        $fieldset->addField('sql_query', 'textarea', array(
            'name'      => 'sql_query',
            'label'     => Mage::helper('katai_reports')->__('Custom SQL Query'),
            'id'        => 'sql_query',
            'title'     => Mage::helper('katai_reports')->__('Custom SQL Query'),
            'class'     => 'input-textarea',
            'required'  => true,
//            'style'        => 'width: 80px',
        ));

        $fieldset->addField('custom_options_fields', 'text', array(
            'name'      => 'custom_options[select_fields]',
            'label'     => Mage::helper('katai_reports')->__('Query Fields'),
            'required'  => false,
        ));

        $customOptionsFields = $form->getElement('custom_options_fields');
        $customOptionsFields->setRenderer(
            $this->getLayout()->createBlock('katai_reports/adminhtml_katai_reports_edit_renderer_custom_options_select_fields')->setSelectFields($this->getSelectFields())
        );

        Mage::dispatchEvent('adminhtml_katai_reports_edit_tab_query_prepare_form', array('form' => $form));

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
        return Mage::helper('katai_reports')->__('Query');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('katai_reports')->__('Query');
    }

}
<?php
/**
 * File: Fields.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 22.09.15 18:36
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Renderer_Custom_Options_Select_Fields
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected function _construct()
    {
        $this->setTemplate('katai/reports/renderer/custon/options/select/fields.phtml');
        parent::_construct();
    }


    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
}
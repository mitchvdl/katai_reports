<?php
/**
 * File: Form.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 16.09.15 10:42
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form extends Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Form_Abstract
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'action' => Mage::getUrl('*/*/save', ['entity_id' => $this->getReport()->getId() ]),
            'method' => 'post'
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
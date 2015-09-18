<?php
/**
 * File: Tabs.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 18.09.15 11:54
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('katai_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('katai_reports')->__('Report Information'));
    }
}
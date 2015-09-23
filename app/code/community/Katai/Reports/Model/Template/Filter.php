<?php

class Katai_Reports_Model_Template_Filter extends Varien_Filter_Template
{
    /**
     * Cunstruction regular expression
     */
    const TABLE_CONSTRUCTION_PATTERN = '/{{table (.*?)}}/si';

    /**
     * Use absolute links flag
     *
     * @var bool
     */
    protected $_useAbsoluteLinks = false;

    /**
     * Whether to allow SID in store directive: NO
     *
     * @var bool
     */
    protected $_useSessionInUrl = false;

    /**
     * Set use absolute links flag
     *
     * @param bool $flag
     * @return Mage_Core_Model_Email_Template_Filter
     */
    public function setUseAbsoluteLinks($flag)
    {
        $this->_useAbsoluteLinks = $flag;
        return $this;
    }

    /**
     * Setter whether SID is allowed in store directive
     * Doesn't set anything intentionally, since SID is not allowed in any kind of emails
     *
     * @param bool $flag
     * @return Mage_Core_Model_Email_Template_Filter
     */
    public function setUseSessionInUrl($flag)
    {
        $this->_useSessionInUrl = (bool) $flag;
        return $this;
    }

    /**
     * Retrieve Skin URL directive
     *
     * @param array $construction
     * @return string
     * @see Mage_Core_Model_Email_Template_Filter::skinDirective() method has been copypasted
     */
    public function skinDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);
        $params['_absolute'] = $this->_useAbsoluteLinks;

        $url = Mage::getDesign()->getSkinUrl($params['url'], $params);

        return $url;
    }

    /**
     * Retrieve media file URL directive
     *
     * @param array $construction
     * @return string
     * @see Mage_Core_Model_Email_Template_Filter::mediaDirective() method has been copypasted
     */
    public function mediaDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);
        return Mage::getBaseUrl('media') . $params['url'];
    }

    /**
     * Retrieve store URL directive
     * Support url and direct_url properties
     *
     * @param array $construction
     * @return string
     * @see Mage_Core_Model_Email_Template_Filter::storeDirective() method has been copypasted
     */
    public function storeDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);
        if (!isset($params['_query'])) {
            $params['_query'] = array();
        }
        foreach ($params as $k => $v) {
            if (strpos($k, '_query_') === 0) {
                $params['_query'][substr($k, 7)] = $v;
                unset($params[$k]);
            }
        }
        $params['_absolute'] = $this->_useAbsoluteLinks;

        if ($this->_useSessionInUrl === false) {
            $params['_nosid'] = true;
        }

        if (isset($params['direct_url'])) {
            $path = '';
            $params['_direct'] = $params['direct_url'];
            unset($params['direct_url']);
        }
        else {
            $path = isset($params['url']) ? $params['url'] : '';
            unset($params['url']);
        }

        return Mage::app()->getStore(Mage::getDesign()->getStore())->getUrl($path, $params);
    }

    public function filter($value)
    {


        foreach (array(
                     self::TABLE_CONSTRUCTION_PATTERN => 'tableDirective',
                 ) as $pattern => $directive) {
            if (preg_match_all($pattern, $value, $constructions, PREG_SET_ORDER)) {
                foreach($constructions as $index => $construction) {
                    $replacedValue = '';
                    $callback = array($this, $directive);
                    if(!is_callable($callback)) {
                        continue;
                    }
                    try {
                        $replacedValue = call_user_func($callback, $construction);
                    } catch (Exception $e) {
                        throw $e;
                    }
                    $value = str_replace($construction[0], $replacedValue, $value);
                }
            }
        }

        $value = parent::filter($value);
        return $value;
    }

    public function tableDirective($construction)
    {
        if (count($this->_templateVars)==0) {
            // If template preprocessing
//            return $construction[0];
        }
        $replacedValue = $this->_getVariable($construction[1], '');

        return $replacedValue;
    }

    /**
     * Return variable value for var construction
     *
     * @param string $value raw parameters
     * @param string $default default value
     * @return string
     */
    protected function _getVariable($value, $default='{no_value_defined}')
    {
        Varien_Profiler::start("email_template_proccessing_variables");
        $tokenizer = new Varien_Filter_Template_Tokenizer_Variable();
        $tokenizer->setString($value);
        $stackVars = $tokenizer->tokenize();
        $result = $default;
        $last = 0;
        for($i = 0; $i < count($stackVars); $i ++) {
            if ($i == 0 && isset($this->_templateVars[$stackVars[$i]['name']])) {
                // Getting of template value
                $stackVars[$i]['variable'] =& $this->_templateVars[$stackVars[$i]['name']];
            } elseif (isset($stackVars[$i-1]['variable']) && $stackVars[$i-1]['variable'] instanceof Varien_Object) {

            } else {
                $this->_templateVars[$stackVars[$i]['name']] = Mage::getSingleton('core/resource')->getTableName($stackVars[$i]['name']);
                $stackVars[$i]['variable'] =& $this->_templateVars[$stackVars[$i]['name']];
            }
        }

        if(isset($stackVars[$last]['variable'])) {
            // If value for construction exists set it
            $result = $stackVars[$last]['variable'];
        }
        Varien_Profiler::stop("email_template_proccessing_variables");
        return $result;
    }

}

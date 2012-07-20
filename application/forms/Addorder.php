<?php
class Validator_Quantity extends Zend_Validate_Abstract
{
	const IS_ZERO = 'isZero';

	protected $_messageTemplates = array(
		self::IS_ZERO => 'Zero'
    );
    
	public function isValid($value)
	{
		$this->_setValue($value);
		$isValid = true;

		if ($value == 0) {
		$this->_error(self::IS_ZERO);
		$isValid = false;
	}
	return $isValid;
	}
}

class Application_Form_Addorder extends Zend_Form
{

	protected $_id;
	
	public function setaddid($id)
	{
		$this->_id = $id;
		return $this->_id;
	}
    
	public function init()
    {
    	error_reporting(1);
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('onsubmit', 'return sendData(this, "/parseorder/' . $this->_id . '", ' . $this->_id . ');');
 
        // Имя
        $formName = new Zend_Form_Element_Text('quantity');
        $formName->setRequired();
        $formName->setFilters(array('StringTrim'));
        $formName->setValidators(array(
        		'alnum',
        		array('regex', false, '/^[0-9]+$/'),
        		
    	))->addValidator(new Validator_Quantity());      
        
        $this->addElement($formName);
		
		
		
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',
        ));
    }


}


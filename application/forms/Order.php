<?php
/*class Validator_Quantity extends Zend_Validate_Abstract
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
}*/

class Application_Form_Order extends Zend_Form
{

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
        $this->setAttrib('onsubmit', 'return sendOrder(this, "/cart");');
 
        // Имя
        $formName = new Zend_Form_Element_Text('name');
        $formName->setLabel('Ваше имя:');
        $formName->setRequired();
        $formName->setFilters(array('StringTrim'));
        $formName->setValidators(array());      
        $formName->setDecorators(array(
	        array('ViewHelper'),
	        array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'name_error', 'style' => 'display:none')),
	        array('HtmlTag', array('tag' => 'dd', 'id' => 'name-element')),
	        array('Label', array('tag' => 'dt')),
        ));
        
        $this->addElement($formName);
        
        // Компания
        $formCompany = new Zend_Form_Element_Text('company');
        $formCompany->setLabel('Компания:');
        $formCompany->setRequired(false);
        $formCompany->setFilters(array('StringTrim'));
        $formCompany->setValidators(array());
        $formCompany->setDecorators(array(
	        array('ViewHelper'),
	        array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'company_error', 'style' => 'display:none')),
	        array('HtmlTag', array('tag' => 'dd', 'id' => 'company-element')),
	        array('Label', array('tag' => 'dt')),
        ));
        $this->addElement($formCompany);
        
        // Эл. адрес
        $formMail = new Zend_Form_Element_Text('email');
        $formMail->setLabel('Эл. адрес:');
        $formMail->setRequired(false);
        $formMail->setFilters(array('StringTrim'));
        $formMail->setValidators(array('EmailAddress'));
        $formMail->setDecorators(array(
	        array('ViewHelper'),
	        array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'email_error', 'style' => 'display:none')),
	        array('HtmlTag', array('tag' => 'dd', 'id' => 'email-element')),
	        array('Label', array('tag' => 'dt')),
        ));
        $this->addElement($formMail);
        
        // Телефон
        $formPhone = new Zend_Form_Element_Text('phone');
        $formPhone->setLabel('Телефон:');
        $formPhone->setRequired();
        $formPhone->setFilters(array('StringTrim'));
        $formPhone->setValidators(array(
        	'alnum',
        	array('regex', false, '/^[0-9]{10}$/')
        ));
        $formPhone->setDecorators(array(
       		array('ViewHelper'),
        	array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'phone_error', 'style' => 'display:none')),
        	array('HtmlTag', array('tag' => 'dd', 'id' => 'phone-element')),
        	array('Label', array('tag' => 'dt')),
        ));
        $this->addElement($formPhone);
        
        // Адрес доставки
        $formAdress = new Zend_Form_Element_Textarea('adress');
        $formAdress->setLabel('Адрес доставки:');
        $formAdress->setRequired();
        $formAdress->setDecorators(array(
       		array('ViewHelper'),
        	array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'adress_error', 'style' => 'display:none')),
        	array('HtmlTag', array('tag' => 'dd', 'id' => 'adress-element')),
        	array('Label', array('tag' => 'dt')),
        ));
        $this->addElement($formAdress);
        
        // Комментарий
        $formComment = new Zend_Form_Element_Textarea('comment');
        $formComment->setLabel('Комментарий:');
        $formComment->setRequired(false);
        $formComment->setDecorators(array(
	        array('ViewHelper'),
	        array(array('Errors' => 'HtmlTag'), array('placement' => 'append', 'class' => 'error', 'id' => 'comment_error', 'style' => 'display:none')),
	        array('HtmlTag', array('tag' => 'dd', 'id' => 'comment-element')),
	        array('Label', array('tag' => 'dt')),
        ));
        $this->addElement($formComment);
		
		
		
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Отправить заказ',
        ));
    }


}


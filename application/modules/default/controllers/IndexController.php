<?php

class IndexController extends Zend_Controller_Action
{
    private $abstractModel;
    private $model;
	private $contentModel;
    //private $img;
    private $help;
	private $receiver;
	
	public function init()
    {
        $this->model = new Application_Model_Default();
		$this->contentModel = new Content_Model_Frontend;
        $this->abstractModel = new Application_Model_Abstract();
        $this->help = $this->model->abstractModel->help;
		$this->view->help = $this->help;
        //$this->img = new img();
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('feedback', 'json');
        $ajaxContext->initContext('json');
        $this->receiver = 'arkanchik@i.ua';
        //$this->receiver = 'shmaliy.maxim@gmail.com';
	}

    /*
     * Правая колонка главной страницы
     */
    public function indexAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    }
    
    
    /*
    * Отображение телефонов 
    * в хедере сайта
    */
    public function topcontactsAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$item = $this->contentModel->getStaticContent('contacts');
    	$this->view->item = $item;
    }
    
    
    /*
     * Отображение анимационного баннера
     * "Поминальная трапеза" в левой колонке
     * сайта 
     */
    public function menubannerAction() {}

    
    /*
     * Отображение основного текстового блока 
     * на главной странице
     */
    public function seoAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	//$this->help->arrayTrans($params);
    	
    	$item = $this->contentModel->getStaticContent('frontpage_text');
    	$this->view->item = $item;
    	
    	//$this->help->arrayTrans($item);
    }
    
    
    public function translateError($eArray = null)
    {
    	if(is_null($eArray) || !is_array($eArray) || empty($eArray)){
    		return false;
    	}
    	
    	$translate = array(
    		"name" => array(
    			"isEmpty" => "Укажите свое имя"
    		),
    		"email" => array(
    	    	"emailAddressInvalidHostname" => "Корректно заполните электронную почту",
    			"hostnameInvalidHostname" => "Корректно заполните электронную почту",
    			"hostnameLocalNameNotAllowed" => "Корректно заполните электронную почту",
    			"isEmpty" => "Заполните электронную почту",
    		),
	    	"phone" => array(
	    	    "regexNotMatch" => "Корректно заполние номер телефона"
	    	),
	    	"question" => array(
	    	    "isEmpty" => "Введите свой вопрос"
	    	),
    	);
    	
    	foreach ($eArray as $pKey=>&$pValue) {
    		foreach ($pValue as &$eCode) {
    			$eCode = $translate[$pKey][$eCode];
    		}
    	}
    	
    	foreach ($eArray as $pKey=>&$pValue) {
    		$pValue = array_unique($pValue);
    	}
    	
    	
    	return $eArray;
    }
    
    /*
     * Форма обратной связи 
     * в правой колонке сайта
     * Ошибки имени
     * isEmpty
     *
     * Ошибки телефона
     * regexNotMatch
     *
     * Ошибки эл почты
     * emailAddressInvalidHostname
     * hostnameInvalidHostname
     * hostnameLocalNameNotAllowed
     * isEmpty
     *
     * Ошибки сообщения
     * isEmpty
    */
    public function feedbackAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$form = new Application_Form_Feedback();
    	
    	if ($request->isXmlHttpRequest() || $request->isPost()) {
    		$this->view->clearVars();
    		
    		$params['question'] = strip_tags($params['question']);
    		
    		$this->view->validationErrors = array();
    		if (!$form->isValid($params)) {
    			$validationErrors = $form->getErrors();
    			unset($validationErrors['submit']);
    			$this->view->validationErrors = $this->translateError($validationErrors);
    			$this->view->send = '0';
    			return;
    		}
    		
    		/*$mail = new Zend_Mail();
    		$mail->setBodyText($params['question'])
    		->setFrom($params['email'], $params['name'] . ' ' . $params['phone'])
    		->addTo($this->receiver, 'Аркадий Волков')
    		->setSubject('Вопрос от пользователя сайта')
    		->send();*/
    		
    		$this->sendMail($params);
    		$this->view->send = '1';
    		$this->view->form = $form;
    		
    		
    	} else {
    		$this->view->form = $form;
    	}
    }
    
    public function sendMail($params)
    {
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; windows-1251' . "\r\n";
    	
    	// Additional headers
    	
    	//$mail_params = $this->help->encToFrontend($params);
    	
    	$headers .= 'From: <question@rekviem.org> ' . "\r\n";
    	
    	$to      = $this->receiver;
    	$subject = iconv('UTF-8', 'windows-1251', 'Вопрос');
    	$message = '<strong>Имя:</strong> ' . iconv('UTF-8', 'windows-1251', $params['name']) . '<br />';
    	$message .= '<strong>Эл. адрес:</strong> ' . $params['email'] . '<br />';
    	$message .= '<strong>Телефон:</strong> ' . iconv('UTF-8', 'windows-1251', $params['phone']) . '<br />';
    	$message .= '<strong>Сообщение:</strong> ' . iconv('UTF-8', 'windows-1251', $params['question']) . '<br />';
    	
    	mail($to, iconv('windows-1251', 'UTF-8', $subject), $message, $headers);
    }
    
    public function newoffersAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$items = $this->contentModel->getDymanicContentList('offers', 'ordering', 'asc', 3);
    	
    	if (!empty($items)) {
    		foreach ($items as &$item) {
    			if(!empty($item['image'])) {
    				$this->sImage->setImage($item['image']);
    				$this->sImage->setCompression(100);
    				$this->sImage->setCacheDirName('thumbs_80px');
    				$this->sImage->resizeToWidth(80);
    				$thumb = $this->sImage->save();
    				$item['image'] = $this->sImage->save();
    			}
    			$item['introtext'] = str_replace('<br />', '', $item['introtext']);
    			$item['introtext'] = str_replace('<p>', '', $item['introtext']);
    			$item['introtext'] = str_replace('</p>', '<br />', $item['introtext']);
    		}
    	}
    	$this->view->items = $items;
    }
    
    public function newinfoAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$items = $this->contentModel->getDymanicContentList('info', 'ordering', 'asc', 3);
    	 
    	if (!empty($items)) {
    		foreach ($items as &$item) {
    			if(!empty($item['image'])) {
    				$item['image'] = $this->help->createSquareLink($item['image'], 80);
    			}
    			$item['introtext'] = str_replace('<br />', '', $item['introtext']);
    			$item['introtext'] = str_replace('<p>', '', $item['introtext']);
    			$item['introtext'] = str_replace('</p>', '<br />', $item['introtext']);
    		}
    	}
    	$this->view->items = $items;
    }
    
    public function footertextAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$item = $this->contentModel->getStaticContent('footer');
    	$this->view->item = $item;
    }
    
    public function footercountersAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    }
}




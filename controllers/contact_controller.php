<?php
/**
 * ContactController class
 *
 * @uses          AppController
 * @package       base
 * @subpackage    base.controllers
 */
class ContactController extends AppController {

/**
 * name property
 *
 * @var string 'Contact'
 * @access public
 */
	var $name = 'Contact';

/**
 * postActions property
 *
 * @var array
 * @access public
 */
	var $postActions = array(
		'admin_delete',
		'admin_block',
	);

/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array('Contact', 'MiEmail');

/**
 * paginate property
 *
 * @var array
 * @access public
 */
	var $paginate = array(
		'order' => array('id DESC')
);

/**
 * beforeFilter method
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		$this->Auth->allow(array('index', 'us'));
		parent::beforeFilter();
	}

/**
 * admin_block method
 *
 * @return void
 * @access public
 */
	function admin_block() {
		$this->Session->setFlash('Not implemented');
		return $this->_back();
	}

/**
 * admin_index method
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$conditions = $this->SwissArmy->parseSearchFilter();
		if ($conditions) {
			$this->set('filters', $this->MiEmail->searchFilterFields());
			$this->set('addFilter', true);
		}
		$conditions['MiEmail.template'] = 'contact/us';
		$this->data = $this->paginate('MiEmail', $conditions);
		$this->_setSelects();
	}

/**
 * admin_score method
 *
 * Reevaluate and display the score for a contact message
 *
 * @param mixed $id
 * @return void
 * @access public
 */
	function admin_score($id) {
		$data = $this->MiEmail->read(null, $id);
		$score = $this->Contact->score($data['MiEmail']['data'], true);
		$this->Session->setFlash('Rule Matches (rule:individual score): <br />' . implode('<br />', explode(';', $this->Contact->data['Contact']['junk_rule_matches'])));
		$this->Session->setFlash('Overall Junk Score: ' . $this->Contact->data['Contact']['junk_score']);
		return $this->_back();
	}

/**
 * index method
 *
 * @return void
 * @access public
 */
	function index() {
		$this->redirect(am($this->passedArgs, array('action' => 'us')), 301);
	}

/**
 * us method
 *
 * @return void
 * @access public
 */
	function us() {
		if ($this->data) {
			App::import('Component', 'RequestHandler');
			$this->data['Contact']['from_user_id'] = $this->Auth->user('id');
			$this->data['Contact']['ip'] = ip2long(RequestHandlerComponent::getClientIp());
			$this->Contact->create($this->data);
			if ($this->Contact->save()) {
				$this->Session->setFlash(__('Your messages has been sent, thanks for your interest!', true));
				return $this->_back();
			}
			$this->Session->setFlash(__('Please correct the errors below', true));
		} else {
			$this->data['Contact'] = $this->passedArgs;
		}
	}

/**
 * setSelects method
 *
 * No selects
 *
 * @return void
 * @access protected
 */
	function _setSelects() {
	}
}
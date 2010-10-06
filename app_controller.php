<?php
class AppController extends Controller {

/**
 * components property
 *
 * @var array
 * @access public
 */
	public $components = array(
		'Mi.MiSession',
		'Mi.SwissArmy' => array('autoLayout' => true),
		'MiUsers.RememberMe',
		'Auth',
		'RequestHandler',
	);

/**
 * helpers property
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Mi.MiForm',
		'Mi.MiHtml',
		'Mi.Menu',
		'MiAsset.Asset',
		'MiEnums.Enum',
		'Time',
		'Text',
	);

/**
 * view property
 *
 * @var string 'Mi'
 * @access public
 */
	public $view = 'Mi.Mi';

/**
 * namedParams property
 *
 * @var bool true
 * @access public
 */
	public $namedParams = true;

/**
 * postActions property
 *
 * @var array
 * @access public
 */
	public $postActions = array(
		'admin_delete'
	);

/**
 * construct method
 *
 * Prevent missing component error if the DebugKit toolbar isn't available.
 * Load the dev and tidy panels (tidy panel is linux only) if available
 *
 * @return void
 * @access private
 */
	 public function __construct() {
		if (Configure::read() && !defined('CAKEPHP_SHELL') && App::import('Component', 'DebugKit.Toolbar')) {
			$panels = array();
			if (App::import('Vendor', 'MiDevelopment.DevPanel')) {
				if (DS === '/' && $this->_exec('which tidy')) {
					$panels[] = 'MiDevelopment.Tidy';
				}
				$panels[] = 'MiDevelopment.Dev';
			}
			$this->components['DebugKit.Toolbar'] = array(
				'panels' => $panels,
				'forceEnable' => true,
			);
		}
		return parent::__construct();
	}

/**
 * mergeVars method
 *
 * Put the toolbar first so that initialization of other components is included in the
 * 'Component Initialization' timer
 *
 * @TODO change visibility
 * @return void
 * @access private
 */
	public function __mergeVars() {
		parent::__mergeVars();
		if (!Configure::read() || !isset($this->components['DebugKit.Toolbar'])) {
			return;
		}
		$this->components = array_merge(array('DebugKit.Toolbar' => $this->components['DebugKit.Toolbar']), $this->components);
	}

/**
 * log method
 *
 * Always log the ip
 *
 * @param mixed $message
 * @param mixed $type
 * @return void
 * @access public
 */
	public function log($message, $type = null) {
		if (!class_exists('RequestHandlerComponent')) {
			App::import('Component', 'RequestHandler');
		}
		if (!is_string($message)) {
			$message = print_r($message, true); //@ignore
		}
		$message = RequestHandlerComponent::getClientIP() . "\t" . $message;
		parent::log($message, $type);
	}

/**
 * beforeFilter method
 *
 * Set a default page title from the po file
 * Set to ajax layout if it's a popup request
 * Also set the requirePost property of the security component to the controller's postActions property
 *
 * @return void
 * @access public
 */
	public function beforeFilter() {
		if (isset($this->SwissArmy)) {
			$this->SwissArmy->setDefaultPageTitle();
			$this->SwissArmy->handlePostActions();
		}
		$this->Auth->authorize = 'controller';
		$this->Auth->loginAction = '/users/login';
		$this->Auth->logoutRedirect = '/';
		if (!$this->Auth->user()) {
			$this->Auth->authError = __('Please login to continue', true);
		}
	}

/**
 * If it's an admin call - load the MiPanel component if possible to get instant panel
 * styles
 *
 * @return void
 * @access public
 */
	public function beforeRender() {
		if (!empty($this->params['admin']) &&
			empty($this->params['isAjax']) &&
			App::import('Component', 'MiPanel.MiPanel')) {
			$this->SwissArmy->loadComponent('MiPanel.MiPanel');
			$this->MiPanel->setPanelPaths();
		}
	}

/**
 * admin_lookup method
 *
 * @param string $term ''
 * @param string $format 'ui'
 * @return void
 * @access public
 */
	public function admin_lookup($term = '', $format = 'ui') {
		Configure::write('debug', 0); //safeguard
		$this->autoRender = false;

		if (!$term) {
			if (!empty($this->params['url']['term'])) {
				$term = $this->params['url']['term'];
			} elseif (!empty($this->params['url']['q'])) {
				$term = $this->params['url']['q'];
			}
		}

		$this->data = MiCache::data($this->modelClass, 'search', $term, $this->params['named']);

		if ($format === 'ui') {
			$return = array();
			foreach($this->data as $id => &$row)  {
				$return[] = array('label' => $row, 'value' => $row, 'id' => $id);
			}
			$this->output = json_encode($return);
		} else {
			$this->output = json_encode($this->data);
		}

		$path = WWW_ROOT . DS . trim($this->params['url']['url'], '/');
		$File = new File($path, true);
		$File->write($this->output);
	}

/**
 * redirect method
 *
 * If it's an ajax request, and the $force parameter is true - render a js redirect
 *
 * @param mixed $url
 * @param mixed $code null
 * @param bool $exit true
 * @param bool $force false
 * @return void
 * @access public
 */
	public function redirect($url, $code = null, $exit = true, $force = false) {
		if (isset($this->SwissArmy)) {
			if ($this->SwissArmy->redirect($url, $code, $exit, $force) && $exit) {
				$this->_stop();
			}
		}
		return parent::redirect($url, $code, $exit);
	}

/**
 * isAuthorized method
 *
 * Simple example,
 * if it's an admin user, no questions asked: allow,
 * If it's not an admin request: allow,
 * else these are not the droids you're looking for, deny.
 *
 * @return bool
 * @access public
 */
	public function isAuthorized() {
		if ($this->Auth->user('group') == 'admin') {
			return true;
		}
		if (empty($this->params['admin'])) {
			return true;
		}
		return false;
	}

/**
 * back method
 *
 * (hopefully) Intelligent referer logic
 * Convenience method to call the back method in the Swiss army component. Can be overriden if the true
 * referer is not actually useful.
 *
 * @param int $steps
 * @return void
 * @access protected
 */
	public function _back($steps = 1, $force = false) {
		if (isset($this->SwissArmy)) {
			if (($force || in_array($this->action, $this->postActions)) && $this->RequestHandler->isAjax()) {
				$url = $this->SwissArmy->back($steps, null, false);
				return $this->redirect($url, null, true, true);
			}
			return $this->SwissArmy->back($steps);
		}
		return $this->redirect($this->referer('/', true));
	}

/**
 * exec method
 *
 * @param mixed $cmd
 * @param mixed $out null
 * @return void
 * @access protected
 */
	protected function _exec($cmd, &$out = null) {
		if (!class_exists('Mi')) {
			APP::import('Vendor', 'Mi.Mi');
		}
		return Mi::exec($cmd, $out);
	}

/**
 * black hole method
 *
 * If a GET request is made for a method that must be run via POST/DELETE
 * present a confirmation screen which submits by POST/DELETE
 *
 * @param mixed $reason
 * @return void
 * @access protected
 */
	public function _blackHole($reason = null) {
		if (isset($this->SwissArmy)) {
			return $this->SwissArmy->blackHole($reason);
		}
		return false;
	}

/**
 * setSelects method
 *
 * Populate variables used for selects
 *
 * @return void
 * @access protected
 */
	protected function _setSelects($params = array()) {
		if (isset($this->SwissArmy)) {
			$this->SwissArmy->setSelects($params);
			return true;
		}
		return false;
	}
}
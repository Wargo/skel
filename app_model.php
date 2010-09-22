<?php
class AppModel extends Model {

/**
 * recursive property
 *
 * @var mixed -1
 * @access public
 */
	public $recursive = -1;

/**
 * backInnerAssociation property
 *
 * @var array
 * @access private
 */
	 private $__backInnerAssociation = array();

/**
 * construct method
 *
 * @param bool $id
 * @param mixed $table
 * @param mixed $ds
 * @return void
 * @access private
 */
	public function __construct($id = false, $table = null, $ds = null) {
		if (Configure::read() && (!$this->actsAs || !in_array('MiDevelopment.Development', $this->actsAs)) &&
			App::import('Behavior', 'MiDevelopment.Development')) {
			$this->actsAs[] = 'MiDevelopment.Development';
		}
		$this->actsAs[] = 'Mi.SwissArmy';

		$parentClass = get_parent_class($this);
		$this->plugin = str_replace('AppModel', '', $parentClass);

		parent::__construct($id, $table, $ds);
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
		parent::log(RequestHandlerComponent::getClientIP() . "\t" . $message, $type);
	}

/**
 * If the db has gone away - raise an appropriate error message
 *
 * @return void
 * @access public
 */
	public function onError() {
		$db = ConnectionManager::getInstance();
		$connected = $db->getDataSource($this->useDbConfig);
		if (!$connected->isConnected()) {
			return $this->cakeError('missingConnection', array(
				'className' => $this->alias . ' (' . $this->useDbConfig . ')',
			));
		}
	}

/**
 * invalidate method
 *
 * Translate error messages from codes to localized strings
 * Skip the error message if it doesn't look like a code (i.e. it's already been converted to text)
 *
 * @param mixed $field
 * @param bool $value
 * @return void
 * @access public
 */
	public function invalidate($field, $value = true) {
		if ($this->Behaviors->attached('SwissArmy')) {
			return $this->Behaviors->SwissArmy->invalidate($this, $field, $value);
		}
		return parent::invalidate($field, $value);
	}

/**
 * exists method
 *
 * @param bool $reset
 * @return void
 * @access public
 */
	public function exists($reset = false) {
		if (!is_bool($reset) && Configure::read()) {
			trigger_error('AppModel::exists - the variable $reset is not a bool. If you are passing conditions use the method hasAny.');
		}
		return parent::exists($reset);
	}

/**
 * find method
 *
 * By default - cache everything. Make your app db independent if the db data is static.
 *
 * Hat tip: http://www.milesj.me/blog/read/34/Cacheing-Each-Query-Individually
 *
 * @see _clearCache
 * @param string $type 'first'
 * @param array $params array()
 * @return void
 * @access public
 */
	public function find($type = 'first', $params = array()) {
		if (!array_key_exists('miCache', $params) || $params['miCache'] === true) {
			if (!class_exists('MiCache')) {
				APP::import('Vendor', 'Mi.MiCache');
			}

			$plugin = $this->plugin;
			if ($plugin) {
				$plugin = $plugin . '.';
			}
			unset($params['miCache']);
			return MiCache::data($plugin . $this->alias, 'find', $type, $params);
		}
		unset($params['miCache']);
		return parent::find($type, $params);
	}

/**
 * Disable cache for query
 *
 * @param mixed $query
 * @param bool $cacheQueries
 * @return void
 * @access public
 */
	public function query($query, $cacheQueries = false) {
		return parent::query($query, $cacheQueries);
	}

/**
 * schema method
 *
 * Prevent fullDebug for describe queries, so they aren't in the log
 *
 * @param bool $field
 * @return void
 * @access public
 */
	public function schema($field = false) {
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$fullDebug = $db->fullDebug;
		$db->fullDebug = false;
		$return = parent::schema($field);
		$db->fullDebug = $fullDebug;
		return $return;
	}

/**
 * parentNode method
 *
 * Override if not used
 *
 * @return void
 * @access public
 */
	public function parentNode() {
		if (isset($this->Behaviors->AclPlus)) {
			return $this->Behaviors->AclPlus->parentNode($this);
		}
		return $this->name;
	}

/**
 * updateCounterCache method
 *
 * @TODO override disabled, wip
 * @param array $keys
 * @param bool $created
 * @return void
 * @access public
 */
	public function updateCounterCache($keys = array(), $created = false) {
		if (!$this->Behaviors->attached('SwissArmy') || !$this->Behaviors->SwissArmy->updateCounterCache($this)) {
			return parent::updateCounterCache($keys, $created);
		}
	}

/**
 * resetAssociations method
 *
 * @link http://github.com/mcurry/lazy_loader/tree
 * @return void
 * @access public
 */
	public function resetAssociations() {
		return true;
	}

/**
 * clearCache method
 *
 * Delete all cached views and all cached data.
 * Override to be less agressive with clearing cached data if desired e.g.
 * 	// Only clear cached data for this model
 * 	MiCache::clear('plugin.thisName');
 * 	// ... and other model, which is dependent || has counterCache
 * 	MiCache::clear('plugin.otherName');
 *
 * @param mixed $type
 * @return void
 * @access protected
 */
	public function _clearCache($type = null) {
		$this->_exec('rm -rf ' . WWW_ROOT . 'cache/*');
		MiCache::clear();
		clearCache(null, 'views');
		clearCache(null, 'views', '');
		parent::_clearCache($type);
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
 * constructLinkedModel method
 *
 * @link http://github.com/mcurry/lazy_loader/tree
 * @param mixed $assoc
 * @param mixed $className null
 * @return void
 * @access private
 */
	public function __constructLinkedModel($assoc, $className = null) {
		foreach ($this->__associations as $type) {
			if (isset($this-> {$type}[$assoc])) {
				return;
			}
			if($type == 'hasAndBelongsToMany') {
				$withs = Set::extract('/with', array_values($this-> {$type}));
				if(in_array($assoc, $withs)) {
					return;
				}
			}
		}
		return parent::__constructLinkedModel($assoc, $className);
	}

/**
 * get method
 *
 * @link http://github.com/mcurry/lazy_loader/tree
 * @param mixed $name
 * @return void
 * @access private
 */
	public function __get($name) {
		if (isset($this-> {$name})) {
			return $this-> {$name};
		}
		return false;
	}

/**
 * isset method
 *
 * @link http://github.com/mcurry/lazy_loader/tree
 * @param mixed $name
 * @return void
 * @access private
 */
	public function __isset($name) {
		$className = false;
		foreach ($this->__associations as $type) {
			if (array_key_exists($name, $this-> {$type})) {
				$className = $this-> {$type}[$name]['className'];
				break;
			}
			if($type == 'hasAndBelongsToMany') {
				$withs = Set::extract('/with', array_values($this-> {$type}));
				if(in_array($name, $withs)) {
					$className = $name;
					break;
				}
			}
		}

		if($className) {
			parent::__constructLinkedModel($name, $className);
			parent::__generateAssociation($type);
			return $this-> {$name};
		}
		return false;
	}
}
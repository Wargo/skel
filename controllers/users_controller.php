<?php
class UsersController extends AppController {

/**
 * name property
 *
 * @var string 'Users'
 * @access public
 */
	public $name = 'Users';

/**
 * postActions property
 *
 * @var array
 * @access public
 */
	public $postActions = array(
		'admin_delete',
		'admin_sudo',
	);

/**
 * beforeFilter method
 *
 * Set the black hole to prevent white-screen-of-death symptoms for invalid form submissions.
 *
 * @access public
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('authFields', $this->Auth->fields);
		$this->Auth->allow(
			'confirm',
			'forgotten_password',
			'index',
			'logout',
			'profile',
			'register',
			'reset_password',
			'switch_language'
		);
		$this->Auth->autoRedirect = false;
		if (isset($this->Security)) {
			$this->Security->blackHoleCallback = '_blackHole';
		}
	}

/**
 * beforeRender method
 *
 * @return void
 * @access public
 */
	public function beforeRender() {
		unset($this->data['User'][$this->Auth->fields['password']]);
		unset($this->data['User']['confirm']);
		unset($this->data['User']['current_password']);
		return parent::beforeRender();
	}

/**
 * admin_delete method
 *
 * @param mixed $id null
 * @return void
 * @access public
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if ($id && $this->User->exists()) {
			$display = $this->User->display($id);
			if ($this->User->delete($id)) {
				$this->Session->setFlash(sprintf(__('Usuario %1$s "%2$s" borrado', true), $id, $display));
			} else {
				$this->Session->setFlash(sprintf(__('Ha ocurrido un problema borrando el usuario %1$s "%2$s"', true), $id, $display));
			}
		} else {
			$this->Session->setFlash(sprintf(__('El usuario con id %1$s no existe', true), $id));
		}
		return $this->_back();
	}

/**
 * admin_edit method
 *
 * @param mixed $id null
 * @return void
 * @access public
 */
	public function admin_edit($id = null) {
		if ($this->data) {
			if ($this->User->saveAll($this->data)) {
				$display = $this->User->display();
				$this->Session->setFlash(sprintf(__('Usuario "%1$s" actualizado', true), $display));
				return $this->_back();
			} else {
				$this->data = $this->User->data;
				if (Configure::read()) {
					foreach ($this->User->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					$this->Session->setFlash(implode($this->User->validationErrors, '<br />'));
				} else {
					$this->Session->setFlash(__('Hay errores en el formulario', true));
				}
			}
		} elseif ($id) {
			$this->data = $this->User->read(null, $id);
			if (!$this->data) {
				$this->Session->setFlash(sprintf(__('El usuario con id %1$s no existe', true), $id));
				$this->_back();
			}
		} else {
			return $this->_back();
		}
		$this->_setSelects();
	}

/**
 * admin_index method
 *
 * @return void
 * @access public
 */
	public function admin_index() {
		if (isset($this->SwissArmy)) {
			$conditions = $this->SwissArmy->parseSearchFilter();
		} else {
			$conditions = array();
		}
		if ($conditions) {
			$this->set('filters', $this->User->searchFilterFields());
			$this->set('addFilter', true);
		}
		$this->data = $this->paginate($conditions);
		$this->_setSelects();
	}

/**
 * admin_lookup method
 *
 * @param string $input ''
 * @return void
 * @access public
 */
	public function admin_lookup($input = '') {
		$this->autoRender = false;
		if (!$input) {
			$input = $this->params['url']['q'];
		}
		if (!$input) {
			$this->output = '0';
			return;
		}
		$conditions = array(
			'id LIKE' => $input . '%',
			'id LIKE' => $input . '%'
		);
		if (!$this->data = $this->User->find('list', compact('conditions'))) {
			$this->output = '0';
			return;
		}
		return $this->render('/elements/lookup_results');
	}

/**
 * admin_multi_edit method
 *
 * @return void
 * @access public
 */
	public function admin_multi_edit() {
		if ($this->data) {
			$data = array();
			foreach ($this->data as $key => $row) {
				if (!is_numeric($key)) {
					continue;
				}
				$data[$key] = $row;
			}
			if ($this->User->saveAll($data, array('validate' => 'first'))) {
				$this->Session->setFlash(sprintf(__('Usuario actualizado', true)));
			} else {
				if (Configure::read()) {
					foreach ($this->User->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					if($this->User->validationErrors) {
						$this->Session->setFlash(implode($this->User->validationErrors, '<br />'));
					} else {
						$this->Session->setFlash(__('No se ha guardado y no tiene errores de validación', true));
					}
				} else {
					$this->Session->setFlash(__('Alguno o todos los cambios no han sido guardados', true));
				}
			}
			$this->params['paging'] = $this->Session->read('User.paging');
			$this->helpers[] = 'Paginator';
		} else {
			$args = func_get_args();
			call_user_func_array(array($this, 'admin_index'), $args);
			array_unshift($this->data, 'dummy');
			unset($this->data[0]);
			$this->Session->write('User.paging', $this->params['paging']);
		}
		$this->_setSelects();
	}

/**
 * admin_multi_process method
 *
 * @param mixed $action null
 * @return void
 * @access public
 */
	public function admin_multi_process($action = null) {
		if (!$this->data) {
			$this->_back();
		}
		$ids = array_keys(array_filter($this->data['User']));
		if (!$ids) {
			$this->Session->setFlash(__('Nada seleccionado', true));
			$this->_back();
		}
		if (!$action && !empty($this->data['App']['multiAction'])) {
			$action = $this->data['App']['multiAction'];
		}

		switch ($action) {
			case 'deleteAll':
				$message = __('Usuarios eliminados', true);
				$this->User->deleteAll(array('User.id' => $ids));
				break;
			case 'editAll':
				$ids = array_keys(array_filter($this->data['User']));
				return $this->redirect(array(
					'action' => 'multi_edit',
					'id' => '(' . implode($ids, ',') . ')'
				));
			case 'emailVerifiedAll':
				$message = __('Usuarios marcados como email verificado', true);
				$this->User->updateAll(
					array('User.email_verified' => 1),
					array('User.id' => $ids)
				);
				return $this->render('admin_view');
				break;
			case 'unEmailVerifiedAll':
				$message = __('Usuarios marcados como email no verificado', true);
				$this->User->updateAll(
					array('User.email_verified' => 0),
					array('User.id' => $ids)
				);
				break;
			default:
				$this->Session->setFlash(__('No has definido ninguna acción', true));
				$this->_back();

		}
		$this->Session->setFlash($message);
		$this->_back();
	}

/**
 * admin_search method
 *
 * @param mixed $term null
 * @return void
 * @access public
 */
	public function admin_search($term = null) {
		if ($this->data) {
			$term = trim($this->data['User']['query']);
			$url = array(urlencode($term));
			if ($this->data['User']['extended']) {
				$url['extended'] = true;
			}
			$this->redirect($url);
		}
		$request = $_SERVER['REQUEST_URI'];
		$term = trim(str_replace(Router::url(array()), '', $request), '/');
		if (!$term) {
			$this->redirect(array('action' => 'index'));
		}
		$conditions = $this->User->searchConditions($term, isset($this->passedArgs['extended']));
		$this->Session->setFlash(sprintf(__('Todos los usuarios que coinciden con el término "%1$s"', true), htmlspecialchars($term)));
		$this->data = $this->paginate($conditions);
		$this->_setSelects();
		$this->render('admin_index');
	}

/**
 * assume the identity of another user
 *
 * @param mixed $id null
 * @return void
 * @access public
 */
	public function admin_sudo($id = null) {
		$this->Session->destroy();
		$this->Auth->login($id);
		$this->postLogin();
		$this->redirect('/');
	}

/**
 * admin_view method
 *
 * @param mixed $id null
 * @return void
 * @access public
 */
	public function admin_view($id = null) {
		$this->data = $this->User->read(null, $id);
		if(!$this->data) {
			$this->Session->setFlash(__('Usuario inválido', true));
			return $this->_back();
		}
	}

/**
 * change_password method
 *
 * Used for changing the password of a logged in user
 *
 * @return void
 * @access public
 */
	public function change_password() {
		if ($this->data) {
			list($return, $message) = $this->User->changePassword($this->data, $this->Auth->user());
			if ($message) {
				$this->Session->setFlash($message);
			}
			if ($return) {
				return $this->redirect('/');
			}
		}
	}

/**
 * confirm method
 *
 * @param mixed $token
 * @return void
 * @access public
 */
	public function confirm($token = null) {
		$this->set('token', $token);
		$fields = $this->User->accountFields();
		$this->set('fields', $fields);
		if (!$this->data) {
			return;
		}
		list($return, $message) = $this->User->confirmAccount($this->data);
		if ($message) {
			$this->Session->setFlash($message);
		}
		if ($return) {
			$this->Session->write('Auth.redirect', '/'); // Prevent auth from sending you back here
			return $this->redirect('/');
		}
	}

/**
 * edit method
 *
 * @return void
 * @access public
 */
	public function edit() {
		if ($this->data) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if ($this->User->save($this->data, true, array('email', 'first_name', 'last_name'))) {
				$this->Session->setFlash(__('Perfil actualizado', true));
				return $this->_back();
			} else {
				$this->Session->setFlash(__('Errores en el formulario', true));
			}
		} else {
			$this->data = $this->User->read(null, $this->Auth->user('id'));
		}
		$this->_setSelects();
	}

/**
 * forgotten_password method
 *
 * Send the user an email with a confirmation link/token in it. Use the $email (which could be an email or a username)
 * to find the users id. Don't send another email if there is one that is pending
 *
 * @access public
 * @return void
 */
	public function forgotten_password() {
		if ($this->data) {
			$email = $this->data['User']['email'];
			if (!$email) {
				$this->Session->setFlash(__('Falta el email', true));
				return;
			}
			list($return, $message) = $this->User->forgottenPassword($this->data['User']['email']);
			if ($message) {
				$this->Session->setFlash($message);
			}
			if ($return) {
				$this->redirect(array('action' => 'reset_password'));
			}
		}
	}

/**
 * index method
 *
 * @return void
 * @access public
 */
	public function index() {
		return $this->redirect('/', 301);
	}

/**
 * login method
 *
 * Only run if there is no user
 *
 * @access public
 * @return void
 */
	public function login() {
		if ($this->data) {
			if ($this->Auth->user('id')) {
				$this->User->id = $this->Auth->user('id');
				if (!empty($this->data['User']['remember_me'])) {
					$token = $this->User->token(null, array('length' => 100, 'fields' => array(
						$this->Auth->fields['username'], $this->Auth->fields['password']
					)));
					$this->SwissArmy->loadComponent('Cookie');
					$this->Cookie->write('User.id', $this->User->id, true, '+2 weeks');
					$this->Cookie->write('User.token', $token, true, '+2 weeks');
				}
				$display = $this->User->display();
				$this->Session->setFlash(sprintf(__('Bienvenido de nuevo %1$s.', true), $display));
				if ($this->RequestHandler->isAjax() && !empty($this->params['refresh'])) {
					return $this->_back(null, true);
				}
				return $this->_back();
			}
		} elseif ($this->Auth->user('id')) {
			return $this->_back(null, true);
		}
		if (Configure::read()) {
			$this->Session->setFlash('Debug only message: Save some tedium - check remember me.');
		}
	}

/**
 * logout method
 *
 * Delete the users cookie (if any), log them out, and send them a parting flash meassage. If no user is logged in just
 * send them back to where they came from (no reference to the session refer).
 *
 * @access public
 * @return void
 */
	public function logout() {
		if ($this->Auth->user()) {
			$this->SwissArmy->loadComponent('Cookie');
			$this->Cookie->delete('User');
			$this->Session->destroy();
			$this->Session->setFlash(__('¡Hasta pronto!', true));
		}
		$this->redirect($this->Auth->logout());
	}

/**
 * profile method
 *
 * @param mixed $username
 * @access public
 * @return void
 */
	public function profile($username = null) {
		if ($username && $username != $this->Auth->user($this->Auth->fields['username'])) {
			/* Temp */
			$this->Session->setFlash(__('No implementado', true));
			return $this->_back();
			/* Temp End */
			$id = $this->User->field('id', array($this->Auth->fields['username'] => $username));
		} else {
			$id = $this->Auth->user('id');
		}
		if (!$id) {
			$this->Session->setFlash(__('Usuario no encontrado', true));
			return $this->_back();
		}
		$conditions['User.id'] = $id;
		$this->data = $this->User->find('first', compact('conditions', 'contain'));
		if (!$this->data) {
			$this->Session->setFlash(__('Usuario no encontrado', true));
			return $this->_back();
		}
	}

/**
 * register method
 *
 * @access public
 * @return void
 */
	public function register() {
		$override = false;
		if (Configure::read()) {
			if (!$this->User->find('count')) {
				$message = __('Create a site admin user.', true);
				$this->Session->setFlash($message);
				$override = true;
			}
		}
		if (!$override && !MiCache::setting('Users.allowRegistrations')) {
			$message = __('Registros deshabilitados temporalmente', true);
			$this->Session->setFlash($message);
			$this->redirect('/');
		}
		if ($this->data) {
			if (Configure::read() && !$this->User->find('count')) {
				if (isset($this->User->Group)) {
					$this->data['User']['group_id'] = $this->User->Group->field('id',
						array('name' => 'Admin'));
				} else {
					$this->data['User']['group'] = 'admin';
				}
			}
			list($return, $message) = $this->User->register($this->data);
			if ($message) {
				$this->Session->setFlash($message);
			}
			if ($return) {
				$this->Auth->login($this->User->id);
				return $this->redirect('/');
			}
		}
		$this->set('passwordPolicy', $this->User->passwordPolicy());
	}

/**
 * reset_password method
 *
 * Used to set a new password after requesting a reset via the forgotten password method
 *
 * @param string $token
 * @access public
 * @return void
 */
	public function reset_password($token = null) {
		$this->set('token', $token);
		$loggedInUser = $this->User->id = $this->Auth->user('id');
		if ($loggedInUser) {
			$this->redirect(array('action' => 'change_password'));
		}
		$this->set('fields', $this->User->Behaviors->UserAccount->settings['User']['fields']);
		if (!$this->data) {
			return $this->render('confirm');
		}
		list($return, $message) = $this->User->resetPassword($this->data);
		if ($message) {
			$this->Session->setFlash($message);
		}
		if ($return) {
			$this->Session->write('Auth.redirect', '/'); // Prevent auth from sending you back here
			return $this->redirect(array('action' => 'login'));
		}
		$view = 'confirm';
		if ($this->data) {
			if (empty($this->User->validationErrors[$this->Auth->fields['username']]) &&
				empty($this->User->validationErrors['token'])) {
				$view = 'reset_password';
			}
		}
		$this->render($view);
	}

/**
 * postLogin method
 *
 * Called automatically when a user logs in normally, or by cookie
 *
 * @param array $userData array()
 * @param mixed $mode 'form' or 'cookie'
 * @return void
 * @access public
 */
	public function postLogin($userData = array(), $mode = null) {
		static $run;
		if($run) {
			return;
		}
		$run = true;
		$this->User->id = $id = $this->Auth->user('id');
		$display = $this->User->display();
		/* ... */
	}

/**
 * isAuthorized method
 *
 * Allow logged in users to edit their profile and change their password
 *
 * @return bool
 * @access public
 */
	public function isAuthorized() {
		if (in_array($this->action, array('edit', 'change_password'))) {
			return true;
		}
		return parent::isAuthorized();
	}

/**
 * setSelects method
 *
 * @param bool $restrictToData true
 * @return void
 * @access protected
 */
	protected function _setSelects($restrictToData = true) {
		$sets['groups'] = $this->User->enumValues('group');
		$this->set($sets);
	}
}

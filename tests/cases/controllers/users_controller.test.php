<?php
/* Users Test cases generated on: 2010-09-22 09:09:19 : 1285142359*/
App::import('Controller', 'Users');

class TestUsersController extends UsersController {
	public $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UsersControllerTestCase extends CakeTestCase {
	public $fixtures = array('app.user');

	function startTest() {
		$this->Users = new TestUsersController();
		$this->Users->constructClasses();
	}

	function endTest() {
		unset($this->Users);
		ClassRegistry::flush();
	}

	function testAdminAdd() {

	}

	function testAdminDelete() {

	}

	function testAdminEdit() {

	}

	function testAdminIndex() {

	}

	function testAdminMultiAdd() {

	}

	function testAdminMultiEdit() {

	}

	function testAdminSearch() {

	}

	function testAdminSudo() {

	}

	function testAdminView() {

	}

	function testChangePassword() {

	}

	function testConfirm() {

	}

	function testEdit() {

	}

	function testForgottenPassword() {

	}

	function testIndex() {

	}

	function testLogin() {

	}

	function testLogout() {

	}

	function testProfile() {

	}

	function testRegister() {

	}

	function testResetPassword() {

	}

	function testPostLogin() {

	}
}
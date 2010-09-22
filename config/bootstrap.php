<?php
define('DEFAULT_LANGUAGE', 'eng');
Configure::write('Redirect.model', 'Redirect');

/**
 * If it's not development mode, route asset/media requests to a static subdomain.
 * Skip the favicon and debug kit (which sets cookies) an server everything else from one of 3
 * static subdomains - using the first char of the md5 for the request to determine which subdomain
 * to use.
 *
 * Other examples:
 * Server everything from a single static subdomain:

	if (isProduction()) {
		Configure::write('Asset.hosts', array(
			0 => array(
				'@^(.*)@' =>'http://static.example.com'
			),
		));
	}

 * ignore the favicon and debug kit, delegate to another function entirely:

	if (isProduction()) {
		Configure::write('Asset.hosts', array(
			'whatDomain' => array(
				'@^(.*)@' =>'{1}'
			),
		));
	}
	function whatDomain(&$file) {
		if ( .... ) {
			$file = 'differentname.jpg';
			return 'http://thisone';
		} elseif ( ... ) {
			return 'http://thatone';
		}
		return;
	}
 *
 */
	if (!isDevelopment()) {
		Configure::write('Asset.hosts', array(
			0 => array(
				'@^/?(favicon.ico|debug_kit.*)@' => '',
			),
			'md5' => array(
				'@^[0-5]@' =>'http://static1.skel',
				'@^[6-a]@' =>'http://static2.skel',
				'@^.@' =>'http://static3.skel',
			)
		));
	}

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * isproduction method
 * a stub/example
 *
 * @return boolean
 * @access public
 */
function isproduction() {
	return APP_DIR === 'live';
}

/**
 * isstaging method
 * a stub/example
 *
 * @return boolean
 * @access public
 */
function isstaging() {
	return APP_DIR === 'staging';
}

/**
 * isdevelopment method
 * a stub/example
 *
 * @return boolean
 * @access public
 */
function isdevelopment() {
	return (!isproduction() && !isstaging());
}

/**
 * stepTrace method
 *
 * Intended for cli testing - give yourself an opportunty to read how you got where you are one step
 * at a time
 *
 * @param int $limit 20
 * @return void
 * @access public
 */
function stepTrace($limit = 20) {
	$i = 1;
	do{
		debug(Debugger::trace(array('args' => true, 'depth' => $i, 'start' => $i - 1))); //@ignore
		echo "Press enter\n";
		`read foo`;
		$i++;
	} while ($i < $limit);
}
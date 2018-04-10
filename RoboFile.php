<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * Download robo.phar from http://robo.li/robo.phar and type in the root of the repo: $ php robo.phar
 * Or do: $ composer update, and afterwards you will be able to execute robo like $ php vendor/bin/robo
 *
 * @see  http://robo.li/
 */

require_once 'vendor/autoload.php';

/**
 * Class RoboFile
 *
 * @since  1.6
 */
class RoboFile extends \Robo\Tasks
{
	/**
	 * Method for run specific scenario
	 *
	 * @return  void
	 */
	public function runTravis()
	{
		$this->taskExec("vendor/bin/selenium-server-standalone >> selenium.log 2>&1 &")
			->background()
            ->run();

		$this->_exec('vendor/bin/codecept run tests/acceptance/pl/initPLCest.php --steps')
			->run();
	}
}

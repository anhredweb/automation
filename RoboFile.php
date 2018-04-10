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
		$this->taskServer(8000)
            ->background()
            ->dir('web')
            ->run();

		$this->taskExec('java -jar -Dwebdriver.chrome.driver="chrome_driver/chromedriver" "selenium-server-standalone.jar"')
			->background()
            ->run()
            ->stopOnFail();

		$this->taskCodecept()
			->arg('--steps')
			->arg('--tap')
			->arg('--fail-fast')
			->arg('tests/acceptance/pl/initPLCest.php')
			->run()
			->stopOnFail();
	}
}

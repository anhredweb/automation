<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Class GeneralXpath
 *
 * @since  1.0
 *
 * @link   http://codeception.com/docs/07-AdvancedUsage#PageObjects
 */
class CollateralXpathLibrary
{
	// Include url of current page
	public static $url             = 'https://bpmportal.fecredit.com.vn/prweb/PRWebLDAP2/sOaQ0T-ROx5XbItR6AxpmvzTKOSH1OB3*/!STANDARD';
	
	public static $cdlType         = '//table[@id="ViewTable"]//tr//td[contains(@class, "SearchResultsCategoryStyle")]//a';
	public static $cdl             = '//table[@id="ViewTable"]//tr//td[contains(@class, "SearchResultsCategoryStyle")]//a[@title="Consumer Durable"]//parent::td//following::td[1]//a';

	public static $closeButton      = '//div[contains(@class, "pega-system-message")]//button[@name="pxHAMessage_pyDisplayHarness_37"]';
	
	public static $emailOnTop      = '//a[contains(@title, "tu.vuong@fecredit.com.vn")]';
	
	public static $infomationFrame = '//div[@id="workarea"]//div[contains(@style, "display: block")]//iframe';
	
	public static $information     = '//div[@data-node-id="CaseContainerBottom"]//div[@data-node-id="pyCaseContent"]//ul[contains(@class, "headerTabsList")]//li[@id="Tab2"]//a[@tabtitle="Information"]';

	public static $closeApplication = '//div[@node_name="ActionAreaRight"]//div[contains(@class, "item-7")]//a';

	public static $collateralDescription = '//div[@data-node-id="CaseInformation"]//div[@data-node-id="AssetDetails"]/fieldset/div/div[contains(@class, "item-4")]//div[contains(@class, "dataValueRead")]/span';

	public static $applicationId = '(//div[@data-node-id="pyCaseContainer"]//div[@data-node-id="pyCaseSummary"]//div[contains(@class, "content-item content-layout item-3")]//div[contains(@class, "content-item content-field item-3")]//div[contains(@class, "content-inner ")]//div[contains(@class, "dataValueRead")]//span)[1]';
}

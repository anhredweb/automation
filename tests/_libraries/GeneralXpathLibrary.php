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
class GeneralXpathLibrary
{
	// Include url of current page
    public static $url = 'https://pega-uat.fecredit.com.vn';

    // Original Scoring Stage
	public static $caseId        = '//div[@data-node-id="pyCaseHeader"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]//span[contains(@class, "case_title")]';
	
	public static $nationnalId   = '//div[@data-node-id="pyCaseSummary"]//div[contains(@class, "content-item content-layout item-3")]//div[contains(@class, "content-item content-field item-4")]//div[contains(@class, "content-inner ")]//div[contains(@class, "dataValueRead")]//span';
	
	public static $applicationId = '//div[@data-node-id="pyCaseSummary"]//div[contains(@class, "content-item content-layout item-3")]//div[contains(@class, "content-item content-field item-3")]//div[contains(@class, "content-inner ")]//div[contains(@class, "dataValueRead")]//span';
	
	public static $totalScore    = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-2")]//label[contains(@for, "Score")]//following-sibling::div[contains(@class, "dataValueRead")]//span';
	
	public static $scoreGroup    = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-3")]//label[contains(@for, "GroupCode")]//following-sibling::div[contains(@class, "dataValueRead")]//span';
	
	public static $randomNumber  = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-4")]//label[contains(@for, "RandNumber")]//following-sibling::div[contains(@class, "dataValueRead")]//span';

    // Scoring
	public static $genderAndAgeScore     = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(1)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $maritalStatusScore    = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(2)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $installmentScore      = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(3)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $posRegionScore        = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(4)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $ccPerformanceScore    = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(5)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $fbOwnerScore          = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(6)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $downpaymentRatioScore = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(7)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $posPerformanceScore   = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(8)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $ownerDpdEverScore     = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(9)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $refDpdScore           = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(10)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $ownerRejectedScore    = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(11)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $ownerDisbursedScore   = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(12)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $assetBrandScore       = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(13)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $effectiveRateScore    = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(14)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
	
	public static $documentRequiredScore = '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(15)"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';

    // Login page
	public static $username    = '//input[@name="UserIdentifier"]';
	
	public static $password    = '//input[@name="Password"]';
	
	public static $loginButton = '//button[@name="pyActivity=Code-Security.Login"]';

    // Init app Stage
	public static $launchButton      = '//a[@data-test-id="20140927131516034349915"]';

	public static $FECaseManager     = '//div[contains(@class, "menu-panel-wrapper")]//li[1]//a';

	public static $createButton      = '//a[@data-test-id="2015081110205103203915"]';

	public static $CDLApplication    = '//a[contains(@data-click, "FECredit-Base-Loan-Work-Loan-CD")]';

	public static $iframeEnviroment  = '//div[@id="moduleGroupDiv"]//div[contains(@style, "display: block")]//div[contains(@id, "PegaWebGadget")]//iframe';
	
	public static $dealerCode        = '//input[@name="$PpyWorkPage$pDealer$pDealerCode"]';

	public static $rowDealerCode     = '//tr[contains(@id, "$PD_Dealer$ppxResults")]';
	
	public static $posCode           = '//input[@name="$PpyWorkPage$pPOS$pPOSCode"]';

	public static $rowPosCode        = '//tr[contains(@id, "$PpyWorkPage$pFilteredPOS")]';
	
	public static $productGroup      = '//select[@name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeGroupID"]';
	
	public static $productScheme     = '//input[@name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeDescription"]';

	public static $rowProductScheme  = '//tr[contains(@id, "$PpyWorkPage$pFilteredSchemes")]';
	
	public static $demoDataInitApp   = '//button[@name="NewProcess_pyWorkPage_13"]';
	
	public static $createDataInitApp = '//button[@name="NewProcessButtons_pyWorkPage_1"]';

	// Short application Stage - Step 1
	public static $lastname           = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pLastName"]';
	
	public static $firstname          = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pFirstName"]';
	
	public static $gender             = '//select[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pGender"]';
	
	public static $nationalId         = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pNationalId"]';
	
	public static $dateOfIssue        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pNationalIdDateIssue"]//following-sibling::img';

	public static $todayLink          = '//a[@id="todayLink"]';
	
	public static $dateOfBirth        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pDateOfBirth"]';
	
	public static $fbNumber           = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pFBNumber"]';
	
	public static $phone              = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pPhoneNumber"]';
	
	public static $hometown           = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pHometown"]';

	public static $rowHometown  = '//tr[contains(@id, "$PD_ClassificationSchemeList$pSchemes$gHometownProv$ppxResults")]';
	
	public static $demoDataShortApp   = '//button[@data-click-id="[["showMenu",[{"dataSource":"DemoDataShortApp", "isNavTypeCustom":"false", "className":"FECredit-Base-Loan-Work-Loan-CD","menuAlign":"left","format":"menu-format-standard" , "loadBehavior":"ondisplay", "ellipsisAfter":"999","usingPage":"pyWorkPage", "useNewMenu":"true", "isMobile":"false", "navPageName":"pyNavigation1508927626414"},":event"]]]"]';
	
	public static $demoDataG1ShortApp = '//button[@id="pyNavigation1509437842034"]';
	
	public static $submitShortApp     = '//button[@data-test-id="20151224215849068133296"]';

	// Step 2 
	public static $demoDataDocument = '//button[@name="ScanApp_pyWorkPage_75"]';
	
	public static $submitDocument   = '//button[@name="ScanApp_pyWorkPage_85"]';

	// Full data entry Stage
	public static $goodType                 = '//input[@id="GoodTypeDesc"]';
	
	public static $brand                    = '//input[@id="BrandDesc"]';
	
	public static $assetMake                = '//input[@id="AssetMakeDesc"]';
	
	public static $assetModel               = '//input[@id="AssetModelDesc"]';
	
	public static $goodPrice                = '//input[@id="GoodPrice"]';
	
	public static $collateralDescription    = '//input[@id="CollateralDescription"]';
	
	public static $downPayment              = '//input[@id="DownPayment"]';
	
	public static $tenor                    = '//input[@id="RequestedTenure"]';	
	
	public static $isFbOwner                = '//input[@id="IsFBOwner"]';
	
	public static $maritalStatus            = '//input[@id="MaritalStatusId"]';
	
	public static $education                = '//input[@id="EducationId"]';
	
	public static $personalIncome           = '//input[@id="NetAmount1"]';
	
	public static $familyIncome             = '//input[@id="NetAmount2"]';
	
	public static $phoneReference1          = '//input[@id="CommunicationString1"]';
	
	public static $phoneReference2          = '//input[@id="CommunicationString2"]';
	
	public static $demoDataFullDataEntry    = '//button[@data-click-id="[["showMenu",[{"dataSource":"DemoDataFullApp", "isNavTypeCustom":"false", "className":"FECredit-Base-Loan-Work-Loan-CD","menuAlign":"left","format":"menu-format-standard" , "loadBehavior":"ondisplay", "ellipsisAfter":"999","usingPage":"pyWorkPage", "useNewMenu":"true", "isMobile":"false", "navPageName":"pyNavigation1499600025595"},":event"]]]"]';
	
	public static $demoDataG11FullDataEntry = '//button[@id="pyNavigation1509440340595"]';
	
	public static $submitFullDataEntry      = '//button[@data-click-id="[["setUserStart",["FINISHASSIGNMENT"]],["doFormSubmit",["pyActivity=FinishAssignment",":this","",":event"]]]"]';

	// Data check Stage
	public static $dataCheck          = '//ul[@id="gridNode0"]//li[@id="$PCaseContentsPage$ppxResults$l1"]//a';
	
	public static $verificationResult = '//select[@name="$PpyWorkPage$pLoanApp$pDCH$pResult"]';
	
	public static $demoDataDataCheck  = '//button[@name="DataCheck_pyWorkPage_"]';

	public static $cicResult  = '//select[@id="CICCheckResult"]';

	public static $submitDataCheck  = '//button[@name="DataCheck_pyWorkPage_44"]';

	public static $okDataCheck  = '//button[@data-test-id="2016053114385707303299"]';

	// public static $okDataCheck  = '//button[@data-click-id="[["setUserStart",["FINISHASSIGNMENT"]],["doFormSubmit",["pyActivity=FinishAssignment",":this","",":event"]]]"]';
	
	// Log off
	public static $emailOnTop  = '//button[@data-test-id="2016053114385707303299"]';	

    // Message
	public static $errorMessage      = '//div[@data-node-id="DisplayErrors"]';
	
	public static $errorMessageTable = '//table[@id="ERRORTABLE"]';
	
	public static $popupMessage      = 'Please correct flagged fields before submitting the form!';

	public static $errorDiv = '//div[contains(@class, "inputErrorDiv")]//span[contains(@class, "inputError")]';

    // Error message text 
    public static $errorMessageText = '//div[@data-node-id="DisplayErrors"]//div[@id="EXPAND-INNERDIV"]//span';

    //button
    public static $newButton = "New";

    public static $saveButton = "Save";

    public static $unpublishButton = "Unpublish";

    public static $publishButton = "Publish";

    public static $saveCloseButton = "Save & Close";

    public static $deleteButton = "Delete";

    public static $editButton = "Edit";

    public static $saveNewButton = "Save & New";

    public static $cancelButton = "Cancel";

    public static $checkInButton = "Check-in";

    /**
     * Function to get the Path for Template ID
     *
     * @param   String $templateIDName Name of the Template
     *
     * @return string
     */
    public function categoryTemplateID($templateIDName)
    {
        $path = "//div[@id='s2id_filter_category_template']/div/ul/li[contains(text(), '" . $templateIDName . "')]";

        return $path;
    }

    /**
     * Function to get the Path for Template
     *
     * @param   String $templateName Name of the Template
     *
     * @return string
     */
    public function categoryTemplate($templateName)
    {
        $path = "//div[@id='filter_category_template']/div/ul/li[contains(text(), '" . $templateName . "')]";

        return $path;
    }

    public function xPathAccessory($accessoryName)
    {
        $path = ['xpath' => "//span[contains(text(), '" . $accessoryName . "')]"];
        return $path;
    }
}

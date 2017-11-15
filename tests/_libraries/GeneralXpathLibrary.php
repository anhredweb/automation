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

	public static $applicationStatus  = '//div[@data-node-id="pyCaseHeader"]//div[contains(@class, "content-item content-field item-3")]//div[contains(@class, "dataValueRead")]//img//following-sibling::span';
	
	public static $nationalIdScoring  = '//div[@section_index="4"]//div[@data-node-id="pyCaseSummary"]//div[contains(@class, "content-item content-layout item-3")]//div[contains(@class, "content-item content-field item-4")]//div[contains(@class, "content-inner ")]//div[contains(@class, "dataValueRead")]//span';
	
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
	public static $addItemButton         = '//div[@data-node-id="AddDelete"]//a[@data-test-id="2016121614080304138535"]';

	// Good Fields
	
	public static $assetType             = '//select[@name="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l2$pAssetType"]';
	
	public static $rowGoodData           = '//div[@gpropindex="PFinancialGoods1"]//div[@id="gridBody_right"]//table[@id="bodyTbl_right"]//tr[@id="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l1"]';	
	
	public static $collateral            = '//select[@name="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l2$pCollateral"]';
	
	public static $goodType              = '//input[@id="GoodsTypeDesc"]';

	public static $rowGoodType           = '//tr[contains(@id, "$PD_ClSubSchemeLevel1")]';
	
	public static $brand                 = '//input[@id="BrandDesc"]';

	public static $rowBrand              = '//tr[contains(@id, "$PD_ClSubSchemeLevel1")]';
	
	public static $assetMake             = '//input[@id="AssetMakeDesc"]';

	public static $rowAssetMake          = '//tr[contains(@id, "$PD_ClSubSchemeLevel2")]';
	
	public static $assetModel            = '//input[@id="AssetModelDesc"]';

	public static $rowAssetModel         = '//tr[contains(@id, "$PD_ClSubSchemeLevel2")]';
	
	public static $goodPrice             = '//input[@id="GoodsPrice"]';
	
	public static $collateralDescription = '//input[@id="CollateralDescription"]';

	public static $saveGoodButton        = '//button[@id="RowDetailsButtonSubmit"]';

	// Loan Fields
	
	public static $downPayment           = '//input[@id="DownPayment"]';
	
	public static $tenor                 = '//input[@id="RequestedTenure"]';

	// Customer Fields	
	
	public static $isFbOwner             = '//input[@id="IsFBOwner"]';

	public static $title                 = '//select[@id="Title"]';
	
	public static $maritalStatus         = '//select[@id="MartialStatusId"]';

	public static $socialStatus          = '//select[@id="SocialStatusId"]';
	
	public static $education             = '//select[@id="EducationId"]';

	// Family Fields

	public static $spouseLastname        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pSpouse$pPerson$pContact$pLastName"]';

	public static $spouseFirstname        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pSpouse$pPerson$pContact$pFirstName"]';

	public static $spouseGender        = '//select[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pSpouse$pPerson$pContact$pGender"]';

	public static $spouseNationalId        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pSpouse$pPerson$pContact$pNationalId"]';

	public static $spouseRelationPeriod        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pSpouse$pRelation$pRelationPeriod"]';

	public static $fbOwnerLastname        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pFBOwner$pPerson$pContact$pLastName"]';

	public static $fbOwnerFirstname        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pFBOwner$pPerson$pContact$pFirstName"]';

	public static $fbOwnerRelationType        = '//select[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pFBOwner$pRelation$pRelationType"]';

	public static $fbOwnerNationalId        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pFBOwner$pPerson$pContact$pNationalId"]';

	// Income Fields

	public static $rowMainIncome         = '//div[@aria-labelledby="Tab8"]//div[@data-node-id="Income"]//table[@id="gridLayoutTable"]//tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pIncome$pIncome$l1"]//td[3]';	
	
	public static $personalIncome        = '//input[@id="NetAmount1"]';

	public static $rowFamilyIncome       = '//div[@aria-labelledby="Tab8"]//div[@data-node-id="Income"]//table[@id="gridLayoutTable"]//tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pIncome$pIncome$l2"]//td[3]';
	
	public static $familyIncome          = '//input[@id="NetAmount2"]';

	// Reference Fields

	public static $rowPhoneReference1    = '//div[@aria-labelledby="Tab9"]//div[@data-node-id="OtherReferensedPersons"]//table[@id="gridLayoutTable"]//tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pOtherReferensedPersons$l1"]';

	public static $rowMobile1    = '// tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pOtherReferensedPersons$l1$pPerson$pPhones$l1"]//td[3]';
	
	public static $phoneReference1       = '//input[@id="CommunicationString1"]';

	public static $rowPhoneReference2    = '//div[@aria-labelledby="Tab9"]//div[@data-node-id="OtherReferensedPersons"]//table[@id="gridLayoutTable"]//tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pOtherReferensedPersons$l2"]';

	public static $rowMobile2    = '// tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pOtherReferensedPersons$l2$pPerson$pPhones$l1"]//td[3]';
	
	public static $phoneReference2       = '//input[@id="CommunicationString2"]';
	
	public static $demoDataFullDataEntry    = '//button[@data-test-id="2015100605430907997129"]';
	
	public static $demoDataG11FullDataEntry = '//a[contains(@data-click, "DemoDataEnterFullAppG11")]';
	
	public static $submitFullDataEntry      = '//button[contains(@data-click, "doFormSubmit")]';

	// Data check Stage
	public static $dataCheck          = '//ul[@id="gridNode0"]//li[@id="$PCaseContentsPage$ppxResults$l1"]//li[2]//a[1]';
	
	public static $verificationResult = '//select[@name="$PpyWorkPage$pLoanApp$pDCH$pResult"]';
	
	public static $demoDataDataCheck  = '//button[@name="DataCheck_pyWorkPage_"]';
	
	public static $cicResult          = '//select[@id="CICCheckResult"]';
	
	public static $submitDataCheck    = '//button[@name="DataCheck_pyWorkPage_44"]';
	
	public static $okDataCheck        = '//button[@data-test-id="2016053114385707303299"]';
	
	public static $documentsTab       = '//div[@data-node-id="CaseContainerDE"]//div[@data-node-id="DataCheckWithDocs"]//div[contains(@id, "PEGA_TABBED")]//ul[contains(@class, "Standard_TopList")]//li[@id="Tab2"]//a[@tabtitle="2. Documents"]';
	
	public static $cicTab             = '//div[@data-node-id="CaseContainerDE"]//div[@data-node-id="DataCheckWithDocs"]//div[contains(@id, "PEGA_TABBED")]//ul[contains(@class, "Standard_TopList")]//li[@id="Tab3"]//a[@tabtitle="3. CIC"]';
	
	// Log off
	public static $emailOnTop = '//a[@data-test-id="20140927131516034856137"]';
	
	public static $logOff     = '//ul[contains(@style, "display: block;")]//a[contains(@data-click, "logOff")]';

    // Message
	public static $errorMessage      = '//div[@data-node-id="DisplayErrors"]';
	
	public static $errorMessageTable = '//table[@id="ERRORTABLE"]';
	
	public static $popupMessage      = 'Please correct flagged fields before submitting the form!';
	
	public static $errorDiv          = '//div[contains(@class, "inputErrorDiv")]//span[contains(@class, "inputError")]';

    // Error message text 
    public static $errorMessageText = '//div[@data-node-id="DisplayErrors"]//div[@id="EXPAND-INNERDIV"]//span';

    // Access by LOS2
	public static $emailOnTop2         = '//a[contains(@title, "nhut.le@fecredit.com.vn")]';
	
	public static $roleMenu            = '//a[@data-test-id="20140927131516034248306"]';
	
	public static $switchApplication   = '//ul[contains(@style, "display: block;")]//li[contains(@data-childnodesid, "$ppyElements$l1$ppyElements$l6")]/a';

	public static $loan                = '//ul[contains(@style, "display: block;")]//li[contains(@data-childnodesid, "$ppyElements$l1$ppyElements$l6")]//ul[contains(@id, "$ppyElements$l1$ppyElements$l6")]//li[1]';
	
	public static $riskAdmin           = '//ul[contains(@style, "display: block;")]//li[contains(@data-childnodesid, "$ppyElements$l1$ppyElements$l6")]//ul[contains(@id, "$ppyElements$l1$ppyElements$l6")]//li[2]';
	
	public static $switchWorkPool      = '//ul[contains(@style, "display: block;")]//li[contains(@data-childnodesid, "$ppyElements$l1$ppyElements$l4")]/a';
	
	public static $defaultWorkPool     = '//ul[contains(@style, "display: block;")]//li[contains(@data-childnodesid, "$ppyElements$l1$ppyElements$l4")]//ul[contains(@id, "$ppyElements$l1$ppyElements$l4")]//li[1]';
	
	public static $searchBox           = '//input[@name="$PpyDisplayHarness$ppyTemplateInputBox"]';
	
	public static $searchButton        = '//button[@name="searchMenuButton"]';
	
	public static $decisionMakingFrame = '//div[@id="workarea"]//div[contains(@style, "display: block")]//iframe';
	
	public static $decisionMaking      = '//div[@data-node-id="CaseContainerBottom"]//div[@data-node-id="pyCaseContent"]//ul[contains(@class, "headerTabsList")]//li[@id="Tab7"]//a[@tabtitle="Decision Making"]';

	public static $closeButton         = '//ul[@role="tablist"]//li[2]//span[@id="close"]';

    /**
     * Function to get tab
     *
     * @param  string $tabId Tab ID
     *
     * @return xpath
     */
    public function getTabId($tabId)
    {
        return '//div[@data-node-id="FullAppContainer"]//div[contains(@id, "PEGA_TABBED")]//ul[@role="tablist"]//li[@id="Tab' . $tabId . '"]//a';
    }
}

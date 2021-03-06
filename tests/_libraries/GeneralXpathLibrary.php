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

    // Session message
    public static $sessionMessage = '//div[contains(@class, "pega-system-message")]//button[contains(@data-click, "refresh")]';

    // Original Scoring Stage
	public static $caseId            = '//div[@data-node-id="pyCaseHeader"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]//span[contains(@class, "case_title")]';
	
	public static $applicationStatus = '//div[@data-node-id="pyCaseHeader"]//div[contains(@class, "content-item content-field item-3")]//div[contains(@class, "dataValueRead")]//img//following-sibling::span';

	public static $currentStage      = '//div[@data-node-id="pyCaseHeader"]//div[contains(@data-ui-meta, "CurrentStage")]//div[contains(@data-ui-meta, "CurrentStageLabel")]//span';
	
	public static $nationalIdScoring = '(//div[@data-node-id="pyCaseSummary"]//div[contains(@data-ui-meta, ".LoanApp.PersonalInfo.Person.Contact.NationalId")])[1]//span';
	
	public static $nationalId2Scoring = '(//div[@data-node-id="Identification"]//div[contains(@data-ui-meta, ".NationalID02")])[1]//span';

	public static $applicationId     = '(//div[@data-node-id="pyCaseSummary"]//div[contains(@data-ui-meta, ".LoanApp.ApplicationID")])[1]//span';

	public static $productSchemeName = '(//div[@data-node-id="pyCaseSummary"]//div[contains(@data-ui-meta, ".LoanApp.SelectedScheme.SchemeDescription")])[1]//span';
	
	public static $totalScore        = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-2")]//label[contains(@for, "Score")]//following-sibling::div[contains(@class, "dataValueRead")]//span';
	
	public static $scoreGroup        = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-3")]//label[contains(@for, "GroupCode")]//following-sibling::div[contains(@class, "dataValueRead")]//span';
	
	public static $randomNumber      = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-4")]//label[contains(@for, "RandNumber")]//following-sibling::div[contains(@class, "dataValueRead")]//span';
	
	public static $productScoreGroup = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-4")]//label[contains(@for, "ProductScoreGroup")]//following-sibling::div[contains(@class, "dataValueRead")]//span';

	public static $subSegment        = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-5")]//label[contains(@for, "SubSegment")]//following-sibling::div[contains(@class, "dataValueRead")]//span';

	public static $leadBlack         = '(//div[@data-node-id="ScoringInfo"]//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[contains(@class, "content-item content-field item-6")]//label[contains(@for, "LeadBlack")]//following-sibling::div[contains(@class, "dataValueRead")]//span';

    // Login page
	public static $username    = '//input[@name="UserIdentifier"]';
	
	public static $password    = '//input[@name="Password"]';
	
	public static $loginButton = '//button[@name="pyActivity=Code-Security.Login"]';

    // Init app Stage
    public static $closeSession      = '//button[@name="pxHAMessage_pyDisplayHarness_37"]';

	public static $launchButton      = '//a[@data-test-id="20140927131516034349915"]';

	public static $FECaseManager     = '//div[contains(@class, "menu-panel-wrapper")]//li[1]//a';

	public static $createButton      = '//a[@data-test-id="2015081110205103203915"]';

	public static $CDLApplication    = '//ul/li//a[contains(@data-click, "FECredit-Base-Loan-Work-Loan-CD")]';

	public static $TWApplication     = '//ul/li//a[contains(@data-click, "FECredit-Base-Loan-Work-Loan-TW")]';

	public static $PLApplication     = '(//ul/li//a[contains(@data-click, "FECredit-Base-Loan-Work-Loan")])[1]';

	public static $iframeEnviroment  = '//div[@id="moduleGroupDiv"]//div[contains(@style, "display: block")]//div[contains(@id, "PegaWebGadget")]//iframe';
	
	public static $dealerCode        = '//input[@name="$PpyWorkPage$pDealer$pDealerCode"]';

	public static $dealerCodeJS      = 'input[name="$PpyWorkPage$pDealer$pDealerCode"]';

	public static $rowDealerCode     = '//tr[contains(@id, "$PD_Dealer$ppxResults")]';
	
	public static $posCode           = '//input[@name="$PpyWorkPage$pPOS$pPOSCode"]';

	public static $posCodeJS         = 'input[name="$PpyWorkPage$pPOS$pPOSCode"]';

	public static $rowPosCode        = '//tr[contains(@id, "$PpyWorkPage$pFilteredPOS")]';

	public static $productPLGroup    = '//input[@name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeGroupIDDescription"]';

	public static $productPLGroupJS  = 'input[name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeGroupIDDescription"]';

	public static $rowProductPLGroup = '//tr[contains(@id, "$PpyWorkPage$pFilteredProductGroups")]';

	public static $DSACode           = '//input[@name="$PpyWorkPage$pDSA$pDSAId"]';

	public static $DSACodeJS         = 'input[name="$PpyWorkPage$pDSA$pDSAId"]';

	public static $rowDSACode        = '//tr[contains(@id, "$PD_DSAListActiveById")]';
	
	public static $productGroup      = '//select[@name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeGroupID"]';
	
	public static $productScheme     = '//input[@name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeDescription"]';

	public static $productSchemeJS   = 'input[name="$PpyWorkPage$pLoanApp$pSelectedScheme$pSchemeDescription"]';

	public static $rowProductScheme  = '//tr[contains(@id, "$PpyWorkPage$pFilteredSchemes")]';
	
	public static $demoDataCDLInitApp  = '//button[@name="NewProcess_pyWorkPage_15"]';

	public static $demoDataTWInitApp   = '//button[@name="NewProcess_pyWorkPage_74"]';
	
	public static $createDataInitApp   = '//button[@name="NewProcessButtons_pyWorkPage_1"]';

	public static $createPLDataInitApp = '//button[@name="NewProcess_pyWorkPage_19"]';

	// Short application Stage - Step 1
	public static $lastname           = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pLastName"]';
	
	public static $firstname          = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pFirstName"]';
	
	public static $gender             = '//select[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pGender"]';
	
	public static $nationalId         = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pNationalId"]';

	public static $nationalId2        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pNationalID02"]';
	
	public static $dateOfIssue        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pNationalIdDateIssue"]//following-sibling::img';

	public static $todayLink          = '//a[@id="todayLink"]';
	
	public static $dateOfBirth        = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pDateOfBirth"]';
	
	public static $fbNumber           = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pFBNumber"]';
	
	public static $phone              = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pPhoneNumber"]';

	public static $hometownJS         = 'input[name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pHometown"]';
	
	public static $hometown           = '//input[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pContact$pHometown"]';

	public static $rowHometown  = '//tr[contains(@id, "$PD_ClassificationSchemeList$pSchemes$gHometownProv$ppxResults")]';

	public static $disbursementChannel = '//select[@name="$PpyWorkPage$pLoanApp$pLoanDetail$pDisbursementChannel"]';

	public static $demoDataShortApp   = '//button[contains(@data-click, "DemoDataShortApp")]';
	
	public static $demoDataG1ShortApp = '//ul[contains(@style, "display: block;")]/li[contains(@class, "menu-item")]/a[contains(@data-click, "DemoDataEnterShortAppG1G6")]';
	
	public static $submitShortApp     = '//button[@data-test-id="20151224215849068133296"]';

	// Step 2 
	public static $demoPLDataDocument = '//button[@name="ScanApp_pyWorkPage_38"]';
	
	public static $submitPLDocument   = '//button[@data-test-id="20170203134515013545390"]';
	
	public static $demoDataDocument   = '//button[@name="ScanApp_pyWorkPage_75"]';
	
	public static $submitDocument     = '//button[@name="ScanApp_pyWorkPage_85"]';

	// Full data entry Stage
	public static $addItemButton         = '//div[@data-node-id="AddDelete"]//a[@data-test-id="2016121614080304138535"]';

	// Good Fields
	public static $assetType             = '//select[@name="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l2$pAssetType"]';
	
	public static $rowGoodData           = '//div[@gpropindex="PFinancialGoods1"]//div[@id="gridBody_right"]//table[@id="bodyTbl_right"]//tr[@id="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l1"]';	
	
	public static $collateral            = '//select[@name="$PpyWorkPage$pLoanApp$pFinancialGoods$pFinancialGoods$l2$pCollateral"]';
	
	public static $goodType              = '//input[@id="GoodsTypeDesc"]';

	public static $rowGoodType           = '//tr[contains(@id, "$PD_ClSubSchemeLevel1")]';

	public static $brandJS               = 'input#BrandDesc';
	
	public static $brand                 = '//input[@id="BrandDesc"]';

	public static $rowBrand              = '//tr[contains(@id, "$PD_ClSubSchemeLevel1")]';

	public static $assetMakeJS           = 'input#AssetMakeDesc';
	
	public static $assetMake             = '//input[@id="AssetMakeDesc"]';

	public static $rowAssetMake          = '//tr[contains(@id, "$PD_ClSubSchemeLevel2")]';

	public static $assetModelJS          = 'input#AssetModelDesc';
	
	public static $assetModel            = '//input[@id="AssetModelDesc"]';

	public static $rowAssetModel         = '//tr[contains(@id, "$PD_ClSubSchemeLevel2")]';
	
	public static $goodPrice             = '//input[@id="GoodsPrice"]';
	
	public static $collateralDescription = '//input[@id="CollateralDescription"]';

	public static $saveGoodButton        = '//button[@id="RowDetailsButtonSubmit"]';

	// Loan Fields
	public static $requestedAmount       = '//input[@id="RequestedAmount"]';

	public static $requestedAmountJS     = 'input#RequestedAmount';

	public static $loanPurpose           = 'input#LoanPurposeIdDesc';

	public static $rowLoanPurpose        = '//tr[contains(@id, "$PD_ClassificationSchemeList$pSchemes$gLoanPurpose$ppxResults$")]';

	public static $downPayment           = 'input#DownPayment';
	
	public static $tenor                 = 'input#RequestedTenure';

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

	// Contacts Fields
	public static $currentAddressRow = '//div[@aria-labelledby="Tab6"]//div[@data-node-id="ContactInformation"]//td[@data-attribute-name="Address"]/div/p[@name="$PpyWorkPage$pLoanApp$pPersonalInfo$pPerson$pAddresses$l1$pFullAddressStr"]';
	
	public static $province          = '//input[@id="CityDesc"]';
	
	public static $provinceJS        = 'input#CityDesc';
	
	public static $rowProvince       = '//tr[contains(@id, "$PD_ClassificationSchemeList$pSchemes$gProvince$ppxResults")]';
	
	public static $district          = '//input[@id="DistrictDesc"]';
	
	public static $districtJS        = 'input#DistrictDesc';
	
	public static $rowDistrict       = '//tr[contains(@id, "$PD_DistrictList")][1]';
	
	public static $ward              = '//input[@id="WardDesc"]';
	
	public static $wardJS            = 'input#WardDesc';
	
	public static $rowWard           = '//tr[contains(@id, "$PD_WardList")][1]';

	// Work Fields
	public static $compTaxCodeJS  = 'input#EM_EMPLOYERTAXID';
	
	public static $compTaxCode    = '//input[@id="EM_EMPLOYERTAXID"]';
	
	public static $rowCompTaxCode = '//tr[contains(@id, "$PD_CIF_Employer_")]';
	
	public static $yearCurrJob    = 'input#YearsInPresentJob';
	
	public static $yearPrevJob    = 'input#YearsInPreviousJob';
	
	public static $monthCurrJob   = '//select[@id="MonthsInPresentJob"]';
	
	public static $monthPrevJob   = '//select[@id="MonthsInPreviousJob"]';

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

	// Pending Rework
	public static $reworkDemoData = '//button[@name="ScanAppRework_pyWorkPage_37"]';
	
	public static $reworkSubmit   = '//button[@name="ScanAppRework_pyWorkPage_42"] ';

	// Data check Stage
	public static $dataCheck               = '//ul[@id="gridNode0"]//li[@id="$PCaseContentsPage$ppxResults$l1"]//li[2]//a[1]';
	
	public static $verificationResult      = '//select[@name="$PpyWorkPage$pLoanApp$pDCH$pResult"]';
	
	public static $demoDataDataCheck       = '//button[@name="DataCheck_pyWorkPage_"]';
	
	public static $cicResult               = '//select[@id="CICCheckResult"]';

	public static $cicReason               = '//select[@id="CICCheckResultReason"]';
	
	public static $pcbResult               = '//select[@id="PCBCheckResult"]';
	
	public static $submitDataCheck         = '//button[@name="DataCheck_pyWorkPage_44"]';
	
	public static $okDataCheck             = '//button[@data-test-id="2016053114385707303299"]';
	
	public static $documentsTab            = '//div[@data-node-id="CaseContainerDE"]//div[@data-node-id="DataCheckWithDocs"]//div[contains(@id, "PEGA_TABBED")]//ul[contains(@class, "Standard_TopList")]//li[@id="Tab2"]//a[@tabtitle="2. Documents"]';
	
	public static $cicTab                  = '//div[@data-node-id="CaseContainerDE"]//div[@data-node-id="DataCheckWithDocs"]//div[contains(@id, "PEGA_TABBED")]//ul[contains(@class, "Standard_TopList")]//li[@id="Tab3"]//a[@tabtitle="3. CIC"]';
	
	public static $pcbTab                  = '//div[@data-node-id="CaseContainerDE"]//div[@data-node-id="DataCheckWithDocs"]//div[contains(@id, "PEGA_TABBED")]//ul[contains(@class, "Standard_TopList")]//li[@id="Tab4"]//a[@tabtitle="PCB"]';
	
	public static $cicAddItem              = '//table[contains(@data-ui-meta, "FREEFORM")]//td[contains(@data-ui-meta, "FECredit-FW-LoanFW-Data-CIC")]//a[@data-test-id="2016012116004104207418"]';
	
	public static $cicNationalId           = 'input#NationalID';
	
	public static $cicComment              = '//textarea[@id="Comment"]';
	
	public static $cicSaveButton           = '//table[contains(@class, "buttonMainTable")]//td//button[@name="RowDetailsSubmitButton"]';
	
	public static $numberOfRelationshipCIC = '//select[@id="NumberOfRelationshipFromCIC"]';
	
	public static $numberOfRelationshipPCB = '//select[@id="NumberOfRelationshipFromPCB"]';

	//Phone verification Stage
	public static $phoneVerification    = '//ul[@id="gridNode0"]//li[@id="$PCaseContentsPage$ppxResults$l1"]//li[2]//a[1]';
	
	public static $callResult           = '//select[@id="CallResult1"]';
	
	public static $phoneIncomeField     = '//div[@id="INNERDIV-SubSectionPHVContactDetailsBBB"]//div[@data-node-id="EditLoanApp"]//div[contains(@data-ui-meta, "IncomeForPHV")]//h3/i';
	
	public static $phoneMainIncome      = '//div[contains(@style, "display: block")]//table[@grid_ref_page="pyWorkPage.LoanApp.PersonalInfo.Income"]//tr[@id="$PpyWorkPage$pLoanApp$pPersonalInfo$pIncome$pIncome$l3"]//td[3]';
	
	public static $phoneMainIncomeInput = '//input[@id="NetAmount3"]';
	
	public static $phoneResult          = '//select[@id="Result"]';
	
	public static $phoneReason          = '//select[@id="PHVReason"]';
	
	public static $phoneSubReason       = '//select[@id="PHVSubreason"]';

	public static $phoneSubmit          = '//button[@data-test-id="20151124234842093917839"]';
	
	// Log off
	public static $emailOnTop = '//a[@data-test-id="20140927131516034856137"]';
	
	public static $logOff     = '//ul[contains(@style, "display: block;")]//a[contains(@data-click, "logOff")]';

    // Message
	public static $errorMessage      = '(//div[contains(@data-ui-meta, "Container")]//div[@data-node-id="DisplayErrors"]//div[@id="EXPAND-PLUSMINUS"])[1]';
	
	public static $errorMessageTable = '//table[@id="ERRORTABLE"]';
	
	public static $popupMessage      = 'Please correct flagged fields before submitting the form!';
	
	public static $errorDiv          = '//div[@id="errorDiv"]//div[@id="error"]';

    // Error message text 
	public static $errorMessageText = '//div[@data-node-id="DisplayErrors"]//div[@id="EXPAND-INNERDIV"]//span';

    // Access by LOS2
	public static $emailOnTop2         = '//a[contains(@title, "tu.vuong@fecredit.com.vn")]';
	
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

	public static $information         = '//div[@data-node-id="CaseContainerBottom"]//div[@data-node-id="pyCaseContent"]//ul[contains(@class, "headerTabsList")]//li[@id="Tab2"]//a[@tabtitle="Information"]';

	public static $customer            = '//div[@data-node-id="CaseContainerBottom"]//div[@data-node-id="pyCaseContent"]//ul[contains(@class, "headerTabsList")]//li[@id="Tab3"]//a[@tabtitle="Customer"]';

	public static $closeButton         = '//ul[@role="tablist"]//li[2]//span[@id="close"]';

	public static $loanCloseButton     = '//div[@node_name="ActionAreaRight"]//div[contains(@class, "item-7")]//a';

    /**
     * Function to get tab in Full Data Entry Stage
     *
     * @param  int $tabId Tab ID
     *
     * @return string
     */
    public static function getTabId($tabId)
    {
        return '//div[@data-node-id="FullAppContainer"]//div[contains(@id, "PEGA_TABBED")]//ul[@role="tablist"]//li[@id="Tab' . $tabId . '"]//a';
    }

    /**
     * Function to get tab in Phone Verification Stage
     *
     * @param  int $tabId Tab ID
     *
     * @return string
     */
    public static function getPhoneTabId($tabId)
    {
        return '//div[@tabgroupid="TGPHVContactDetailsA"]/ul//li[@id="Tab' . $tabId . '"]';
    }

    /**
     * Function to get score
     *
     * @param  int $scoreRow Score row number
     *
     * @return string
     */
    public static function getScore($scoreRow)
    {
        return '(//div[@swp=".pyDescription,.StrategyResult.Result"])[3]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(3).ScResult"]//div[@base_ref=".ScResult(' . $scoreRow . ')"]//div[contains(@class, "content-item content-field item-2")]//div[contains(@class, "dataValueRead")]/span';
    }

    /**
     * Function to get pre-scoring type
     *
     * @param  int $number  Number of pre-scoring
     *
     * @return string
     */
    public static function getPreScoringType($number)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[contains(@class, "item-1")]//div[contains(@class, "item-1")]//div[contains(@class, "dataValueRead")]//span)[1]';
    }

    /**
     * Function to get pre-scoring
     *
     * @param  int $number  Number of pre-scoring
     *
     * @return string
     */
    public static function getTransactionDate($number)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[contains(@class, "item-1")]//div[contains(@class, "item-3")]//div[contains(@class, "dataValueRead")]//span)[1]';
    }

    /**
     * Function to get pre-scoring
     *
     * @param  int $number  Number of pre-scoring
     *
     * @return string
     */
    public static function getProcessedUser($number)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[contains(@class, "item-1")]//div[contains(@class, "item-5")]//div[contains(@class, "dataValueRead")]//span)[1]';
    }

    /**
     * Function to get pre-scoring
     *
     * @param  int $number  Number of pre-scoring
     * @param  int $row     Policy row number
     *
     * @return string
     */
    public static function getPrescoringResult($number, $row)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[contains(@class, "item-2")]//div[contains(@class, "item-' . $row . '")]//div[contains(@class, "dataValueRead")]//span)[1]';
    }

    /**
     * Function to get pre-scoring
     *
     * @param  int $number  Number of pre-scoring
     * @param  int $row     Policy row number
     *
     * @return string
     */
    public static function getPolicyPrescoring($number, $row)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(' . $number . ').ScResult"]//div[@base_ref=".ScResult(' . $row . ')"]//div[contains(@class, "header-content")]/span[contains(@class, "header-title")][1])[1]';
    }

    /**
     * Function to get score result
     *
     * @param  int $number  Number of pre-scoring
     * @param  int $row     Policy row number
     *
     * @return string
     */
    public static function getPolicyScoreResult($number, $row)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(' . $number . ').ScResult"]//div[@base_ref=".ScResult(' . $row. ')"]//div[contains(@class, "layout-content-stacked")]//div[contains(@class, "content-layout item-1")]//div[contains(@class, "item-2")]//div[contains(@class, "dataValueRead")]/span)[1]';
    }

    /**
     * Function to get score
     *
     * @param  int $number  Number of pre-scoring
     * @param  int $row     Policy row number
     *
     * @return string
     */
    public static function getPolicySCAction($number, $row)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(' . $number . ').ScResult"]//div[@base_ref=".ScResult(' . $row . ')"]//div[contains(@class, "layout-content-stacked")]//div[contains(@class, "content-layout item-1")]//div[contains(@class, "item-3")]//div[contains(@class, "dataValueRead")]/span)[1]';
    }

    /**
     * Function to get score
     *
     * @param  int $number  Number of pre-scoring
     * @param  int $row     Policy row number
     *
     * @return string
     */
    public static function getPolicySCResultInfo($number, $row)
    {
        return '(//div[contains(@base_ref, ".LoanApp.ScoringHistory(' . $number . ')")]//div[@data-repeat-source="pyWorkPage.LoanApp.ScoringHistory(' . $number . ').ScResult"]//div[@base_ref=".ScResult(' . $row . ')"]//div[contains(@class, "layout-content-stacked")]//div[contains(@class, "content-layout item-2")]//div[contains(@class, "item-1")]//div[contains(@class, "dataValueRead")]/span)[1]';
    }
}

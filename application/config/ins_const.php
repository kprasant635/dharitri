<?php  

defined('SLIJE_ANNOTATION') OR define('SLIJE_ANNOTATION', 'SLIJE');
defined('SLIJE_ID') OR define('SLIJE_ID', 45);
define('ENABLE_BUTTON_CO_FIRST_PROC_SUBMIT_INSTITUTE', 1);
define('ENABLE_BUTTON_LM_FIRST_PROC_SUBMIT_INSTITUTE', 1);
define('ENABLE_BUTTON_CHANGE_ENCROACHER_INSTITUTE', 1);
define('ENABLE_AREA_BUTTON_INSTITUTE', CLOSE);
define('ENABLE_DAG_ELIGIBLE_BUTTON_INSTITUTE', OPEN);
define('ENABLE_DAG_CHANGE_BUTTON_INSTITUTE', OPEN); // Open=1; Close=0
define('ENABLE_DAG_ELIGIBLE_BUTTON_LM_REVERT_INSTITUTE',OPEN);
define('KHAS_MAX_HOMESTEAD_INSTITUTE', 1000);           // in bigha
define('HOMESTEAD_INS', 1);
define('LB_NATURE_OF_RESERVATION_INS', json_encode([
    ['CODE' => 1, 'NAME' => 'VGR'],
    ['CODE' => 2, 'NAME' => 'PGR'],
    ['CODE' => 3, 'NAME' => 'ROAD-SIDE-RESERVE'],
    ['CODE' => 4, 'NAME' => 'RIVER-SIDE-RESERVE'],
    ['CODE' => 7, 'NAME' => 'GOVT-KHAS-LAND'],
    ['CODE' => 8, 'NAME' => 'GOVT-CEILING-LAND'],
    ['CODE' => 6, 'NAME' => 'NONE'],
    ['CODE' => 9, 'NAME' => 'BHOODAAN-GRAMDAAN'],
    ['CODE' => 10, 'NAME' => 'AAN AAN RESERVED'],  
    ['CODE' => 11, 'NAME' => 'PATTA LAND'],  
    ['CODE' => 12, 'NAME' => 'TEA PERIODIC PATTA'],  
]));
define('NJS_TAGLINE','Non individual juridical entities');
define('ENABLE_BUTTON_CO_TO_DC_KHAS_INSTITUTE', 1);
define('MEETING_PROPOSAL_SDLAC_NOTICE_HOLD_INSTITUTE',1);
define('ENABLE_BUTTON_SEND_TO_SDLAC_INSTITUTE',1);


define('MEETING_PROPOSAL_SDLAC_NOTICE_DATE_INSTITUTE', '2026-01-10 23:59:59');
define('MEETING_PROPOSAL_SDLAC_NOTICE_DATE_INPUT_INSTITUTE', '2026-01-11 00:00:00');
define('MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW_INSTITUTE', '10th January 2026');

define('SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON_INSTITUTE',1);
define('MB3_DC_FINAL_PROCESS_LIVE',1);
define('MINUTES_VIEW_BY_DC_STATUS_INS',1);
define('MB3_DIGITAL_SIGN_LIVE',0);
define('HOLD_CASES_FORWARD_TO_DEPT_BY_DC_INSTITUTE', '2026-01-11 23:59:55');

define('STATE_PURPOSE',
    array(
        array("id"=>"agriculture","category_name" => "Agriculture"),
        array("id"=>"horticulture","category_name" => "Horticulture"),
        array("id"=>"animalhusbandry","category_name" => "Animal Husbandry"),
        array("id"=>"textile","category_name" => "Textile"),
        array("id"=>"pwd","category_name" => "PWD"),
        array("id"=>"tourism","category_name" => "Tourism"),
        array("id"=>"tnd","category_name" => "T&Development"),
        array("id"=>"finance","category_name" => "Finance"),
        array("id"=>"health","category_name" => "Healthcare"),
        array("id"=>"education","category_name" => "Educational"),
        array("id"=>"tradecommerce","category_name" => "Trade or Commerce"),
        array("id"=>"other","category_name" => "Others"),
    )
);

define('CENTRAL_PURPOSE',
    array(
        array("id"=>"agriculture","category_name" => "Agriculture"),
        array("id"=>"horticulture","category_name" => "Horticulture"),
        array("id"=>"animalhusbandry","category_name" => "Animal Husbandry"),
        array("id"=>"textile","category_name" => "Textile"),
        array("id"=>"pwd","category_name" => "PWD"),
        array("id"=>"tourism","category_name" => "Tourism"),
        array("id"=>"tnd","category_name" => "T&Development"),
        array("id"=>"finance","category_name" => "Finance"),
        array("id"=>"health","category_name" => "Healthcare"),
        array("id"=>"education","category_name" => "Educational"),
        array("id"=>"tradecommerce","category_name" => "Trade or Commerce"),
        array("id"=>"other","category_name" => "Others"),
    )
);

define('NON_GOVT_PURPOSE',
    array(
        array("id"=>"education","category_name" => "Educational"),
        array("id"=>"socioculture","category_name" => "Socio Culture"),
        array("id"=>"religious","category_name" => "Religious"),
    )
);

define('OTHER_LAND_PURPOSE',
    array(
        array("id" => "Irrigation", "category_name" => "Irrigation"),
        array("id" => "Veterinary", "category_name" => "Veterinary"),
        array("id" => "sericulture", "category_name" => "Sericulture"),
        array("id" => "electricity", "category_name" => "Electricity"),
        array("id" => "handloom", "category_name" => "Handloom"),
        array("id" => "soilconservation", "category_name" => "Soil Conservation"),
        array("id" => "aidc", "category_name" => "AIDC"),
        array("id" => "Ruraldevelopment", "category_name" => "Panchayat and Rural Development"),
        array("id" => "agriculture", "category_name" => "Agriculture"),
        array("id" => "co-operation", "category_name" => "Co-operation"),
        array("id" => "post", "category_name" => "Post"),
        array("id" => "homeandpolitical", "category_name" => "Home and Political"),
        array("id" => "forest", "category_name" => "Forest & Environment"),
        array("id" => "LocalGovernance", "category_name" => "Local Governance"),
        array("id" => "PHE", "category_name" => "Public Health & Engineering"),
        array("id" => "SocialWelfare", "category_name" => "Social Welfare"),
        array("id" => "NFRailway", "category_name" => "NF Railway"),
        array("id" => "FireEmergencyService", "category_name" => "Fire and Emergency Service"),
        array("id" => "Administration", "category_name" => "Administration"),
        array("id" => "health", "category_name" => "Health"),
        array("id" => "education", "category_name" => "Education"),
        array("id" => "horticulture","category_name" => "Horticulture"),
        array("id" => "animalhusbandry","category_name" => "Animal Husbandry"),
        array("id" => "textile","category_name" => "Textile"),
        array("id" => "pwd","category_name" => "PWD"),
        array("id" => "tourism","category_name" => "Tourism"),
        array("id" => "tnd","category_name" => "T&Development"),
        array("id" => "finance","category_name" => "Finance"),
        array("id" => "tradecommerce","category_name" => "Trade or Commerce"),
        array("id" => "religious","category_name" => "Religious"),
        array("id" => "socioculture","category_name" => "Socio-Culture"),
        array("id" => "pwdr","category_name" => "PWD Roads"),
        array("id" => "pwdb","category_name" => "PWD Buildings"),
        array("id" => "transport","category_name" => "Transport"),
        array("id" => "Housingandurbanaffairs","category_name" => "Housing and Urban Affairs"),
        array("id" => "womenandchilddevelopment","category_name" => "Women and Child Development"),
    )
);



define('DEPARTMENT',array('Administrative Reforms and Training','Agriculture and Horticulture','Animal Husbandry and Veterinary','Border Protection and Development','Cooperation','Cultural Affairs','Elementary Education','Environment and Forest','Excise','Finance','Fisheries','Food, Civil Supplies and Consumer Affairs','General Administration','Guwahati Developement','Handloom,Textile and Sericulture','Health and Family Welfare','Higher Education','Hill Areas','Home and Political','Horticulture','Housing & Urban Affairs','Industries and Commerce','Information Technology','Information, Public Relations, Printing & Stationery','Irrigation','Judicial','Labour & Welfare','Legislative','Mines and Minerals','Minority Welfare','Panchayat and Rural Development','Parliamentary Affairs','Pension and Public Grievances','Personnel','Power (Electricity)','Public Enterprises','Public Health Engineering','Public Works (Roads)','Public Works Buildings & NH','Revenue & Disaster Management','Science and Technology','Skill, Employment & Entrepreneurship','Telecommunications','Social Welfare','Soil Conservation','Sports and Youth Welfare','Tea Tribes & Adivasi Welfare','Tourism','Transformation and Development','Transport','Water Resources','Welfare of Plain Tribes and Backward Classes','Women and Child Development'));


define('MINISTRY',array('AYUSH','Agriculture and Farmers Welfare','Chemicals and Fertilizers','Civil Aviation','Coal','Commerce and Industry','Communications','Consumer Affairs','Food and Public Distribution','Cooperation','Corporate Affairs','Culture','Defence','Development of North Eastern Region','Earth Sciences','Education','Electronics and Information Technology','Environment, Forest and Climate Change','External Affairs','Finance','Fisheries, Animal Husbandry and Dairying','Food Processing Industries','Health and Family Welfare','Heavy Industries','Home Affairs','Housing and Urban Affairs','Information and Broadcasting','Jal Shakti','Labour and Employment','Law and Justice','Micro, Small & Medium Enterprises','Mines','Minority Affairs','New and Renewable Energy','Panchayati Raj','Parliamentary Affairs','Personnel, Public Grievances and Pensions','Petroleum and Natural Gas','Planning','Ports, Shipping and Waterways','Power','Railways','Road Transport and Highways','Rural Development','Science and Technology','Skill Development and Entrepreneurship','Social Justice and Empowerment','Statistics and Programme Implementation','Steel','Textiles','Tourism','Tribal Affairs','Women and Child Development','Youth Affairs and Sports','Women and Child Development'));

define('PREMIUM_FOR_SETTLEMENT',1);
define('INS_RURAL_MAX', '100B 0k 0L');
define('DC_ADC_SDO_PRO_BUTTON_INS', OPEN); 

define('SUB_CAT',
    array(
        array("id"=>"1","category_name" => "মন্দিৰ"),
        array("id"=>"2","category_name" => "নামঘৰ"),
        array("id"=>"3","category_name" => "গোসাঁইঘৰ"),
        array("id"=>"4","category_name" => "শ্ৰীমন্ত শঙ্কৰদেৱ সংঘ"),
        array("id"=>"5","category_name" => "দামোদৰদেৱ সেৱা সমিতি"),
        array("id"=>"6","category_name" => "থান"),
        array("id"=>"7","category_name" => "মছিদ"),
        array("id"=>"8","category_name" => "ক্ৰীড়া সংঘ"),
        array("id"=>"9","category_name" => "খেলপথাৰ"),
        array("id"=>"10","category_name" => "সমিতি"),
        array("id"=>"11","category_name" => "শ্বহীদ ভৱন"),
        array("id"=>"12","category_name" => "অঙ্গনবাদী কেন্দ্ৰ"),
        array("id"=>"13","category_name" => "স্ব-সহায়ক গোট"),
        array("id"=>"14","category_name" => "কমিউনিটি হল"),
        array("id"=>"15","category_name" => "কবৰস্থান"),
        array("id"=>"16","category_name" => "শ্মশান"),
        array("id"=>"50","category_name" => "Others"),
    )
);

define('JURIDICAL_ENABLE_AREA_BUTTON', 1);
define('FORWARD_PROPOSAL_TO_SDLAC_MEM_BUTTON_INSTITUTE',1);
define('MAX_APPLIED_ADDITIONAL_AREA_INS',10000);
define('LAND_TYPES',
    array(
        array("id"=>"1","name" => "Agriculture"),
        array("id"=>"2","name" => "Residential"),
        array("id"=>"4","name" => "Trade"),
        array("id"=>"3","name" => "Industrial"),
        array("id"=>"10","name" => "Institution"),
        array("id"=>"6","name" => "Plantation")
    )
);
define('URBAN_AREA_NJS', array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22));
define('RURAL_AREA_NJS', array(7, 8, 9, 10, 18, 19, 20, 21, 22));
define('PAYMENT_NOTICE_BUTTON_INS',1);
define('MB_3_SERVICE_CODE_ALLOW_API_CALL', [25,27,30,39,40,42,43,44,45]);
define('INS_DIST_CODE_ALLOW_FOR_PROPOSAL_MAKING',array('07'));
define('MB3_DIGITAL_SIGN_DRAFT_MODE',1);

define('RECLASSIFICATION_USE_FOR_ALLOTMENT',0);
define('CHITHA_UPDATE_INSTITUTION',1);

define('PULL_BACK_CASES_FORM_DC_END_PENDING_WITH_DEPT_LIVE_INS', OPEN);
define('GEO_TAG_VERIFICATION_FOR_REJECT', 0); // 1 with verify / 0 without




define('RECALCULATE_PREMIUM_FOR_APPROVE_CASES',0);
define('EDIT_AREA_INS_BEFORE_PAYMENT_NOTICE',0);

define('ALLOTMENT_AND_SETTLEMENT', 1);



define('SERVICE_MAP_ALLOMENT_AND_SETTLEMENT', json_encode([
    ['id'=> '8', 'name' => "State Government", 'color' => "green"],
    ['id'=> '9', 'name' => "State Government Undertaking", 'color' => "blue"],
    ['id'=> '10','name' => "Central Government", 'color' => "red"],
    ['id'=> '11','name' => "Central Government Undertaking", 'color' => "orange"],
    ['id'=> '12','name' => "Non Government", 'color' => "purple"],
]));


define('NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT',1);
define('NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE','2025-09-11');


?>

-- Dumping database structure for PHPDemo
DROP DATABASE IF EXISTS `PHPDemo`;
CREATE DATABASE IF NOT EXISTS `PHPDemo` DEFAULT CHARACTER SET = 'utf8mb4' COLLATE utf8mb4_unicode_ci ;
USE `PHPDemo`;

-- Dumping structure for table CountryCodes
CREATE TABLE IF NOT EXISTS `CountryCodes`  (
  `iCountryID` int(11) NOT NULL,
  `vcCountryCode` char(2) NOT NULL DEFAULT '',
  `vcCountryName` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`iCountryID`)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table CountryCodes: 242 rows
INSERT INTO `CountryCodes` (`iCountryID`, `vcCountryCode`, `vcCountryName`) VALUES
	(1, 'AF', 'AFGHANISTAN'),
	(2, 'AX', 'ÅLAND ISLANDS'),
	(3, 'AL', 'ALBANIA'),
	(4, 'DZ', 'ALGERIA'),
	(5, 'AS', 'AMERICAN SAMOA'),
	(6, 'AD', 'ANDORRA'),
	(7, 'AO', 'ANGOLA'),
	(8, 'AI', 'ANGUILLA'),
	(9, 'AQ', 'ANTARCTICA'),
	(10, 'AG', 'ANTIGUA AND BARBUDA'),
	(11, 'AR', 'ARGENTINA'),
	(12, 'AM', 'ARMENIA'),
	(13, 'AW', 'ARUBA'),
	(14, 'AU', 'AUSTRALIA'),
	(15, 'AT', 'AUSTRIA'),
	(16, 'AZ', 'AZERBAIJAN'),
	(17, 'BS', 'BAHAMAS'),
	(18, 'BH', 'BAHRAIN'),
	(19, 'BD', 'BANGLADESH'),
	(20, 'BB', 'BARBADOS'),
	(21, 'BY', 'BELARUS'),
	(22, 'BE', 'BELGIUM'),
	(23, 'BZ', 'BELIZE'),
	(24, 'BJ', 'BENIN'),
	(25, 'BM', 'BERMUDA'),
	(26, 'BT', 'BHUTAN'),
	(27, 'BO', 'BOLIVIA'),
	(28, 'BA', 'BOSNIA AND HERZEGOVINA'),
	(29, 'BW', 'BOTSWANA'),
	(30, 'BV', 'BOUVET ISLAND'),
	(31, 'BR', 'BRAZIL'),
	(32, 'IO', 'BRITISH INDIAN OCEAN TERRITORY'),
	(33, 'BN', 'BRUNEI DARUSSALAM'),
	(34, 'BG', 'BULGARIA'),
	(35, 'BF', 'BURKINA FASO'),
	(36, 'BI', 'BURUNDI'),
	(37, 'KH', 'CAMBODIA'),
	(38, 'CM', 'CAMEROON'),
	(39, 'CA', 'CANADA'),
	(40, 'CV', 'CAPE VERDE'),
	(41, 'KY', 'CAYMAN ISLANDS'),
	(42, 'CF', 'CENTRAL AFRICAN REPUBLIC'),
	(43, 'TD', 'CHAD'),
	(44, 'CL', 'CHILE'),
	(45, 'CN', 'CHINA'),
	(46, 'CX', 'CHRISTMAS ISLAND'),
	(47, 'CC', 'COCOS (KEELING) ISLANDS'),
	(48, 'CO', 'COLOMBIA'),
	(49, 'KM', 'COMOROS'),
	(50, 'CG', 'CONGO'),
	(51, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE (Zaire)'),
	(52, 'CK', 'COOK ISLANDS'),
	(53, 'CR', 'COSTA RICA'),
	(54, 'CI', 'CÔTE D\'IVOIRE'),
	(55, 'HR', 'CROATIA'),
	(56, 'CU', 'CUBA'),
	(57, 'CY', 'CYPRUS'),
	(58, 'CZ', 'CZECH REPUBLIC'),
	(59, 'DK', 'DENMARK'),
	(60, 'DJ', 'DJIBOUTI'),
	(61, 'DM', 'DOMINICA'),
	(62, 'DO', 'DOMINICAN REPUBLIC'),
	(63, 'EC', 'ECUADOR'),
	(64, 'EG', 'EGYPT'),
	(65, 'SV', 'EL SALVADOR'),
	(66, 'GQ', 'EQUATORIAL GUINEA'),
	(67, 'ER', 'ERITREA'),
	(68, 'EE', 'ESTONIA'),
	(69, 'ET', 'ETHIOPIA'),
	(70, 'FK', 'FALKLAND ISLANDS (MALVINAS)'),
	(71, 'FO', 'FAROE ISLANDS'),
	(72, 'FJ', 'FIJI'),
	(73, 'FI', 'FINLAND'),
	(74, 'FR', 'FRANCE'),
	(75, 'GF', 'FRENCH GUIANA'),
	(76, 'PF', 'FRENCH POLYNESIA'),
	(77, 'TF', 'FRENCH SOUTHERN TERRITORIES'),
	(78, 'GA', 'GABON'),
	(79, 'GM', 'GAMBIA'),
	(80, 'GE', 'GEORGIA'),
	(81, 'DE', 'GERMANY'),
	(82, 'GH', 'GHANA'),
	(83, 'GI', 'GIBRALTAR'),
	(84, 'GR', 'GREECE'),
	(85, 'GL', 'GREENLAND'),
	(86, 'GD', 'GRENADA'),
	(87, 'GP', 'GUADELOUPE'),
	(88, 'GU', 'GUAM'),
	(89, 'GT', 'GUATEMALA'),
	(90, 'GN', 'GUINEA'),
	(91, 'GW', 'GUINEA-BISSAU'),
	(92, 'GY', 'GUYANA'),
	(93, 'HT', 'HAITI'),
	(94, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS'),
	(95, 'VA', 'HOLY SEE (VATICAN CITY STATE)'),
	(96, 'HN', 'HONDURAS'),
	(97, 'HK', 'HONG KONG'),
	(98, 'HU', 'HUNGARY'),
	(99, 'IS', 'ICELAND'),
	(100, 'IN', 'INDIA'),
	(101, 'ID', 'INDONESIA'),
	(102, 'IR', 'IRAN, ISLAMIC REPUBLIC OF'),
	(103, 'IQ', 'IRAQ'),
	(104, 'IE', 'IRELAND'),
	(105, 'IL', 'ISRAEL'),
	(106, 'IT', 'ITALY'),
	(107, 'JM', 'JAMAICA'),
	(108, 'JP', 'JAPAN'),
	(109, 'JO', 'JORDAN'),
	(110, 'KZ', 'KAZAKHSTAN'),
	(111, 'KE', 'KENYA'),
	(112, 'KI', 'KIRIBATI'),
	(113, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF'),
	(114, 'KR', 'KOREA, REPUBLIC OF'),
	(115, 'KW', 'KUWAIT'),
	(116, 'KG', 'KYRGYZSTAN'),
	(117, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC'),
	(118, 'LV', 'LATVIA'),
	(119, 'LB', 'LEBANON'),
	(120, 'LS', 'LESOTHO'),
	(121, 'LR', 'LIBERIA'),
	(122, 'LY', 'LIBYAN ARAB JAMAHIRIYA'),
	(123, 'LI', 'LIECHTENSTEIN'),
	(124, 'LT', 'LITHUANIA'),
	(125, 'LU', 'LUXEMBOURG'),
	(126, 'MO', 'MACAO'),
	(127, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF'),
	(128, 'MG', 'MADAGASCAR'),
	(129, 'MW', 'MALAWI'),
	(130, 'MY', 'MALAYSIA'),
	(131, 'MV', 'MALDIVES'),
	(132, 'ML', 'MALI'),
	(133, 'MT', 'MALTA'),
	(134, 'MH', 'MARSHALL ISLANDS'),
	(135, 'MQ', 'MARTINIQUE'),
	(136, 'MR', 'MAURITANIA'),
	(137, 'MU', 'MAURITIUS'),
	(138, 'YT', 'MAYOTTE'),
	(139, 'MX', 'MEXICO'),
	(140, 'FM', 'MICRONESIA, FEDERATED STATES OF'),
	(141, 'MD', 'MOLDOVA, REPUBLIC OF'),
	(142, 'MC', 'MONACO'),
	(143, 'MN', 'MONGOLIA'),
	(144, 'MS', 'MONTSERRAT'),
	(145, 'MA', 'MOROCCO'),
	(146, 'MZ', 'MOZAMBIQUE'),
	(147, 'MM', 'MYANMAR'),
	(148, 'NA', 'NAMIBIA'),
	(149, 'NR', 'NAURU'),
	(150, 'NP', 'NEPAL'),
	(151, 'NL', 'NETHERLANDS'),
	(152, 'AN', 'NETHERLANDS ANTILLES'),
	(153, 'NC', 'NEW CALEDONIA'),
	(154, 'NZ', 'NEW ZEALAND'),
	(155, 'NI', 'NICARAGUA'),
	(156, 'NE', 'NIGER'),
	(157, 'NG', 'NIGERIA'),
	(158, 'NU', 'NIUE'),
	(159, 'NF', 'NORFOLK ISLAND'),
	(160, 'MP', 'NORTHERN MARIANA ISLANDS'),
	(161, 'NO', 'NORWAY'),
	(162, 'OM', 'OMAN'),
	(163, 'PK', 'PAKISTAN'),
	(164, 'PW', 'PALAU'),
	(165, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED'),
	(166, 'PA', 'PANAMA'),
	(167, 'PG', 'PAPUA NEW GUINEA'),
	(168, 'PY', 'PARAGUAY'),
	(169, 'PE', 'PERU'),
	(170, 'PH', 'PHILIPPINES'),
	(171, 'PN', 'PITCAIRN'),
	(172, 'PL', 'POLAND'),
	(173, 'PT', 'PORTUGAL'),
	(174, 'PR', 'PUERTO RICO'),
	(175, 'QA', 'QATAR'),
	(176, 'RE', 'RÉUNION'),
	(177, 'RO', 'ROMANIA'),
	(178, 'RU', 'RUSSIAN FEDERATION'),
	(179, 'RW', 'RWANDA'),
	(180, 'SH', 'SAINT HELENA'),
	(181, 'KN', 'SAINT KITTS AND NEVIS'),
	(182, 'LC', 'SAINT LUCIA'),
	(183, 'PM', 'SAINT PIERRE AND MIQUELON'),
	(184, 'VC', 'SAINT VINCENT AND THE GRENADINES'),
	(185, 'WS', 'SAMOA'),
	(186, 'SM', 'SAN MARINO'),
	(187, 'ST', 'SAO TOME AND PRINCIPE'),
	(188, 'SA', 'SAUDI ARABIA'),
	(189, 'SN', 'SENEGAL'),
	(190, 'CS', 'SERBIA AND MONTENEGRO'),
	(191, 'SC', 'SEYCHELLES'),
	(192, 'SL', 'SIERRA LEONE'),
	(193, 'SG', 'SINGAPORE'),
	(194, 'SK', 'SLOVAKIA'),
	(195, 'SI', 'SLOVENIA'),
	(196, 'SB', 'SOLOMON ISLANDS'),
	(197, 'SO', 'SOMALIA'),
	(198, 'ZA', 'SOUTH AFRICA'),
	(199, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS'),
	(200, 'ES', 'SPAIN'),
	(201, 'LK', 'SRI LANKA'),
	(202, 'SD', 'SUDAN'),
	(203, 'SR', 'SURINAME'),
	(204, 'SJ', 'SVALBARD AND JAN MAYEN'),
	(205, 'SZ', 'SWAZILAND'),
	(206, 'SE', 'SWEDEN'),
	(207, 'CH', 'SWITZERLAND'),
	(208, 'SY', 'SYRIAN ARAB REPUBLIC'),
	(209, 'TW', 'TAIWAN, PROVINCE OF CHINA'),
	(210, 'TJ', 'TAJIKISTAN'),
	(211, 'TZ', 'TANZANIA, UNITED REPUBLIC OF'),
	(212, 'TH', 'THAILAND'),
	(213, 'TL', 'TIMOR-LESTE'),
	(214, 'TG', 'TOGO'),
	(215, 'TK', 'TOKELAU'),
	(216, 'TO', 'TONGA'),
	(217, 'TT', 'TRINIDAD AND TOBAGO'),
	(218, 'TN', 'TUNISIA'),
	(219, 'TR', 'TURKEY'),
	(220, 'TM', 'TURKMENISTAN'),
	(221, 'TC', 'TURKS AND CAICOS ISLANDS'),
	(222, 'TV', 'TUVALU'),
	(223, 'UG', 'UGANDA'),
	(224, 'UA', 'UKRAINE'),
	(225, 'AE', 'UNITED ARAB EMIRATES'),
	(226, 'GB', 'UNITED KINGDOM'),
	(227, 'US', 'UNITED STATES'),
	(228, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS'),
	(229, 'UY', 'URUGUAY'),
	(230, 'UZ', 'UZBEKISTAN'),
	(231, 'VU', 'VANUATU'),
	(232, 'VA', 'Vatican City State (HOLY SEE)'),
	(233, 'VE', 'VENEZUELA'),
	(234, 'VN', 'VIET NAM'),
	(235, 'VG', 'VIRGIN ISLANDS, BRITISH'),
	(236, 'VI', 'VIRGIN ISLANDS, U.S.'),
	(237, 'WF', 'WALLIS AND FUTUNA'),
	(238, 'EH', 'WESTERN SAHARA'),
	(239, 'YE', 'YEMEN'),
	(240, 'CD', 'Zaire (CONGO, THE DEMOCRATIC REPUBLIC OF THE)'),
	(241, 'ZM', 'ZAMBIA'),
	(242, 'ZW', 'ZIMBABWE');

-- Dumping structure for procedure spMovePos
DELIMITER //
CREATE PROCEDURE `spMovePos`(IN MenuID int, IN NewPos tinyint, IN Type varchar(10))
BEGIN
SELECT Max(iMenuOrder)+1 INTO @MaxPos from tblmenutype WHERE vcMenuType = Type;
SELECT iMenuOrder INTO @CurPos from tblmenutype WHERE vcMenuType = Type and iMenuID = MenuID;
UPDATE tblmenutype SET iMenuOrder = @MaxPos WHERE iMenuID = MenuID and vcMenuType = Type;
UPDATE tblmenutype SET iMenuOrder = iMenuOrder - 1 WHERE iMenuOrder > @CurPos and vcMenuType = Type;
UPDATE tblmenutype SET iMenuOrder = iMenuOrder + 1 WHERE iMenuOrder >= NewPos and vcMenuType = Type;
UPDATE tblmenutype SET iMenuOrder = NewPos WHERE iMenuID = MenuID and vcMenuType = Type;
END//
DELIMITER ;

-- Dumping structure for table tblAdminCategories
CREATE TABLE IF NOT EXISTS `tblAdminCategories` (
  `iCatID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `vcCatName` varchar(50) NOT NULL,
  PRIMARY KEY (`iCatID`)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tblAdminCategories: ~5 rows (approximately)
INSERT INTO `tblAdminCategories` (`iCatID`, `vcCatName`) VALUES
	(0, 'Not Admin'),
  (1, 'Misc'),
	(3, 'Site Configuration'),
	(4, 'Users'),
	(5, 'Reference'),
	(7, 'Other');

-- Dumping structure for table tblUsrPrefTypes
CREATE TABLE IF NOT EXISTS `tblUsrPrefTypes` (
  `iID` int(11) NOT NULL AUTO_INCREMENT,
  `iSortOrder` int(11) NOT NULL,
  `vcCode` varchar(15) DEFAULT NULL,
  `vcLabel` varchar(50) DEFAULT NULL,
  `vcType` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`iID`)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table PHPDemo.tblUsrPrefTypes: ~8 rows (approximately)
INSERT INTO `tblUsrPrefTypes` (`iID`, `iSortOrder`, `vcCode`, `vcLabel`, `vcType`) VALUES
	(1, 1, 'EnableSMS', 'Enable Sending SMS Messages', 'Boolean'),
	(2, 2, 'SMS2FA', 'Enable SMS as a MFA', 'Boolean'),
	(3, 3, 'Email2FA', 'Enable email as a MFA', 'Boolean'),
	(4, 4, 'EmlOnLogin', 'Receive email notification on each login', 'Boolean'),
	(5, 5, 'SMSonLogin', 'Receive email notification on each login', 'Boolean'),
	(6, 6, 'SMSonRec', 'Receive SMS when Recovery Code is used', 'Boolean'),
	(7, 7, 'emlOnRec', 'Receive an email when recovery code is used', 'Boolean'),
	(8, 8, 'pronoun', 'Preferred Pronouns', 'text');

-- Dumping structure for table tblUsrPrefValues
CREATE TABLE `tblUsrPrefValues`
(
	`iID` INT(11) NOT NULL AUTO_INCREMENT,
	`iTypeID` INT(11) NOT NULL,
	`iUserID` INT(11) NOT NULL,
	`vcValue` VARCHAR(150) NULL DEFAULT NULL,
	PRIMARY KEY (`iID`) USING BTREE
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Dumping structure for table tblconf
CREATE TABLE IF NOT EXISTS `tblconf` (
  `vcValueName` varchar(50) NOT NULL,
  `vcValue` varchar(50) NOT NULL,
  `vcValueDescr` varchar(150) NOT NULL,
  `vcValueType` varchar(50) NOT NULL
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblconf: ~21 rows (approximately)
INSERT INTO `tblconf` (`vcValueName`, `vcValue`, `vcValueDescr`, `vcValueType`) VALUES
	('SupportEmail', 'support@example.com', 'Support Email', 'text'),
	('ImgHeight', '100', 'Header Image height', 'int'),
	('HeadKeyLen', '95', 'Header Key Length', 'int'),
	('FootKeyLen', '90', 'Footer Key Length', 'int'),
	('Owner', 'Joe The Man', 'Owner', 'text'),
	('EmailFromAddr', 'info@example.com', 'Email From Address', 'text'),
	('EmailFromName', 'Example Admin', 'Email From Name', 'text'),
	('ProfileNotify', 'notify@example.com', 'Profile Notify Email', 'text'),
	('ShowLinkURL', 'False', 'Show URL for Links', 'Boolean'),
	('SiteMessage', '', 'Site Message', 'text'),
	('USOnly',	'False',	'When checked users are limited to US address & phone number',	'Boolean'),
	('HeadAdd', '[dev]', 'Header Name addition', 'text'),
	('Maintenance', 'False', 'Maintenance', 'Boolean'),
	('TimeFormat', 'h:i A', 'Display Time Format [<a href="http://www.php.net/manual/en/function.date.php" target="_blank">help</a>]', 'text'),
	('DateFormat', 'F jS, Y', 'Display Date Format [<a href="http://www.php.net/manual/en/function.date.php" target="_blank">help</a>]', 'text'),
	('minRegLevel', '1', 'Min Registration Priviledge', 'vwPrivLevels'),
	('SecureOpt', 'prevent', 'Sensitive pages', 'tblSecureOption'),
	('NumAdminCol', '5', 'Number of columns of administrative options', 'int'),
	('ShowAdminSub', 'True', 'Show Administrative sub menu', 'Boolean'),
	('UserTimeout', '25', 'User Login Timeout (minutes)', 'int'),
	('NewPWDLen', '16', 'Initial Random Password Length, must be even number', 'int'),
	('ShowPort', 'true', 'Show non standard port in header name', 'Boolean'),
  ('ProductName', 'Siggi\'s PHP Demo', 'Site or Product name', 'text'),
  ('AllowReg', 'true', 'Allow Self Registraton', 'Boolean'),
  ('RecoverCodeLen', '32', 'Length of Recovery Code, must be even, ideally multiple of 4', 'text'),
  ('MinPWDLen', '12', 'Minimum length of any password', 'int'),
	('InitSetup', 'True', 'Initial Setup Mode is active. This should not exists past setup', 'Boolean'),
  ('UserUploadDir', 'upload', 'Upload Directory for normal users', 'text'),
  ('AdminUploadDir', 'lib', 'Upload Directory for admin users', 'text'),
  ('MaxSpamLog', '300', 'Show max spam log entry', 'int'),
  ('SecureURL', 'example.com', 'Hostname used for HTTPS connections', 'text');

-- Dumping structure for table tblContactInfo
CREATE TABLE IF NOT EXISTS `tblContactInfo` (
  `iContactID` int(11) NOT NULL AUTO_INCREMENT,
  `vcType` varchar(25) NOT NULL,
  `iSequence` int(11) NOT NULL,
  `vcLabel` varchar(25) DEFAULT NULL,
  `vcValue` varchar(250) NOT NULL,
  PRIMARY KEY (`iContactID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblContactInfo: ~5 rows (approximately)
INSERT INTO `tblContactInfo` (`iContactID`, `vcType`, `iSequence`, `vcLabel`, `vcValue`) VALUES
	(1, 'Address', 1, '', 'Demo Org'),
	(2, 'Address', 2, NULL, '123434 SE Main Street'),
	(3, 'Address', 3, NULL, 'No Place, Main 12345'),
	(5, 'Email', 1, 'General Info', 'info@example.com'),
	(7, 'Phone', 1, 'Office', '206-555-1212');

-- Dumping structure for table tblContactTypes
CREATE TABLE IF NOT EXISTS `tblContactTypes` (
  `vcTypes` varchar(20) NOT NULL
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblContactTypes: ~3 rows (approximately)
INSERT INTO `tblContactTypes` (`vcTypes`) VALUES
	('Address'),
	('Email'),
	('Phone');

-- Dumping structure for table tblContent
CREATE TABLE IF NOT EXISTS `tblContent` (
  `iRevID` int(11) NOT NULL AUTO_INCREMENT,
  `iMenuID` int(11) NOT NULL,
  `dtTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vcPageHeader` varchar(80) NOT NULL,
  `tPageText` longtext NOT NULL,
  `bLineBreak` tinyint(4) NOT NULL,
  PRIMARY KEY (`iRevID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblContent: ~1 rows (approximately)
INSERT INTO `tblContent` (`iRevID`, `iMenuID`, `dtTimeStamp`, `vcPageHeader`, `tPageText`, `bLineBreak`) VALUES
	(1, 1, '2022-06-19 18:51:18', 'Demo', '<p class=BlueAttn>This is just a demo site, nothing to see here!!!!</p><p class=MainTextCenter>See my Github page at <a href=https://github.com/siggib007/phptest target=_blank>https://github.com/siggib007/phptest</a> for more details about this demo and how to stand up your own</p>', 0);

-- Dumping structure for table tblemailupdate
CREATE TABLE IF NOT EXISTS `tblemailupdate` (
  `iChangeID` int(11) NOT NULL AUTO_INCREMENT,
  `iClientID` int(11) NOT NULL,
  `vcGUID` varchar(60) NOT NULL,
  `vcNewEmail` varchar(50) NOT NULL,
  `vcReqIPAdd` varchar(20) NOT NULL,
  `dtTimeStamp` datetime NOT NULL,
  `dtConfirmed` datetime DEFAULT NULL,
  PRIMARY KEY (`iChangeID`),
  UNIQUE KEY `vcGUID` (`vcGUID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table tblFAQ
CREATE TABLE IF NOT EXISTS `tblFAQ` (
  `iFAQid` int(11) NOT NULL AUTO_INCREMENT,
  `vcQuestion` varchar(150) NOT NULL,
  `tAnswer` text,
  PRIMARY KEY (`iFAQid`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table tblFeedback
CREATE TABLE IF NOT EXISTS `tblFeedback` (
  `iFeedbackID` int(11) NOT NULL AUTO_INCREMENT,
  `vcFeedbackName` varchar(100) NOT NULL,
  `tFeedbackDescr` text NOT NULL,
  `vcImgPath` tinytext NOT NULL,
  PRIMARY KEY (`iFeedbackID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tblFeedback: 1 rows
INSERT INTO `tblFeedback` (`iFeedbackID`, `vcFeedbackName`, `tFeedbackDescr`, `vcImgPath`) VALUES
	(1, 'test feedback', 'Here would be some glowing remarks about this wonderful site.', '');

-- Dumping structure for table tbllinkcategory
CREATE TABLE IF NOT EXISTS `tbllinkcategory` (
  `iCatId` int(11) NOT NULL AUTO_INCREMENT,
  `vcCategory` varchar(100) NOT NULL,
  `iSortNum` int(11) NOT NULL,
  PRIMARY KEY (`iCatId`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tbllinkcategory: ~2 rows (approximately)
INSERT INTO `tbllinkcategory` (`iCatId`, `vcCategory`, `iSortNum`) VALUES
	(1, 'Interesting Stuff', 10),
	(2, 'Maybe interesting stuff', 11);

-- Dumping structure for table tbllinks
CREATE TABLE IF NOT EXISTS `tbllinks` (
  `iLinkID` int(11) NOT NULL AUTO_INCREMENT,
  `iCategory` int(11) NOT NULL,
  `vcLink` varchar(100) NOT NULL,
  `vcName` varchar(150) NOT NULL,
  `vcComment` varchar(500) NOT NULL,
  PRIMARY KEY (`iLinkID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tbllinks: ~1 rows (approximately)
INSERT INTO `tbllinks` (`iLinkID`, `iCategory`, `vcLink`, `vcName`, `vcComment`) VALUES
	(1, 1, 'https://www.facebook.com/StudioBDanceRenton', 'Studio B on Facebook', 'Like us on Facebook & follow all of our activities!');

-- Dumping structure for table tblmenu
CREATE TABLE IF NOT EXISTS `tblmenu` (
  `iMenuID` int(11) NOT NULL AUTO_INCREMENT,
  `vcTitle` varchar(50) NOT NULL,
  `vcLink` varchar(50) NOT NULL,
  `iReadPriv` int(11) NOT NULL DEFAULT '0',
  `iWritePriv` int(11) NOT NULL DEFAULT '300',
  `vcHeader` varchar(250) NOT NULL,
  `bAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `bNewWindow` tinyint(4) NOT NULL DEFAULT '0',
  `bCont` tinyint(4) NOT NULL DEFAULT '0',
  `bdel` tinyint(4) NOT NULL DEFAULT '0',
  `bSecure` tinyint(4) NOT NULL,
  PRIMARY KEY (`iMenuID`),
	UNIQUE KEY `vcLink` (`vcLink`),
  KEY `bAdmin` (`bAdmin`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblmenu: ~61 rows (approximately)
INSERT INTO `tblmenu` (`iMenuID`, `vcTitle`, `vcLink`, `iReadPriv`, `iWritePriv`, `vcHeader`, `bAdmin`, `bNewWindow`, `bCont`, `bdel`, `bSecure`) VALUES
	(1, 'Home', 'index.php', 0, 300, 'Demo Site', 0, 0, 1, 0, 0),
	(3, 'Contact Us', 'contact.php', 0, 300, 'Contact Information', 0, 0, 0, 0, 0),
	(6, 'Login', 'Login.php', 0, 300, 'Login', 0, 0, 0, 0, 1),
	(9, 'Links', 'links.php', 0, 300, 'Links we think are noteworthy', 0, 0, 0, 0, 0),
	(11, 'My Profile', 'myprofile.php', 1, 1, 'My Profile', 0, 0, 0, 0, 1),
	(12, 'Log Out', 'logout.php', 0, 0, 'Log Out', 0, 0, 0, 0, 0),
	(14, 'recover', 'recover.php', 0, 0, 'Password Recovery', 0, 0, 0, 0, 0),
	(15, 'Users Administration', 'users.php', 300, 300, 'User Administration', 4, 0, 0, 0, 1),
	(16, 'Menu Administration', 'MenuAdmin.php', 300, 300, 'Menu Admin', 3, 0, 0, 0, 0),
	(17, 'Configurations', 'conf.php', 300, 300, 'Configurations', 3, 0, 0, 0, 0),
	(18, 'Link Administration', 'LinkAdmin.php', 300, 300, 'Link Administration', 7, 0, 0, 0, 0),
	(19, 'Registration Spam Log', 'spamlog.php', 300, 300, 'Registration Spam Log', 5, 0, 0, 0, 0),
	(20, 'User Email Update log', 'emailchangelog.php', 300, 300, 'User Email Update log', 4, 0, 0, 0, 0),
	(21, 'Administration', 'admin.php', 300, 300, 'Administration', 0, 0, 0, 0, 0),
	(22, 'Link Categories', 'LinkCategory.php', 300, 300, 'Link Categories', 7, 0, 0, 0, 0),
	(23, 'Web site statistics', 'stats.php', 300, 400, 'Statistics', 5, 0, 0, 0, 0),
	(28, 'Page Administration', 'PageAdmin.php', 300, 300, 'Page Administration', 3, 0, 0, 0, 0),
	(30, 'Upload', 'Upload.php', 300, 300, 'Upload', 0, 0, 0, 0, 0),
	(41, 'FAQ Admin', 'FAQAdmin.php', 300, 300, 'FAQ Admin', 5, 0, 0, 0, 0),
	(42, 'FAQ', 'FAQ.php', 300, 300, 'FAQ', 0, 0, 0, 0, 0),
	(43, 'Priviledge Administration', 'PrivAdmin.php', 300, 300, 'Priv Admin', 4, 0, 0, 0, 0),
	(45, 'Our Contact info', 'ContactInfo.php', 300, 300, 'Our Contacts info', 3, 0, 0, 0, 0),
	(47, 'Text Admin', 'PageTextAdmin.php', 300, 300, 'Text Admin', 3, 0, 0, 0, 0),
	(48, 'Registration', 'register.php', 0, 300, 'Registration', 0, 0, 0, 0, 1),
	(55, 'Administrative Categories', 'AdminCategory.php', 300, 300, 'Administrative Categories', 3, 0, 0, 0, 0),
	(64, 'Review Site Admin', 'ReviewLinkAdmin.php', 300, 300, 'Review Site Admin', 7, 0, 0, 0, 0),
	(65, 'Feedback Administration', 'ReviewCommentAdmin.php', 300, 300, 'Feedback Administration', 7, 0, 0, 0, 0),
	(66, 'Reviews', 'Reviews.php', 300, 300, 'Reviews', 0, 0, 0, 0, 0),
	(67, 'File Import', 'FileInv.php', 0, 300, 'File Import', 3, 0, 0, 0, 0),
	(68, 'AKeyless Test', 'AKeylessTest.php', 300, 300, 'AKeyless Test', 0, 0, 0, 0, 0),
	(69, 'AKeylessUIDTest.php', 'AKeylessUIDTest.php', 500, 300, 'AKeylessUIDTest.php', 0, 0, 0, 0, 0),
	(70, 'auth.php', 'auth.php', 500, 300, 'auth.php', 0, 0, 0, 0, 0),
	(71, 'CleanReg.php', 'CleanReg.php', 500, 300, 'CleanReg.php', 0, 0, 0, 0, 0),
	(72, 'cont-incl.php', 'cont-incl.php', 500, 300, 'cont-incl.php', 0, 0, 0, 0, 0),
	(74, 'DBCon.php', 'DBCon.php', 500, 300, 'DBCon.php', 0, 0, 0, 0, 0),
	(75, 'DopplerFetchSecret.php', 'DopplerFetchSecret.php', 500, 300, 'DopplerFetchSecret.php', 0, 0, 0, 0, 0),
	(76, 'EmailTest.php', 'EmailTest.php', 300, 300, 'EmailTest.php', 0, 0, 0, 0, 0),
	(77, 'EmailUpdate.php', 'EmailUpdate.php', 500, 300, 'EmailUpdate.php', 0, 0, 0, 0, 0),
	(78, 'footer.php', 'footer.php', 500, 300, 'footer.php', 0, 0, 0, 0, 0),
	(79, 'functions.php', 'functions.php', 500, 300, 'functions.php', 0, 0, 0, 0, 0),
	(80, 'header.php', 'header.php', 500, 300, 'header.php', 0, 0, 0, 0, 0),
	(81, 'KillSession.php', 'KillSession.php', 500, 300, 'KillSession.php', 0, 0, 0, 0, 0),
	(82, 'LoginIncl.php', 'LoginIncl.php', 500, 300, 'LoginIncl.php', 0, 0, 0, 0, 0),
	(84, 'View PHP Settings', 'phpInfo.php', 300, 300, 'PHP Settings', 3, 1, 0, 0, 0),
	(85, 'phpmailer.php', 'phpmailer.php', 500, 300, 'phpmailer.php', 0, 0, 0, 0, 0),
	(89, 'TablePage.php', 'TablePage.php', 500, 300, 'TablePage.php', 0, 0, 0, 0, 0),
	(90, 'TemplatePage.php', 'TemplatePage.php', 500, 300, 'TemplatePage.php', 0, 0, 0, 0, 0),
	(92, 'UserAdd.php', 'UserAdd.php', 500, 300, 'UserAdd.php', 0, 0, 0, 0, 0),
	(93, 'UserDBVar.php', 'UserDBVar.php', 500, 300, 'UserDBVar.php', 0, 0, 0, 0, 0),
	(94, 'UserRegForm.php', 'UserRegForm.php', 500, 300, 'UserRegForm.php', 0, 0, 0, 0, 0),
	(95, 'UserUpdate.php', 'UserUpdate.php', 500, 300, 'UserUpdate.php', 0, 0, 0, 0, 0),
	(96, 'validate.php', 'validate.php', 500, 300, 'validate.php', 0, 0, 0, 0, 0),
	(97, 'InitialRegister1st.php', 'InitialRegister1st.php', 0, 0, 'InitialRegister1st.php', 0, 0, 0, 0, 0),
	(106,	'MFA Setup',	'MFASetup.php',	1,	1,	'MFA Setup',	0,	0,	0,	0,	1),
	(115,	'User Preference',	'UserPref.php',	1,	1,	'Preferences',	0,	0,	0,	0,	0),
	(118,	'General Info',	'UserProfileGen.php',	1,	1,	'General Info',	0,	0,	0,	0,	1),
	(119,	'Other',	'UserProfileOther.php',	1,	1,	'Other',	0,	0,	0,	0,	0);


-- Dumping structure for table tblmenutype
CREATE TABLE IF NOT EXISTS `tblmenutype` (
  `iTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `iMenuID` int(11) NOT NULL,
  `vcMenuType` varchar(25) NOT NULL,
  `iMenuOrder` int(11) NOT NULL,
  `iSubOfMenu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iTypeID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblmenutype: ~14 rows (approximately)
INSERT INTO `tblmenutype` (`iTypeID`, `iMenuID`, `vcMenuType`, `iMenuOrder`, `iSubOfMenu`) VALUES
	(1, 1, 'head', 1, 0),
	(3, 3, 'head', 3, 0),
	(17, 9, 'head', 11, 0),
	(19, 21, 'head', 15, 0),
	(21, 30, 'head', 6, 0),
	(22, 32, 'head', 12, 0),
	(28, 34, 'head', 4, 0),
	(30, 35, 'head', 5, 0),
	(32, 38, 'head', 7, 0),
	(33, 42, 'head', 10, 0),
	(35, 49, 'head', 8, 0),
	(36, 60, 'head', 9, 0),
	(37, 63, 'head', 16, 0),
	(38, 66, 'head', 13, 0),
	(39, 115,	'head',	21,	11),
	(40, 106,	'head',	19,	11),
	(41, 119,	'head',	23,	11),
	(42, 118,	'head',	18,	11),
	(43, 11,	'head',	17,	0);
-- Dumping structure for table tblPageMeta
CREATE TABLE IF NOT EXISTS `tblPageMeta` (
  `iMetaID` int(11) NOT NULL AUTO_INCREMENT,
  `iMenuID` int(11) DEFAULT NULL,
  `vcMetaName` varchar(100) NOT NULL,
  `vcMetaValue` varchar(500) NOT NULL,
  `vcAttrName` varchar(50) NOT NULL,
  PRIMARY KEY (`iMetaID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblPageMeta: ~10 rows (approximately)
INSERT INTO `tblPageMeta` (`iMetaID`, `iMenuID`, `vcMetaName`, `vcMetaValue`, `vcAttrName`) VALUES
	(1, NULL, 'resource-type', 'document', 'name'),
	(2, NULL, 'revisit-after', '60', 'name'),
	(5, NULL, 'keywords', 'dance lesson dj', 'name'),
	(6, NULL, 'robots', 'ALL', 'name'),
	(7, NULL, 'distribution', 'Global', 'name'),
	(8, NULL, 'rating', 'Safe For Kids', 'name'),
	(9, NULL, 'author', 'Siggi Bjarnason', 'name'),
	(11, NULL, 'reply-to', 'info@example.com', 'http-equiv'),
	(12, NULL, 'Content-Language', 'English', 'http-equiv'),
	(13, NULL, 'content-type', 'text/html charset=UTF-8', 'http-equiv');

-- Dumping structure for table tblPageTable
CREATE TABLE IF NOT EXISTS `tblPageTable` (
  `iTableID` int(11) NOT NULL AUTO_INCREMENT,
  `iMenuID` int(11) NOT NULL,
  `vcPageHeader` varchar(80) NOT NULL,
  `vcColumnList` varchar(800) NOT NULL,
  `vcTableName` varchar(35) NOT NULL,
  `vcFilterStr` varchar(800) DEFAULT NULL,
  `iLimit` int(11) NOT NULL,
  PRIMARY KEY (`iTableID`),
  KEY `iMenuID` (`iMenuID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblPageTable: ~0 rows (approximately)

-- Dumping structure for table tblPageTexts
DROP TABLE if EXISTS tblPageTexts;
CREATE TABLE IF NOT EXISTS `tblPageTexts` (
  `vcTextName` varchar(10) NOT NULL,
  `vcTextDescr` varchar(100) NOT NULL,
  `tPageTexts` text NOT NULL,
  PRIMARY KEY (`vcTextName`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblPageTexts: ~4 rows (approximately)
INSERT INTO `tblPageTexts` (`vcTextName`, `vcTextDescr`, `tPageTexts`) VALUES
('RegFoot', 'Text for Bottom of the registration page', 'I tried to warn you, but did you listen?? Doesn\'t look that way. Oh well you might as well go ahead and submitt now. Just know that this is all on you and you agree to everything and accept responsibility for everything even things that aren\'t your fault or responsibilites.'),
('RegHead', 'Text to display at head of registration page', 'This form is to sign up for an account on this useless demo site. Trust me signing up here will lead to nothing but trouble. If you insist go ahead and fill it out but don\'t say I didn\'t warn you.'),
('SetupReg', 'Text for the initial setup registration page', 'Since this is the first time setup you need to create an adminstrative account'),
('RegForm', 'Registration Form Explanation', 'Only Name and email address is required.<br>\r\nFor the name just put two or more words you would like this system to use as your name.<br>\r\nThe email address you provide will be used to send initial password as well as password resets to.'),
('AuthApp', 'Explanation of a TOTP Auth App', 'Please make sure you have a TOTP capable Authenticator app on your mobile. \r\nGoogle, Microsoft, LastPass, amongst others, all make compatible authenticators. \r\nThey are all called Authenticator in your app store. Authy is my personal favorite TOTP Authenticator. \r\nWhen I talk about app below I\'m referring to this authenticator app '),
('TestWarn', 'Warning on the Email Testing page', 'Doing so might allow hackers to send spam from your configured email address via your email server, severly damaging your email reputation.<br>\r\nOnly run this in a secure environment where you have absolute control over who has access.<br>\r\nFor example run this on your laptop and set your winodws firewall to block all inbound connections.'),
('RecovCode', 'Text that explains Recovery code', 'Please copy the following recovery code and store it in your Password manger, in case something happens to your authenticator app.'),
('RecoverAck', 'Message to display during password recovery', 'If the email you submitted is registered in our system, your password has been reset and sent to that email. \r\nIf you don\'t get an email reach out to our support for further help'),
('Wemail', 'Welcome Email Intro', 'welcome welcome');

-- Dumping structure for table tblPageTypes
CREATE TABLE IF NOT EXISTS `tblPageTypes` (
  `iTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `vcPageType` varchar(50) NOT NULL,
  PRIMARY KEY (`iTypeID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblPageTypes: ~2 rows (approximately)
INSERT INTO `tblPageTypes` (`iTypeID`, `vcPageType`) VALUES
	(1, 'Text Page'),
	(2, 'Table Page');

-- Dumping structure for table tblprivlevels
CREATE TABLE IF NOT EXISTS `tblprivlevels` (
  `iPrivLevel` int(11) NOT NULL,
  `vcPrivName` varchar(25) NOT NULL,
  PRIMARY KEY (`iPrivLevel`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblprivlevels: ~7 rows (approximately)
INSERT INTO `tblprivlevels` (`iPrivLevel`, `vcPrivName`) VALUES
	(0, 'Public'),
	(1, 'Registered Public'),
	(300, 'Administrator'),
	(400, 'Web Master'),
	(500, 'Hidden');

-- Dumping structure for table tblReviewSiteURL
CREATE TABLE IF NOT EXISTS `tblReviewSiteURL` (
  `iSiteID` int(11) NOT NULL AUTO_INCREMENT,
  `vcSiteName` varchar(100) NOT NULL,
  `vcSiteURL` varchar(100) NOT NULL,
  `vcImgPath` tinytext,
  PRIMARY KEY (`iSiteID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblReviewSiteURL: 3 rows
INSERT INTO `tblReviewSiteURL` (`iSiteID`, `vcSiteName`, `vcSiteURL`, `vcImgPath`) VALUES
	(1, 'Speed test', 'https://www.speedtest.net/ ', 'http://www.speedtest.net/images/link120x60.gif'),
	(2, 'google Plus', 'https://plus.google.com/ ', 'http://ssl.gstatic.com/images/icons/gplus-64.png'),
	(3, 'Siggi\'s Testing', 'https://www.supergeek.us ', '');

-- Dumping structure for table tblSecureOption
CREATE TABLE IF NOT EXISTS `tblSecureOption` (
  `iOrder` tinyint(4) NOT NULL,
  `vcType` varchar(50) NOT NULL,
  `vcText` varchar(150) NOT NULL
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblSecureOption: ~3 rows (approximately)
INSERT INTO `tblSecureOption` (`iOrder`, `vcType`, `vcText`) VALUES
	(10, 'force', 'Force Security'),
	(20, 'allow', 'Users choice'),
	(30, 'prevent', 'No security is available');

-- Dumping structure for table tblSpamLog
CREATE TABLE IF NOT EXISTS `tblSpamLog` (
  `iLogID` int(11) NOT NULL AUTO_INCREMENT,
  `dtLogDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vcIPAddress` varchar(20) NOT NULL,
  `vcContent` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`iLogID`),
  KEY `dtLogDateTime` (`dtLogDateTime`,`vcIPAddress`),
  KEY `vcIPAddress` (`vcIPAddress`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping structure for table tblstats
CREATE TABLE IF NOT EXISTS `tblstats` (
  `iStatID` int(11) NOT NULL AUTO_INCREMENT,
  `vcFromClause` varchar(300) NOT NULL,
  `vcWhereClause` varchar(300) DEFAULT NULL,
  `vcGroupByClause` varchar(100) DEFAULT NULL,
  `vcUnique` varchar(30) DEFAULT NULL,
  `vcStatName` varchar(50) NOT NULL,
  `iOrderID` decimal(4,1) NOT NULL,
  `vcModifiedBy` varchar(150) NOT NULL,
  `dtModifiedTime` datetime NOT NULL,
  PRIMARY KEY (`iStatID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table tblstats: ~1 rows (approximately)
INSERT INTO `tblstats` (`iStatID`, `vcFromClause`, `vcWhereClause`, `vcGroupByClause`, `vcUnique`, `vcStatName`, `iOrderID`, `vcModifiedBy`, `dtModifiedTime`) VALUES
	(1, 'tblUsers', '', '', '', 'All Registered users', 1.0, 'Siggi Bjarnason', '2011-01-15 13:51:39');

-- Dumping structure for table tblUsers
CREATE TABLE IF NOT EXISTS `tblUsers` (
  `iUserID` bigint(20) NOT NULL AUTO_INCREMENT,
  `vcName` varchar(50) NOT NULL,
  `vcEmail` varchar(50) NOT NULL,
  `vcCell` varchar(20) DEFAULT NULL,
  `vcAddr1` varchar(50) DEFAULT NULL,
  `vcAddr2` varchar(50) DEFAULT NULL,
  `vcCity` varchar(50) DEFAULT NULL,
  `vcState` varchar(50) DEFAULT NULL,
  `vcZip` varchar(10) DEFAULT NULL,
  `vcCountry` varchar(100) DEFAULT NULL,
  `vcUID` varchar(20) NOT NULL,
  `vcPWD` varchar(260) NOT NULL,
  `dtUpdated` datetime DEFAULT NULL,
  `dMailSent` date DEFAULT NULL,
  `tMailSent` time DEFAULT NULL,
  `dtLastLogin` datetime DEFAULT NULL,
  `iPrivLevel` int(11) NOT NULL DEFAULT '1',
  `vcMFASecret` varchar(50) DEFAULT NULL,
  `vcRecovery` varchar(260) DEFAULT NULL,
  `bChangePWD` BIT DEFAULT NULL,
  PRIMARY KEY (`iUserID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping structure for table US_States
CREATE TABLE IF NOT EXISTS `US_States` (
  `iStateID` int(11) NOT NULL,
  `vcStateAbr` char(2) NOT NULL DEFAULT '',
  `vcStateName` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`iStateID`)
)DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table US_States: 65 rows
INSERT INTO `US_States` (`iStateID`, `vcStateAbr`, `vcStateName`) VALUES
	(1, 'AL', 'ALABAMA'),
	(2, 'AK', 'ALASKA'),
	(3, 'AS', 'AMERICAN SAMOA'),
	(4, 'AZ', 'ARIZONA'),
	(5, 'AR', 'ARKANSAS'),
	(6, 'AE', 'Armed Forces Africa'),
	(7, 'AA', 'Armed Forces Americas (except Canada)'),
	(8, 'AE', 'Armed Forces Canada'),
	(9, 'AE', 'Armed Forces Europe'),
	(10, 'AE', 'Armed Forces Middle East'),
	(11, 'AP', 'Armed Forces Pacific'),
	(12, 'CA', 'CALIFORNIA'),
	(13, 'CO', 'COLORADO'),
	(14, 'CT', 'CONNECTICUT'),
	(15, 'DE', 'DELAWARE'),
	(16, 'DC', 'DISTRICT OF COLUMBIA'),
	(17, 'FM', 'FEDERATED STATES OF MICRONESIA'),
	(18, 'FL', 'FLORIDA'),
	(19, 'GA', 'GEORGIA'),
	(20, 'GU', 'GUAM'),
	(21, 'HI', 'HAWAII'),
	(22, 'ID', 'IDAHO'),
	(23, 'IL', 'ILLINOIS'),
	(24, 'IN', 'INDIANA'),
	(25, 'IA', 'IOWA'),
	(26, 'KS', 'KANSAS'),
	(27, 'KY', 'KENTUCKY'),
	(28, 'LA', 'LOUISIANA'),
	(29, 'ME', 'MAINE'),
	(30, 'MH', 'MARSHALL ISLANDS'),
	(31, 'MD', 'MARYLAND'),
	(32, 'MA', 'MASSACHUSETTS'),
	(33, 'MI', 'MICHIGAN'),
	(34, 'MN', 'MINNESOTA'),
	(35, 'MS', 'MISSISSIPPI'),
	(36, 'MO', 'MISSOURI'),
	(37, 'MT', 'MONTANA'),
	(38, 'NE', 'NEBRASKA'),
	(39, 'NV', 'NEVADA'),
	(40, 'NH', 'NEW HAMPSHIRE'),
	(41, 'NJ', 'NEW JERSEY'),
	(42, 'NM', 'NEW MEXICO'),
	(43, 'NY', 'NEW YORK'),
	(44, 'NC', 'NORTH CAROLINA'),
	(45, 'ND', 'NORTH DAKOTA'),
	(46, 'MP', 'NORTHERN MARIANA ISLANDS'),
	(47, 'OH', 'OHIO'),
	(48, 'OK', 'OKLAHOMA'),
	(49, 'OR', 'OREGON'),
	(50, 'PW', 'PALAU'),
	(51, 'PA', 'PENNSYLVANIA'),
	(52, 'PR', 'PUERTO RICO'),
	(53, 'RI', 'RHODE ISLAND'),
	(54, 'SC', 'SOUTH CAROLINA'),
	(55, 'SD', 'SOUTH DAKOTA'),
	(56, 'TN', 'TENNESSEE'),
	(57, 'TX', 'TEXAS'),
	(58, 'UT', 'UTAH'),
	(59, 'VT', 'VERMONT'),
	(60, 'VI', 'VIRGIN ISLANDS'),
	(61, 'VA', 'VIRGINIA'),
	(62, 'WA', 'WASHINGTON'),
	(63, 'WV', 'WEST VIRGINIA'),
	(64, 'WI', 'WISCONSIN'),
	(65, 'WY', 'WYOMING');

CREATE VIEW `vwAdminCat` AS select `m`.`vcTitle` AS `vcTitle`,`m`.`vcLink` AS `vcLink`,`m`.`bNewWindow` AS `bNewWindow`,`m`.`iReadPriv` AS `iReadPriv`,`c`.`vcCatName` AS `vcCatName`,`c`.`iCatID` AS `iCatID` from (`tblmenu` `m` join `tblAdminCategories` `c` on((`m`.`bAdmin` = `c`.`iCatID`))) order by `c`.`vcCatName`,`m`.`vcTitle`;
CREATE VIEW `vwemailupdate` AS select `e`.`iChangeID` AS `iChangeID`,`u`.`vcName` AS `vcName`,`e`.`vcGUID` AS `vcGUID`,`e`.`vcNewEmail` AS `vcNewEmail`,`e`.`vcReqIPAdd` AS `vcReqIPAdd`,`e`.`dtTimeStamp` AS `dtTimeStamp` from (`tblemailupdate` `e` join `tblUsers` `u` on((`e`.`iClientID` = `u`.`iUserID`))) order by `e`.`dtTimeStamp` desc;
CREATE VIEW `vwPrivLevels` AS select `tblprivlevels`.`iPrivLevel` AS `iOrder`,`tblprivlevels`.`iPrivLevel` AS `vcType`,`tblprivlevels`.`vcPrivName` AS `vcText` from `tblprivlevels` where (`tblprivlevels`.`iPrivLevel` > 0);

CREATE OR REPLACE VIEW vwmenupriv AS
SELECT m.iMenuID, m.vcTitle, r.vcPrivName ReadPriv, w.vcPrivName WritePriv, m.vcHeader, m.bAdmin, m.bSecure, t.iMenuOrder, m.bNewWindow, t.iSubOfMenu
FROM tblmenu m
LEFT JOIN tblmenutype t ON m.iMenuID = t.iMenuID
JOIN tblprivlevels r ON m.iReadPriv = r.iPrivLevel
JOIN tblprivlevels w ON m.iWritePriv = w.iPrivLevel;

CREATE OR REPLACE VIEW vwmenuitem AS
SELECT  m.*,t.vcMenuType,t.iMenuOrder,t.iSubOfMenu
FROM tblmenu m
JOIN tblmenutype t ON m.iMenuID = t.iMenuID
ORDER BY t.vcMenuType,t.iMenuOrder,t.iSubOfMenu;

CREATE OR REPLACE VIEW vwTopMenu AS
SELECT  m.*,t.vcMenuType,t.iMenuOrder,t.iSubOfMenu
FROM tblmenu m
JOIN tblmenutype t ON m.iMenuID = t.iMenuID
WHERE t.iSubOfMenu = 0 AND m.iMenuID != 21
UNION
SELECT 0,"None",NULL,0,0,NULL,0,0,0,0,0,"head",0,0
ORDER BY iMenuID;

CREATE OR REPLACE VIEW vwMenuPos AS
SELECT  m.*,t.vcMenuType,t.iMenuOrder,t.iSubOfMenu
FROM tblmenu m
LEFT JOIN tblmenutype t ON m.iMenuID = t.iMenuID;

CREATE OR REPLACE VIEW vwLinks AS
	SELECT vcLink, vcName, vcComment, iCatId, vcCategory, iSortNum
	FROM  tbllinks L
	LEFT JOIN  tbllinkcategory C on  C.iCatId = L.iCategory;
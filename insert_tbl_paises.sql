--
-- Estrutura da tabela `tbl_paises`
--

CREATE TABLE IF NOT EXISTS `tbl_paises` (
  `paisId` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `paisNome` varchar(50) NOT NULL,
  `paisName` varchar(50) NOT NULL,
  PRIMARY KEY (`paisId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=253 ;

--
-- Extraindo dados da tabela `tbl_paises`
--

INSERT INTO `tbl_paises` (`paisId`, `paisNome`, `paisName`) VALUES
(1, 'AFEGANISTÃO', 'AFGHANISTAN'),
(2, 'ACROTÍRI E DECELIA', 'AKROTIRI E DEKÉLIA'),
(3, 'ÁFRICA DO SUL', 'SOUTH AFRICA'),
(4, 'ALBÂNIA', 'ALBANIA'),
(5, 'ALEMANHA', 'GERMANY'),
(6, 'AMERICAN SAMOA', 'AMERICAN SAMOA'),
(7, 'ANDORRA', 'ANDORRA'),
(8, 'ANGOLA', 'ANGOLA'),
(9, 'ANGUILLA', 'ANGUILLA'),
(10, 'ANTÍGUA E BARBUDA', 'ANTIGUA AND BARBUDA'),
(11, 'ANTILHAS NEERLANDESAS', 'NETHERLANDS ANTILLES'),
(12, 'ARÁBIA SAUDITA', 'SAUDI ARABIA'),
(13, 'ARGÉLIA', 'ALGERIA'),
(14, 'ARGENTINA', 'ARGENTINA'),
(15, 'ARMÉNIA', 'ARMENIA'),
(16, 'ARUBA', 'ARUBA'),
(17, 'AUSTRÁLIA', 'AUSTRALIA'),
(18, 'ÁUSTRIA', 'AUSTRIA'),
(19, 'AZERBAIJÃO', 'AZERBAIJAN'),
(20, 'BAHAMAS', 'BAHAMAS, THE'),
(21, 'BANGLADECHE', 'BANGLADESH'),
(22, 'BARBADOS', 'BARBADOS'),
(23, 'BARÉM', 'BAHRAIN'),
(24, 'BASSAS DA ÍNDIA', 'BASSAS DA INDIA'),
(25, 'BÉLGICA', 'BELGIUM'),
(26, 'BELIZE', 'BELIZE'),
(27, 'BENIM', 'BENIN'),
(28, 'BERMUDAS', 'BERMUDA'),
(29, 'BIELORRÚSSIA', 'BELARUS'),
(30, 'BOLÍVIA', 'BOLIVIA'),
(31, 'BÓSNIA E HERZEGOVINA', 'BOSNIA AND HERZEGOVINA'),
(32, 'BOTSUANA', 'BOTSWANA'),
(33, 'BRASIL', 'BRAZIL'),
(34, 'BRUNEI DARUSSALAM', 'BRUNEI DARUSSALAM'),
(35, 'BULGÁRIA', 'BULGARIA'),
(36, 'BURQUINA FASO', 'BURKINA FASO'),
(37, 'BURUNDI', 'BURUNDI'),
(38, 'BUTÃO', 'BHUTAN'),
(39, 'CABO VERDE', 'CAPE VERDE'),
(40, 'CAMARÕES', 'CAMEROON'),
(41, 'CAMBOJA', 'CAMBODIA'),
(42, 'CANADÁ', 'CANADA'),
(43, 'CATAR', 'QATAR'),
(44, 'CAZAQUISTÃO', 'KAZAKHSTAN'),
(45, 'CENTRO-AFRICANA REPÚBLICA', 'CENTRAL AFRICAN REPUBLIC'),
(46, 'CHADE', 'CHAD'),
(47, 'CHILE', 'CHILE'),
(48, 'CHINA', 'CHINA'),
(49, 'CHIPRE', 'CYPRUS'),
(50, 'COLÔMBIA', 'COLOMBIA'),
(51, 'COMORES', 'COMOROS'),
(52, 'CONGO', 'CONGO'),
(53, 'CONGO REPÚBLICA DEMOCRÁTICA', 'CONGO DEMOCRATIC REPUBLIC'),
(54, 'COREIA DO NORTE', 'KOREA NORTH'),
(55, 'COREIA DO SUL', 'KOREA SOUTH'),
(56, 'COSTA DO MARFIM', 'IVORY COAST'),
(57, 'COSTA RICA', 'COSTA RICA'),
(58, 'CROÁCIA', 'CROATIA'),
(59, 'CUBA', 'CUBA'),
(60, 'DINAMARCA', 'DENMARK'),
(61, 'DOMÍNICA', 'DOMINICA'),
(62, 'EGIPTO', 'EGYPT'),
(63, 'EMIRADOS ÁRABES UNIDOS', 'UNITED ARAB EMIRATES'),
(64, 'EQUADOR', 'ECUADOR'),
(65, 'ERITREIA', 'ERITREA'),
(66, 'ESLOVÁQUIA', 'SLOVAKIA'),
(67, 'ESLOVÉNIA', 'SLOVENIA'),
(68, 'ESPANHA', 'SPAIN'),
(69, 'ESTADOS UNIDOS', 'UNITED STATES'),
(70, 'ESTÓNIA', 'ESTONIA'),
(71, 'ETIÓPIA', 'ETHIOPIA'),
(72, 'FAIXA DE GAZA', 'GAZA STRIP'),
(73, 'FIJI', 'FIJI'),
(74, 'FILIPINAS', 'PHILIPPINES'),
(75, 'FINLÂNDIA', 'FINLAND'),
(76, 'FRANÇA', 'FRANCE'),
(77, 'GABÃO', 'GABON'),
(78, 'GÂMBIA', 'GAMBIA'),
(79, 'GANA', 'GHANA'),
(80, 'GEÓRGIA', 'GEORGIA'),
(81, 'GIBRALTAR', 'GIBRALTAR'),
(82, 'GRANADA', 'GRENADA'),
(83, 'GRÉCIA', 'GREECE'),
(84, 'GRONELÂNDIA', 'GREENLAND'),
(85, 'GUADALUPE', 'GUADELOUPE'),
(86, 'GUAM', 'GUAM'),
(87, 'GUATEMALA', 'GUATEMALA'),
(88, 'GUERNSEY', 'GUERNSEY'),
(89, 'GUIANA', 'GUYANA'),
(90, 'GUIANA FRANCESA', 'FRENCH GUIANA'),
(91, 'GUINÉ', 'GUINEA'),
(92, 'GUINÉ EQUATORIAL', 'EQUATORIAL GUINEA'),
(93, 'GUINÉ-BISSAU', 'GUINEA-BISSAU'),
(94, 'HAITI', 'HAITI'),
(95, 'HONDURAS', 'HONDURAS'),
(96, 'HONG KONG', 'HONG KONG'),
(97, 'HUNGRIA', 'HUNGARY'),
(98, 'IÉMEN', 'YEMEN'),
(99, 'ILHA BOUVET', 'BOUVET ISLAND'),
(100, 'ILHA CHRISTMAS', 'CHRISTMAS ISLAND'),
(101, 'ILHA DE CLIPPERTON', 'CLIPPERTON ISLAND'),
(102, 'ILHA DE JOÃO DA NOVA', 'JUAN DE NOVA ISLAND'),
(103, 'ILHA DE MAN', 'ISLE OF MAN'),
(104, 'ILHA DE NAVASSA', 'NAVASSA ISLAND'),
(105, 'ILHA EUROPA', 'EUROPA ISLAND'),
(106, 'ILHA NORFOLK', 'NORFOLK ISLAND'),
(107, 'ILHA TROMELIN', 'TROMELIN ISLAND'),
(108, 'ILHAS ASHMORE E CARTIER', 'ASHMORE AND CARTIER ISLANDS'),
(109, 'ILHAS CAIMAN', 'CAYMAN ISLANDS'),
(110, 'ILHAS COCOS (KEELING)', 'COCOS (KEELING) ISLANDS'),
(111, 'ILHAS COOK', 'COOK ISLANDS'),
(112, 'ILHAS DO MAR DE CORAL', 'CORAL SEA ISLANDS'),
(113, 'ILHAS FALKLANDS (ILHAS MALVINAS)', 'FALKLAND ISLANDS (ISLAS MALVINAS)'),
(114, 'ILHAS FEROE', 'FAROE ISLANDS'),
(115, 'ILHAS GEÓRGIA DO SUL E SANDWICH DO SUL', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS'),
(116, 'ILHAS MARIANAS DO NORTE', 'NORTHERN MARIANA ISLANDS'),
(117, 'ILHAS MARSHALL', 'MARSHALL ISLANDS'),
(118, 'ILHAS PARACEL', 'PARACEL ISLANDS'),
(119, 'ILHAS PITCAIRN', 'PITCAIRN ISLANDS'),
(120, 'ILHAS SALOMÃO', 'SOLOMON ISLANDS'),
(121, 'ILHAS SPRATLY', 'SPRATLY ISLANDS'),
(122, 'ILHAS VIRGENS AMERICANAS', 'UNITED STATES VIRGIN ISLANDS'),
(123, 'ILHAS VIRGENS BRITÂNICAS', 'BRITISH VIRGIN ISLANDS'),
(124, 'ÍNDIA', 'INDIA'),
(125, 'INDONÉSIA', 'INDONESIA'),
(126, 'IRÃO', 'IRAN'),
(127, 'IRAQUE', 'IRAQ'),
(128, 'IRLANDA', 'IRELAND'),
(129, 'ISLÂNDIA', 'ICELAND'),
(130, 'ISRAEL', 'ISRAEL'),
(131, 'ITÁLIA', 'ITALY'),
(132, 'JAMAICA', 'JAMAICA'),
(133, 'JAN MAYEN', 'JAN MAYEN'),
(134, 'JAPÃO', 'JAPAN'),
(135, 'JERSEY', 'JERSEY'),
(136, 'JIBUTI', 'DJIBOUTI'),
(137, 'JORDÂNIA', 'JORDAN'),
(138, 'KIRIBATI', 'KIRIBATI'),
(139, 'KOWEIT', 'KUWAIT'),
(140, 'LAOS', 'LAOS'),
(141, 'LESOTO', 'LESOTHO'),
(142, 'LETÓNIA', 'LATVIA'),
(143, 'LÍBANO', 'LEBANON'),
(144, 'LIBÉRIA', 'LIBERIA'),
(145, 'LÍBIA', 'LIBYAN ARAB JAMAHIRIYA'),
(146, 'LISTENSTAINE', 'LIECHTENSTEIN'),
(147, 'LITUÂNIA', 'LITHUANIA'),
(148, 'LUXEMBURGO', 'LUXEMBOURG'),
(149, 'MACAU', 'MACAO'),
(150, 'MACEDÓNIA', 'MACEDONIA'),
(151, 'MADAGÁSCAR', 'MADAGASCAR'),
(152, 'MALÁSIA', 'MALAYSIA'),
(153, 'MALAVI', 'MALAWI'),
(154, 'MALDIVAS', 'MALDIVES'),
(155, 'MALI', 'MALI'),
(156, 'MALTA', 'MALTA'),
(157, 'MARROCOS', 'MOROCCO'),
(158, 'MARTINICA', 'MARTINIQUE'),
(159, 'MAURÍCIA', 'MAURITIUS'),
(160, 'MAURITÂNIA', 'MAURITANIA'),
(161, 'MAYOTTE', 'MAYOTTE'),
(162, 'MÉXICO', 'MEXICO'),
(163, 'MIANMAR', 'MYANMAR BURMA'),
(164, 'MICRONÉSIA', 'MICRONESIA'),
(165, 'MOÇAMBIQUE', 'MOZAMBIQUE'),
(166, 'MOLDÁVIA', 'MOLDOVA'),
(167, 'MÓNACO', 'MONACO'),
(168, 'MONGÓLIA', 'MONGOLIA'),
(169, 'MONTENEGRO', 'MONTENEGRO'),
(170, 'MONTSERRAT', 'MONTSERRAT'),
(171, 'NAMÍBIA', 'NAMIBIA'),
(172, 'NAURU', 'NAURU'),
(173, 'NEPAL', 'NEPAL'),
(174, 'NICARÁGUA', 'NICARAGUA'),
(175, 'NÍGER', 'NIGER'),
(176, 'NIGÉRIA', 'NIGERIA'),
(177, 'NIUE', 'NIUE'),
(178, 'NORUEGA', 'NORWAY'),
(179, 'NOVA CALEDÓNIA', 'NEW CALEDONIA'),
(180, 'NOVA ZELÂNDIA', 'NEW ZEALAND'),
(181, 'OMÃ', 'OMAN'),
(182, 'PAÍSES BAIXOS', 'NETHERLANDS'),
(183, 'PALAU', 'PALAU'),
(184, 'PALESTINA', 'PALESTINE'),
(185, 'PANAMÁ', 'PANAMA'),
(186, 'PAPUÁSIA-NOVA GUINÉ', 'PAPUA NEW GUINEA'),
(187, 'PAQUISTÃO', 'PAKISTAN'),
(188, 'PARAGUAI', 'PARAGUAY'),
(189, 'PERU', 'PERU'),
(190, 'POLINÉSIA FRANCESA', 'FRENCH POLYNESIA'),
(191, 'POLÓNIA', 'POLAND'),
(192, 'PORTO RICO', 'PUERTO RICO'),
(193, 'PORTUGAL', 'PORTUGAL'),
(194, 'QUÉNIA', 'KENYA'),
(195, 'QUIRGUIZISTÃO', 'KYRGYZSTAN'),
(196, 'REINO UNIDO', 'UNITED KINGDOM'),
(197, 'REPÚBLICA CHECA', 'CZECH REPUBLIC'),
(198, 'REPÚBLICA DOMINICANA', 'DOMINICAN REPUBLIC'),
(199, 'ROMÉNIA', 'ROMANIA'),
(200, 'RUANDA', 'RWANDA'),
(201, 'RÚSSIA', 'RUSSIAN FEDERATION'),
(202, 'SAHARA OCCIDENTAL', 'WESTERN SAHARA'),
(203, 'SALVADOR', 'EL SALVADOR'),
(204, 'SAMOA', 'SAMOA'),
(205, 'SANTA HELENA', 'SAINT HELENA'),
(206, 'SANTA LÚCIA', 'SAINT LUCIA'),
(207, 'SANTA SÉ', 'HOLY SEE'),
(208, 'SÃO CRISTÓVÃO E NEVES', 'SAINT KITTS AND NEVIS'),
(209, 'SÃO MARINO', 'SAN MARINO'),
(210, 'SÃO PEDRO E MIQUELÃO', 'SAINT PIERRE AND MIQUELON'),
(211, 'SÃO TOMÉ E PRÍNCIPE', 'SAO TOME AND PRINCIPE'),
(212, 'SÃO VICENTE E GRANADINAS', 'SAINT VINCENT AND THE GRENADINES'),
(213, 'SEICHELES', 'SEYCHELLES'),
(214, 'SENEGAL', 'SENEGAL'),
(215, 'SERRA LEOA', 'SIERRA LEONE'),
(216, 'SÉRVIA', 'SERBIA'),
(217, 'SINGAPURA', 'SINGAPORE'),
(218, 'SÍRIA', 'SYRIA'),
(219, 'SOMÁLIA', 'SOMALIA'),
(220, 'SRI LANCA', 'SRI LANKA'),
(221, 'SUAZILÂNDIA', 'SWAZILAND'),
(222, 'SUDÃO', 'SUDAN'),
(223, 'SUÉCIA', 'SWEDEN'),
(224, 'SUÍÇA', 'SWITZERLAND'),
(225, 'SURINAME', 'SURINAME'),
(226, 'SVALBARD', 'SVALBARD'),
(227, 'TAILÂNDIA', 'THAILAND'),
(228, 'TAIWAN', 'TAIWAN'),
(229, 'TAJIQUISTÃO', 'TAJIKISTAN'),
(230, 'TANZÂNIA', 'TANZANIA'),
(231, 'TERRITÓRIO BRITÂNICO DO OCEANO ÍNDICO', 'BRITISH INDIAN OCEAN TERRITORY'),
(232, 'TERRITÓRIO DAS ILHAS HEARD E MCDONALD', 'HEARD ISLAND AND MCDONALD ISLANDS'),
(233, 'TIMOR-LESTE', 'TIMOR-LESTE'),
(234, 'TOGO', 'TOGO'),
(235, 'TOKELAU', 'TOKELAU'),
(236, 'TONGA', 'TONGA'),
(237, 'TRINDADE E TOBAGO', 'TRINIDAD AND TOBAGO'),
(238, 'TUNÍSIA', 'TUNISIA'),
(239, 'TURKS E CAICOS', 'TURKS AND CAICOS ISLANDS'),
(240, 'TURQUEMENISTÃO', 'TURKMENISTAN'),
(241, 'TURQUIA', 'TURKEY'),
(242, 'TUVALU', 'TUVALU'),
(243, 'UCRÂNIA', 'UKRAINE'),
(244, 'UGANDA', 'UGANDA'),
(245, 'URUGUAI', 'URUGUAY'),
(246, 'USBEQUISTÃO', 'UZBEKISTAN'),
(247, 'VANUATU', 'VANUATU'),
(248, 'VENEZUELA', 'VENEZUELA'),
(249, 'VIETNAME', 'VIETNAM'),
(250, 'WALLIS E FUTUNA', 'WALLIS AND FUTUNA'),
(251, 'ZÂMBIA', 'ZAMBIA'),
(252, 'ZIMBABUÉ', 'ZIMBABWE');



alter table tbl_clientes add id_pais_origem varchar(11) NOT NULL DEFAULT 0;

alter table tbl_clientes add des_banco varchar(60);

alter table tbl_clientes add des_agencia_banco varchar(60);

alter table tbl_clientes add des_conta_banco varchar(60);

alter table tbl_clientes add cpf_cnpj_financeiro varchar(60);

alter table tbl_clientes add contato_estrangeiro varchar(70);

alter table tbl_clientes add documento_estrangeiro varchar(70);

-- novos campos solicitados
alter table tbl_clientes add cep_estrangeiro varchar(100);

alter table tbl_clientes add estado_estrangeiro varchar(100);

alter table tbl_clientes add cidade_estrangeiro varchar(100);

alter table tbl_clientes add logradouro_estrangeiro varchar(100);

alter table tbl_clientes add bairro_estrangeiro varchar(100);

alter table tbl_clientes add numero_estrangeiro varchar(100);

alter table tbl_clientes add dependentes varchar(20);

alter table tbl_clientes add nome_dependente varchar(100);


alter table tbl_clientes add data_nasc_dependente varchar(50);


alter table tbl_clientes add idade_dependente varchar(50);


alter table tbl_clientes add nome_dependente02 varchar(100);


alter table tbl_clientes add data_nasc_dependente02 varchar(50);


alter table tbl_clientes add idade_dependente02 varchar(50);


alter table tbl_clientes add nome_dependente03 varchar(100);


alter table tbl_clientes add data_nasc_dependente03 varchar(50);


alter table tbl_clientes add idade_dependente03 varchar(50);


CREATE TABLE `tbl_clientes_dependentes` (
  `id_cliente` int(11) NOT NULL,
  `id_dependente` int(11) NOT NULL,
  `nome_dependente`      varchar(150) NOT NULL,
  `data_nascimento`      varchar(50) NOT NULL,
  `data_maioridade`     varchar(50) ,
  `data_insercao_dependente` varchar(50),
    PRIMARY KEY (id_cliente,id_dependente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `tbl_recebimentos` (
  `id_recebimento` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente`     int(11) NOT NULL,
  `cotacao_euro`      varchar(150) NOT NULL,
  `data_cotacao_euro`  varchar(50) NOT NULL,
  `moeda_selecionada`     varchar(50) NOT NULL,
  `valor_recebimento`     varchar(50) ,
  `valor_real`            varchar(50) ,
  `parcelamento`          varchar(50) ,
  `tipo`                  varchar(50) ,
  `valor_entrada`         varchar(50) ,
  `valor_total`         varchar(50) ,
  `condicoes`          varchar(50) ,
    PRIMARY KEY (id_recebimento,id_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `tbl_parcelas_recebimentos` (
  `id_recebimento` int(11) NOT NULL,
  `id_parcela`     int(11) NOT NULL,
  `des_parcela`      varchar(150) NOT NULL,
  `valor_parcela`  varchar(50) NOT NULL,
  `valor_pago_parcela`     varchar(50) ,
  `ind_pago`     varchar(50) ,
  `data_parcela`            varchar(50) ,
  `caminho_arquivo_comprovante`     varchar(250) ,
  `nome_arquivo_comprovante`      varchar(150) ,
    PRIMARY KEY (id_recebimento,id_parcela)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;











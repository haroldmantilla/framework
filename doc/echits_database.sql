USE echits;

DROP TABLE IF EXISTS `Midshipman`;
DROP TABLE IF EXISTS `Chit`;
DROP TABLE IF EXISTS `Leader`;

DROP TABLE IF EXISTS `Leader`;
CREATE TABLE Leader(
	username VARCHAR(10) NOT NULL,
	firstName VARCHAR(20) NULL,
	lastName VARCHAR(20) NULL,
	billet VARCHAR(40) NULL,
	rank VARCHAR(9),
	service VARCHAR(4),
	level VARCHAR(7),
	primary key (username)
);

DROP TABLE IF EXISTS `Board`;
CREATE TABLE Board(
	username VARCHAR(10) NOT NULL,
	post VARCHAR(200) NULL,
	posttime DATETIME NULL,
	id INT NOT NULL AUTO_INCREMENT,
	primary key (id)
);

DROP TABLE IF EXISTS `Rates`;
CREATE TABLE Rates(
	rate VARCHAR(10) primary key
);

INSERT INTO Rates (rate) values ('ABC'), ('ACC'), ('ADC'), ('AEC'), ('AGC'), ('AMC'), ('AOC'), ('ASC'), ('ATC'), ('AWC'), ('AZC'), ('PRC'), ('BUC'), ('CEC'), ('CMC'), ('EAC'), ('EOC'), ('SWC'), ('UTC'), ('HMC'), ('BMC'), ('CSC'), ('CTIC'), ('CTMC'), ('CTNC'), ('CTRC'), ('CTTC'), ('EODC'), ('ETC'), ('FCC'), ('FTC'), ('GMC'),
('ISC'), ('ITC'), ('LNC'), ('LSC'), ('MAC'), ('MCC'), ('MNC'), ('MTC'), ('MUC'), ('NCC'), ('OSC'), ('PSC'), ('QMC'), ('RPC'), ('SBC'), ('SHC'), ('SOC'), ('STC'), ('YNC'), ('DCC'), ('EMC'), ('ENC'), ('GSC'), ('HTC'), ('ICC'), ('MMC'), ('MRC'), ('NDC'), ('ABCS'), ('ACCS'), ('ADCS'), ('AECS'), ('AGCS'),
('AMCS'), ('AOCS'), ('ASCS'), ('ATCS'), ('AWCS'), ('AZCS'), ('PRCS'), ('BUCS'), ('CECS'), ('CMCS'), ('EACS'), ('EOCS'), ('SWCS'), ('UTCS'), ('HMCS'), ('BMCS'), ('CSCS'), ('CTICS'), ('CTMCS'), ('CTNCS'), ('CTRCS'), ('CTTCS'), ('EODCS'), ('ETCS'), ('FCCS'), ('FTCS'), ('GMCS'), ('ISCS'), ('ITCS'), ('LNCS'), ('LSCS'), ('MACS'), ('MCCS'),
('MNCS'), ('MTCS'), ('MUCS'), ('NCCS'), ('OSCS'), ('PSCS'), ('QMCS'), ('RPCS'), ('SBCS'), ('SHCS'), ('SOCS'), ('STCS'), ('YNCS'), ('DCCS'), ('EMCS'), ('ENCS'), ('GSCS'), ('HTCS'), ('ICCS'), ('MMCS'), ('MRCS'), ('NDCS');


DROP TABLE IF EXISTS `Midshipman`;
CREATE TABLE Midshipman(
	alpha VARCHAR(10) NOT NULL,
    company INT NULL,
    classYear INT NULL,
    room INT NULL,
    SQPR DOUBLE NULL,
    CQPR DOUBLE NULL,
    phoneNumber varchar(14),
    aptitudeGrade CHAR(1) NULL,
    conductGrade CHAR(1) NULL,
    coc_0 VARCHAR(10) NULL,
    coc_1 VARCHAR(10) NULL,
    coc_2 VARCHAR(10) NULL,
    coc_3 VARCHAR(10) NULL,
    coc_4 VARCHAR(10) NULL,
    coc_5 VARCHAR(10) NULL,
    coc_6 VARCHAR(10) NULL,
		coc_7 VARCHAR(10) NULL,
    coc_8 VARCHAR(10) NULL,
    primary key (alpha),
    foreign key f1(alpha) references Leader(username)
    ON DELETE CASCADE ON UPDATE RESTRICT,
    foreign key f2(coc_0) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f3(coc_1) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f4(coc_2) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f5(coc_3) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f6(coc_4) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f7(coc_5) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
		foreign key f8(coc_6) references Leader(username)
		ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f9(coc_7) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT,
    foreign key f10(coc_8) references Leader(username)
    ON DELETE SET NULL ON UPDATE RESTRICT
);


DROP TABLE IF EXISTS `Chit`;
CREATE TABLE Chit(
	chitNumber INT,
	creator VARCHAR(10),
	description VARCHAR(100),
	reference VARCHAR(100),
	requestType CHAR(1),
	requestOther VARCHAR(30),
	addr_careOf VARCHAR(30),
	addr_street VARCHAR(30),
	addr_city VARCHAR(30),
	addr_state CHAR(2),
	addr_zip CHAR(5),
	archiveactive INT,
	remarks VARCHAR(2000),
	createdDate VARCHAR(7),
	startDate VARCHAR(7),
	startTime VARCHAR(4),
	endDate VARCHAR(7),
	endTime VARCHAR(4),
	ormURL VARCHAR(200),
	supportingDocsURL VARCHAR(200),

	coc_0_username VARCHAR(10) NULL,
	coc_0_status VARCHAR(20),
	coc_0_comments VARCHAR(200),
	coc_0_date VARCHAR(7),
	coc_0_time VARCHAR(4),

	coc_1_username VARCHAR(10) NULL,
	coc_1_status VARCHAR(20),
	coc_1_comments VARCHAR(200),
	coc_1_date VARCHAR(7),
	coc_1_time VARCHAR(4),

	coc_2_username VARCHAR(10) NULL,
	coc_2_status VARCHAR(20),
	coc_2_comments VARCHAR(200),
	coc_2_date VARCHAR(7),
	coc_2_time VARCHAR(4),

	coc_3_username VARCHAR(10) NULL,
	coc_3_status VARCHAR(20),
	coc_3_comments VARCHAR(200),
	coc_3_date VARCHAR(7),
	coc_3_time VARCHAR(4),

	coc_4_username VARCHAR(10) NULL,
	coc_4_status VARCHAR(20),
	coc_4_comments VARCHAR(200),
	coc_4_date VARCHAR(7),
	coc_4_time VARCHAR(4),

	coc_5_username VARCHAR(10) NULL,
	coc_5_status VARCHAR(20),
	coc_5_comments VARCHAR(200),
	coc_5_date VARCHAR(7),
	coc_5_time VARCHAR(4),

	coc_6_username VARCHAR(10) NULL,
	coc_6_status VARCHAR(20),
	coc_6_comments VARCHAR(200),
	coc_6_date VARCHAR(7),
	coc_6_time VARCHAR(4),


	coc_7_username VARCHAR(10) NULL,
	coc_7_status VARCHAR(20),
	coc_7_comments VARCHAR(200),
	coc_7_date VARCHAR(7),
	coc_7_time VARCHAR(4),


	coc_8_username VARCHAR(10) NULL,
	coc_8_status VARCHAR(20),
	coc_8_comments VARCHAR(200),
	coc_8_date VARCHAR(7),
	coc_8_time VARCHAR(4),

	PRIMARY KEY (chitNumber),
	FOREIGN KEY f1(creator) REFERENCES Leader(username)
	ON DELETE CASCADE ON UPDATE RESTRICT,
	FOREIGN KEY f2(coc_0_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f3(coc_1_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f4(coc_2_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f5(coc_3_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f6(coc_4_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f7(coc_5_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f8(coc_6_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f9(coc_7_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT,
	FOREIGN KEY f10(coc_8_username) REFERENCES Leader(username)
	ON DELETE SET NULL ON UPDATE RESTRICT
);


INSERT INTO Leader(username, firstName, lastName, billet, rank, service, level) values
('andrew', 'Jeremy', 'Andrew', '1st Battalion Officer', 'CDR', 'USN', 'Officer'),
('grady', 'Thomas', 'Grady', 'Deputy Commandant', 'CAPT', 'USN', 'Officer'),
('chadwick', 'Robert', 'Chadwick', 'Commandant', 'CAPT', 'USN', 'Officer'),
('egarcia', 'Eric', 'Garcia', '1st Company Officer', 'LT', 'USN', 'Officer'),
('skhan', 'Sidorak', 'Khan', '1st Company SEL', 'GySgt', 'USMC', 'SEL'),
('m184890', 'Margaret', 'Pana', '1st Company Commander', 'MIDN LT', 'USN', 'MID'),
('m182700',  'Mathew', 'Hogue', '1st Company XO', 'MIDN LTJG', 'USN', 'MID'),
('m183990', 'Scott', 'Mayer', 'Platoon Commander', 'MIDN LTJG', 'USN', 'MID'),
('m181674', 'Daniel', 'Dwyer', 'Platoon Commander', 'MIDN LTJG', 'USN', 'MID'),
('m181752', 'Theresa', 'Erbach', 'Platoon Commander', 'MIDN LTJG', 'USN', 'MID'),
('m180078', 'Dakota', 'Allen', 'Platoon Commander', 'MIDN LTJG', 'USN', 'MID'),
('m181536',  'Noreen', 'Domingo', 'Squad Leader', 'MIDN ENS', 'USN', 'MID'),
('m185280', 'Timothy', 'Ragan', 'Squad Leader', 'MIDN ENS', 'USN', 'MID'),
('m194818',  'Jay', 'Oh', 'Squad Leader', 'MIDN 2/C', 'USN', 'MID'),
('m180978',  'Andrew', 'Chang', 'Squad Leader', 'MIDN ENS', 'USN', 'MID'),
('m181458',  'Julie', 'Dejnozka', 'Squad Leader', 'MIDN ENS', 'USN', 'MID'),
('m195448', 'Jocelyn', 'Rodriguez', 'Squad Leader', 'MIDN 2/C', 'USN', 'MID'),
('m184068',  'Kevin', 'McCoy', 'Squad Leader', 'MIDN ENS', 'USN', 'MID'),
('m190000', 'Kristina', 'Bodeman', 'MISLO', 'MIDN 2/C', 'USN', 'MID'),
('m190001', 'Andrew', 'Eisenhauer', 'Safety Officer', 'MIDN 2/C', 'USN', 'MID');


INSERT INTO Midshipman(alpha, company, classYear, room, SQPR, CQPR, phoneNumber, aptitudeGrade, conductGrade, coc_0, coc_1, coc_2, coc_3, coc_4, coc_5, coc_6, coc_7, coc_8) values
('m183990', 1, 2018, 1026,  3.5, 3.6, '(513) 240-9398', 'A', 'A', 'chadwick', 'grady', 'andrew', 'egarcia', 'skhan', 'm184890', 'm182700', 'm190001', 'm190000'),
('m190000', 1, 2018, 1026,  3.5, 3.6, '(513) 240-9398', 'A', 'A', 'chadwick', 'grady', 'andrew', 'egarcia', 'skhan', 'm184890', 'm182700', NULL, NULL ),
('m190001', 1, 2018, 1026,  3.5, 3.6, '(513) 240-9398', 'A', 'A', 'chadwick', 'grady', 'andrew', 'egarcia', 'skhan', 'm184890', 'm182700', NULL, NULL );


INSERT INTO Chit(chitNumber, creator, description, reference, requestType, requestOther, addr_careOf, addr_street, addr_city, addr_state, addr_zip, archiveactive, remarks, createdDate, startDate, startTime, endDate, endTime, coc_0_username, coc_0_status, coc_0_comments, coc_0_date, coc_0_time, coc_1_username, coc_1_status, coc_1_comments, coc_1_date, coc_1_time, coc_2_username, coc_2_status, coc_2_comments, coc_2_date, coc_2_time, coc_3_username, coc_3_status, coc_3_comments, coc_3_date, coc_3_time, coc_4_username,coc_4_status, coc_4_comments,coc_4_date, coc_4_time, coc_5_username, coc_5_status, coc_5_comments, coc_5_date, coc_5_time, coc_6_username, coc_6_status, coc_6_comments, coc_6_date, coc_6_time, coc_7_username, coc_7_status, coc_7_comments, coc_7_date, coc_7_time, coc_8_username, coc_8_status, coc_8_comments, coc_8_date, coc_8_time) VALUES #related to position, determins number of CoC peeps
(1, 'm183990', 'Beat Army Weekend', 'COMDTMIDNINST 5400.6N', 'W', NULL, NULL, '2226 Spring Lake Dr', 'Timonium', 'MD', '21037', 0, 'Sir, I respectfully request permission to take a Beat Army Weekend.','12DEC17', '20DEC17', '1000', '12DEC17', '1800', 'chadwick', 'PENDING', NULL, NULL, NULL, 'grady', 'PENDING', NULL, NULL, NULL, 'andrew', 'PENDING', NULL, NULL, NULL, 'egarcia', 'PENDING', NULL, NULL, NULL, 'skhan', 'PENDING', NULL, NULL, NULL, 'm184890', 'PENDING', NULL, NULL, NULL, 'm182700', 'PENDING', NULL, NULL, NULL, 'm190001', 'PENDING', NULL, NULL, NULL, 'm190000', 'PENDING', NULL, NULL, NULL);

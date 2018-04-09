DELIMITER $$

#get next chit number
DROP PROCEDURE IF EXISTS lastChitNumber$$
CREATE PROCEDURE lastChitNumber ()
BEGIN
	SELECT chitNumber from Chit order by chitNumber desc limit 1;
END $$
#call lastChitNumber();


DROP PROCEDURE IF EXISTS getCompanyNumber$$
CREATE PROCEDURE getCompanyNumber (
	p_alpha varchar(10)
)
BEGIN
	SELECT company from Midshipman WHERE alpha = p_alpha;
END $$


#update midshipman profile

DROP PROCEDURE IF EXISTS createMidshipman$$
CREATE PROCEDURE createMidshipman (
	p_alpha varchar(10),
    p_company INT,
    p_classYear INT,
    p_room INT,
    p_SQPR DOUBLE,
    p_CQPR DOUBLE,
    p_phoneNumber varchar(14),
    p_aptitudeGrade CHAR(1),
    p_conductGrade CHAR(1),
    p_coc_0 varchar(10),
    p_coc_1 varchar(10),
    p_coc_2 varchar(10),
    p_coc_3 varchar(10),
    p_coc_4 varchar(10),
    p_coc_5 varchar(10),
    p_coc_6 varchar(10)
)
BEGIN
	INSERT INTO Midshipman(alpha, company, classYear, room, SQPR, CQPR, phoneNumber, aptitudeGrade, conductGrade, coc_0, coc_1, coc_2, coc_3, coc_4, coc_5, coc_6)
	VALUES (p_alpha, p_company, p_classYear, p_room, p_SQPR, p_CQPR, p_phoneNumber, p_aptitudeGrade, p_conductGrade,  p_coc_0, p_coc_1, p_coc_2, p_coc_3, p_coc_4, p_coc_5, p_coc_6)
    ON DUPLICATE KEY UPDATE
    alpha = p_alpha, company = p_company, classYear = p_classYear, room = p_room, SQPR = p_SQPR, CQPR = p_CQPR, phoneNumber = p_phoneNumber, aptitudeGrade = p_aptitudeGrade, conductGrade = p_conductGrade, coc_0 = p_coc_0, coc_1 = p_coc_1, coc_2 = p_coc_2, coc_3 = p_coc_3, coc_4 = p_coc_4, coc_5 = p_coc_5, coc_6 = p_coc_6;
END $$


DROP PROCEDURE IF EXISTS updateMidshipman $$
CREATE PROCEDURE updateMidshipman (
	p_alpha varchar(10),
  p_company INT,
  p_classYear INT,
  p_room INT,
  p_SQPR DOUBLE,
  p_CQPR DOUBLE,
  p_phoneNumber varchar(14),
  p_aptitudeGrade CHAR(1),
  p_conductGrade CHAR(1),
  p_coc_0 varchar(10),
  p_coc_1 varchar(10),
  p_coc_2 varchar(10),
  p_coc_3 varchar(10),
  p_coc_4 varchar(10),
  p_coc_5 varchar(10),
  p_coc_6 varchar(10)
)
BEGIN
	UPDATE Midshipman
	SET company = p_company, classYear = p_classYear, room = p_room, SQPR = p_SQPR, CQPR = p_CQPR, phoneNumber = p_phoneNumber, aptitudeGrade = p_aptitudeGrade, conductGrade = p_conductGrade, coc_0 = p_coc_0, coc_1 = p_coc_1, coc_2 = p_coc_2, coc_3 = p_coc_3, coc_4 = p_coc_4, coc_5 = p_coc_5, coc_6 = p_coc_6
	WHERE alpha = p_alpha;
END $$



DROP PROCEDURE IF EXISTS viewMidshipman $$
CREATE PROCEDURE viewMidshipman(
	p_alpha varchar(10)
)
BEGIN
	SELECT * FROM Midshipman WHERE alpha = p_alpha;
END $$

#call viewMidshipman('m183990');

DROP PROCEDURE IF EXISTS createLeader $$
CREATE PROCEDURE createLeader (
	p_username varchar(10),
	p_firstName VARCHAR(20),
	p_lastName VARCHAR(20),
	p_billet VARCHAR(40),
  p_accesslevel varchar(20),
  p_rank VARCHAR(9),
  p_service VARCHAR(4),
  p_level varchar(10)
)
BEGIN
	INSERT INTO Leader(username, firstName, lastName, billet, accesslevel, rank, service, level)
	VALUES (p_username, p_firstName, p_lastName, p_billet, p_accesslevel, p_rank, p_service, p_level)
    ON DUPLICATE KEY UPDATE username = p_username, firstName = p_firstName, 	lastName = p_lastName, billet = p_billet,  accesslevel = p_accesslevel,	rank = p_rank, service = p_service, level = p_level;
END $$


DROP PROCEDURE IF EXISTS updateLeader$$
CREATE PROCEDURE updateLeader (
	p_username varchar(10),
	p_firstName VARCHAR(20),
	p_lastName VARCHAR(20),
	p_billet VARCHAR(40),
	p_rank VARCHAR(9)
)
BEGIN
UPDATE Leader
SET firstName = p_firstName,
lastName = p_lastName,
billet = p_billet,
rank = p_rank
WHERE username = p_username;
END $$


DROP PROCEDURE IF EXISTS viewLeader $$
CREATE PROCEDURE viewLeader (
	p_username varchar(10)
)
BEGIN
	SELECT * from Leader WHERE username = p_username;
END $$

#call viewLeader('andrew');


DROP PROCEDURE IF EXISTS createChit $$
CREATE PROCEDURE createChit (
  	p_chitNumber INT,
    p_creator VARCHAR(10),
    p_description VARCHAR(100),
    p_reference VARCHAR(100),
    p_requestType CHAR(1),
		p_requestOther VARCHAR(30),
    p_addr_careOf VARCHAR(30),
		p_addr_street VARCHAR(30),
    p_addr_city VARCHAR(30),
    p_addr_state CHAR(2),
    p_addr_zip CHAR(5),
    p_archiveactive INT,
		p_remarks VARCHAR(2000),
		p_createdDate varchar(7),
    p_startDate VARCHAR(7),
    p_startTime VARCHAR(4),
    p_endDate VARCHAR(7),
    p_endTime VARCHAR(4),
    p_ormURL VARCHAR(200),
    p_supportingDocsURL VARCHAR(200),
    p_coc_0_username varchar(10),
    p_coc_0_status VARCHAR(8),
    p_coc_0_comments VARCHAR(200),
    p_coc_0_date VARCHAR(7),
    p_coc_0_time VARCHAR(4),

    p_coc_1_username varchar(10),
    p_coc_1_status VARCHAR(8),
    p_coc_1_comments VARCHAR(200),
    p_coc_1_date VARCHAR(7),
    p_coc_1_time VARCHAR(4),

    p_coc_2_username varchar(10),
    p_coc_2_status VARCHAR(8),
    p_coc_2_comments VARCHAR(200),
    p_coc_2_date VARCHAR(7),
    p_coc_2_time VARCHAR(4),

    p_coc_3_username varchar(10),
    p_coc_3_status VARCHAR(8),
    p_coc_3_comments VARCHAR(200),
    p_coc_3_date VARCHAR(7),
    p_coc_3_time VARCHAR(4),

    p_coc_4_username varchar(10),
    p_coc_4_status VARCHAR(8),
    p_coc_4_comments VARCHAR(200),
    p_coc_4_date VARCHAR(7),
    p_coc_4_time VARCHAR(4),

    p_coc_5_username varchar(10),
    p_coc_5_status VARCHAR(8),
    p_coc_5_comments VARCHAR(200),
    p_coc_5_date VARCHAR(7),
    p_coc_5_time VARCHAR(4),

    p_coc_6_username varchar(10),
    p_coc_6_status VARCHAR(8),
    p_coc_6_comments VARCHAR(200),
    p_coc_6_date VARCHAR(7),
    p_coc_6_time VARCHAR(4)
)
BEGIN
	INSERT INTO Chit(chitNumber, creator, description, reference, requestType, requestOther, addr_careOf, addr_street, addr_city, addr_state, addr_zip, archiveactive, remarks, createdDate, startDate, startTime, endDate, endTime, ormURL, supportingDocsURL, coc_0_username, coc_0_status, coc_0_comments, coc_0_date, coc_0_time, coc_1_username, coc_1_status, coc_1_comments, coc_1_date, coc_1_time, coc_2_username, coc_2_status, coc_2_comments, coc_2_date, coc_2_time, coc_3_username, coc_3_status, coc_3_comments, coc_3_date, coc_3_time, coc_4_username,coc_4_status, coc_4_comments,coc_4_date, coc_4_time, coc_5_username, coc_5_status, coc_5_comments, coc_5_date, coc_5_time, coc_6_username, coc_6_status, coc_6_comments, coc_6_date, coc_6_time)
    VALUES (p_chitNumber, p_creator, p_description, p_reference, p_requestType, p_requestOther, p_addr_careOf, p_addr_street, p_addr_city, p_addr_state, p_addr_zip, p_archiveactive, p_remarks, p_createdDate, p_startDate, p_startTime, p_endDate, p_endTime, p_ormURL, p_supportingDocsURL, p_coc_0_username, p_coc_0_status, p_coc_0_comments, p_coc_0_date, p_coc_0_time, p_coc_1_username, p_coc_1_status, p_coc_1_comments, p_coc_1_date, p_coc_1_time, p_coc_2_username, p_coc_2_status, p_coc_2_comments, p_coc_2_date, p_coc_2_time, p_coc_3_username, p_coc_3_status, p_coc_3_comments, p_coc_3_date, p_coc_3_time, p_coc_4_username, p_coc_4_status, p_coc_4_comments, p_coc_4_date, p_coc_4_time, p_coc_5_username, p_coc_5_status, p_coc_5_comments, p_coc_5_date, p_coc_5_time, p_coc_6_username, p_coc_6_status, p_coc_6_comments, p_coc_6_date, p_coc_6_time) ON DUPLICATE KEY UPDATE chitNumber = p_chitNumber, creator = p_creator, description = p_description, reference = p_reference, requestType = p_requestType, requestOther = p_requestOther, addr_careOf = p_addr_careOf, addr_street = p_addr_street, addr_city = p_addr_city, addr_state = p_addr_state, addr_zip = p_addr_zip, archiveactive = p_archiveactive, remarks = p_remarks, createdDate = p_createdDate, startDate = p_startDate, startTime = p_startTime, endDate = p_endDate, endTime = p_endTime, ormURL = p_ormURL, supportingDocsURL = p_supportingDocsURL, coc_0_username = p_coc_0_username, coc_0_status = p_coc_0_status, coc_0_comments = p_coc_0_comments, coc_0_date = p_coc_0_date, coc_0_time = p_coc_0_time, coc_1_username = p_coc_1_username, coc_1_status = p_coc_1_status, coc_1_comments = p_coc_1_comments, coc_1_date = p_coc_1_date, coc_1_time = p_coc_1_time, coc_2_username = p_coc_2_username, coc_2_status = p_coc_2_status, coc_2_comments = p_coc_2_comments, coc_2_date = p_coc_2_date, coc_2_time = p_coc_2_time, coc_3_username = p_coc_3_username, coc_3_status = p_coc_3_status, coc_3_comments = p_coc_3_comments, coc_3_date = p_coc_3_date, coc_3_time = p_coc_3_time, coc_4_username = p_coc_4_username, coc_4_status = p_coc_4_status, coc_4_comments = p_coc_4_comments, coc_4_date = p_coc_4_date, coc_4_time = p_coc_4_time, coc_5_username = p_coc_5_username, coc_5_status = p_coc_5_status, coc_5_comments = p_coc_5_comments, coc_5_date = p_coc_5_date, coc_5_time = p_coc_5_time, coc_6_username = p_coc_6_username, coc_6_status = p_coc_6_status, coc_6_comments = p_coc_6_comments, coc_6_date = p_coc_6_date, coc_6_time = p_coc_6_time;
END $$



DROP PROCEDURE IF EXISTS updateChit$$
CREATE PROCEDURE updateChit (
	p_chitNumber INT,
    p_creator VARCHAR(10),
    p_description VARCHAR(100),
    p_reference VARCHAR(100),
    p_requestType CHAR(1),
	p_requestOther VARCHAR(30),
    p_addr_careOf VARCHAR(30),
	p_addr_street VARCHAR(30),
    p_addr_city VARCHAR(30),
    p_addr_state CHAR(2),
    p_addr_zip CHAR(5),
    p_archiveactive INT,
	p_remarks VARCHAR(2000),
  	p_createdDate varchar(10),
    p_startDate VARCHAR(7),
    p_startTime VARCHAR(4),
    p_endDate VARCHAR(7),
    p_endTime VARCHAR(4),
    p_ormURL VARCHAR(200),
    p_supportingDocsURL VARCHAR(200),
    p_coc_0_username varchar(10),
    p_coc_0_status VARCHAR(8),
    p_coc_0_comments VARCHAR(200),
    p_coc_0_date VARCHAR(7),
    p_coc_0_time VARCHAR(4),

    p_coc_1_username varchar(10),
    p_coc_1_status VARCHAR(8),
    p_coc_1_comments VARCHAR(200),
    p_coc_1_date VARCHAR(7),
    p_coc_1_time VARCHAR(4),

    p_coc_2_username varchar(10),
    p_coc_2_status VARCHAR(8),
    p_coc_2_comments VARCHAR(200),
    p_coc_2_date VARCHAR(7),
    p_coc_2_time VARCHAR(4),

    p_coc_3_username varchar(10),
    p_coc_3_status VARCHAR(8),
    p_coc_3_comments VARCHAR(200),
    p_coc_3_date VARCHAR(7),
    p_coc_3_time VARCHAR(4),

    p_coc_4_username varchar(10),
    p_coc_4_status VARCHAR(8),
    p_coc_4_comments VARCHAR(200),
    p_coc_4_date VARCHAR(7),
    p_coc_4_time VARCHAR(4),

    p_coc_5_username varchar(10),
    p_coc_5_status VARCHAR(8),
    p_coc_5_comments VARCHAR(200),
    p_coc_5_date VARCHAR(7),
    p_coc_5_time VARCHAR(4),

    p_coc_6_username varchar(10),
    p_coc_6_status VARCHAR(8),
    p_coc_6_comments VARCHAR(200),
    p_coc_6_date VARCHAR(7),
    p_coc_6_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET creator = p_creator,
    description = p_description,
    reference = p_reference,
    requestType = p_requestType,
    requestOther = p_requestOther,
    addr_careOf = p_addr_careOf,
    addr_street = p_addr_street,
    addr_city = p_addr_city,
    addr_state = p_addr_state,
    addr_zip = p_addr_zip,
    archiveactive = p_archiveactive,
    remarks = p_remarks,
    createdDate = p_createdDate,
    startDate = p_startDate,
    startTime = p_startTime,
    endDate = p_endDate,
    endTime = p_endTime,
    ormURL = p_ormURL,
    supportingDocsURL = p_supportingDocsURL,
    coc_0_username = p_coc_0_username,
    coc_0_status = p_coc_0_status,
    coc_0_comments = p_coc_0_comments,
    coc_0_date = p_coc_0_date,
    coc_0_time = p_coc_0_time,
    coc_1_username = p_coc_1_username,
    coc_1_status = p_coc_1_status,
    coc_1_comments = p_coc_1_comments,
    coc_1_date = p_coc_1_date,
    coc_1_time = p_coc_1_time,
    coc_2_username = p_coc_2_username,
    coc_2_status = p_coc_2_status,
    coc_2_comments = p_coc_2_comments,
    coc_2_date = p_coc_2_date,
    coc_2_time = p_coc_2_time,
    coc_3_username = p_coc_3_username,
    coc_3_status = p_coc_3_status,
    coc_3_comments = p_coc_3_comments,
    coc_3_date = p_coc_3_date,
    coc_3_time = p_coc_3_time,
    coc_4_username = p_coc_4_username,
    coc_4_status = p_coc_4_status,
    coc_4_comments = p_coc_4_comments,
    coc_4_date = p_coc_4_date,
    coc_4_time = p_coc_4_time,
    coc_5_username = p_coc_5_username,
    coc_5_status = p_coc_5_status,
    coc_5_comments = p_coc_5_comments,
    coc_5_date = p_coc_5_date,
    coc_5_time = p_coc_5_time,
    coc_6_username = p_coc_6_username,
    coc_6_status = p_coc_6_status,
    coc_6_comments = p_coc_6_comments,
    coc_6_date = p_coc_6_date,
    coc_6_time = p_coc_6_time
    WHERE chitNumber = p_chitNumber;
END $$



DROP PROCEDURE IF EXISTS viewChit$$
CREATE PROCEDURE viewChit(
	p_chitNumber INT
)
BEGIN
	SELECT * FROM Chit WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS getUsers$$
CREATE PROCEDURE getUsers()
BEGIN
	SELECT username FROM Leader;
END $$


DROP PROCEDURE IF EXISTS getMidshipmanTable$$
CREATE PROCEDURE getMidshipmanTable()
BEGIN
	SELECT alpha FROM Midshipman;
END $$

DROP procedure if exists getMidshipmen$$
CREATE PROCEDURE getMidshipmen()
BEGIN
	SELECT * FROM Leader WHERE level = "MID";
END $$


DROP PROCEDURE IF EXISTS `getPotentialCoC`$$
CREATE PROCEDURE `getPotentialCoC`(
p_company INT
)
BEGIN
SELECT DISTINCT
l.username, l.lastName, l.firstName, l.rank, m.alpha, m.company
    FROM Leader as l, Midshipman as m
    where
    (m.alpha = l.username and m.company = p_company and
    (l.rank = "MIDN 1/C" or
	l.rank = "MIDN 2/C" or
    l.rank = "MIDN ENS" or
    l.rank = "MIDN LTJG" or
    l.rank = "MIDN LT" or
    l.rank = "MIDN LCDR" or
    l.rank = "MIDN CDR" or
    l.rank = "MIDN CAPT"));
END $$


DROP PROCEDURE IF EXISTS getPotentialCoCOfficers$$
CREATE PROCEDURE getPotentialCoCOfficers()
BEGIN
SELECT DISTINCT
l.username, l.lastName, l.firstName, l.rank
    FROM Leader as l
    where
	l.level = "Officer";
END $$


DROP PROCEDURE IF EXISTS getPotentialCoCSELs$$
CREATE PROCEDURE getPotentialCoCSELs()
BEGIN
SELECT DISTINCT
l.username, l.lastName, l.firstName, l.rank
    FROM Leader as l
    where
	l.level = "SEL";
END $$


DROP PROCEDURE IF EXISTS action_coc0$$
CREATE PROCEDURE action_coc0(
	p_chitNumber INT,

    p_coc_0_status VARCHAR(8),
    p_coc_0_date VARCHAR(7),
    p_coc_0_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_0_status = p_coc_0_status,
		coc_0_date = p_coc_0_date,
        coc_0_time = p_coc_0_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS action_coc1$$
CREATE PROCEDURE action_coc1(
	p_chitNumber INT,

    p_coc_1_status VARCHAR(8),
    p_coc_1_date VARCHAR(7),
    p_coc_1_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_1_status = p_coc_1_status,
		coc_1_date = p_coc_1_date,
        coc_1_time = p_coc_1_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS action_coc2$$
CREATE PROCEDURE action_coc2(
	p_chitNumber INT,

    p_coc_2_status VARCHAR(8),
    p_coc_2_date VARCHAR(7),
    p_coc_2_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_2_status = p_coc_2_status,
		coc_2_date = p_coc_2_date,
        coc_2_time = p_coc_2_time
	WHERE chitNumber = p_chitNumber;
END $$



DROP PROCEDURE IF EXISTS action_coc3$$
CREATE PROCEDURE action_coc3(
	p_chitNumber INT,

    p_coc_3_status VARCHAR(8),
    p_coc_3_date VARCHAR(7),
    p_coc_3_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_3_status = p_coc_3_status,
		coc_3_date = p_coc_3_date,
        coc_3_time = p_coc_3_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS action_coc4 $$
CREATE PROCEDURE action_coc4(
	p_chitNumber INT,

    p_coc_4_status VARCHAR(8),
    p_coc_4_date VARCHAR(7),
    p_coc_4_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_4_status = p_coc_4_status,
		coc_4_date = p_coc_4_date,
        coc_4_time = p_coc_4_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS action_coc5$$
CREATE PROCEDURE action_coc5(
	p_chitNumber INT,

    p_coc_5_status VARCHAR(8),
    p_coc_5_date VARCHAR(7),
    p_coc_5_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_5_status = p_coc_5_status,
		coc_5_date = p_coc_5_date,
        coc_5_time = p_coc_5_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS action_coc6$$
CREATE PROCEDURE action_coc6(
	p_chitNumber INT,

    p_coc_6_status VARCHAR(8),
    p_coc_6_date VARCHAR(7),
    p_coc_6_time VARCHAR(4)
)
BEGIN
	UPDATE Chit
    SET coc_6_status = p_coc_6_status,
		coc_6_date = p_coc_6_date,
        coc_6_time = p_coc_6_time
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc0$$
CREATE PROCEDURE comment_coc0(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_0_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc1$$
CREATE PROCEDURE comment_coc1(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_1_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc2$$
CREATE PROCEDURE comment_coc2(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_2_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc3$$
CREATE PROCEDURE comment_coc3(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_3_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc4$$
CREATE PROCEDURE comment_coc4(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_4_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$



DROP PROCEDURE IF EXISTS comment_coc5$$
CREATE PROCEDURE comment_coc5(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_5_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS comment_coc6$$
CREATE PROCEDURE comment_coc6(
	p_chitNumber INT,
    p_comments VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET coc_6_comments = p_comments
	WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS getUserChits$$
CREATE PROCEDURE getUserChits(
	p_creator varchar(10)
)
BEGIN
	SELECT * FROM Chit WHERE
    archiveactive = 0 AND
    creator = p_creator
    ORDER BY chitNumber DESC;
END $$


DROP PROCEDURE IF EXISTS getSubordinateChits$$
CREATE PROCEDURE getSubordinateChits(
	p_coc varchar(10)
)
BEGIN
	SELECT Chit.*, Leader.* FROM Chit, Leader WHERE
    Leader.username = Chit.creator AND
    archiveactive = 0 AND
    (coc_0_username = p_coc or
    coc_1_username = p_coc or
    coc_2_username = p_coc or
    coc_3_username = p_coc or
    coc_4_username = p_coc or
    coc_5_username = p_coc or
    coc_6_username = p_coc)
    ORDER BY chitNumber DESC;
END $$


DROP PROCEDURE IF EXISTS getUserArchivedChits$$
CREATE PROCEDURE getUserArchivedChits(
	p_creator varchar(10)
)
BEGIN
	SELECT * FROM Chit WHERE
    archiveactive = 1 AND
    creator = p_creator
    ORDER BY chitNumber DESC;
END $$


DROP PROCEDURE IF EXISTS getSubordinateArchivedChits$$
CREATE PROCEDURE getSubordinateArchivedChits(
	p_coc varchar(10)
)
BEGIN
	SELECT Chit.*, Leader.* FROM Chit, Leader WHERE
    username = creator AND
    archiveactive = 1 AND
    (coc_0_username = p_coc or
    coc_1_username = p_coc or
    coc_2_username = p_coc or
    coc_3_username = p_coc or
    coc_4_username = p_coc or
    coc_5_username = p_coc or
    coc_6_username = p_coc)
    ORDER BY chitNumber DESC;
END $$


DROP PROCEDURE IF EXISTS getActiveORMChitsCompany$$
CREATE PROCEDURE getActiveORMChitsCompany(
	p_company INT
)
BEGIN
	SELECT Chit.*, Leader.*, Midshipman.* FROM Chit, Leader, Midshipman WHERE
    username = creator AND
    creator = alpha AND
    Midshipman.company = p_company AND
    archiveactive = 0 AND
	ormURL is not null
    ORDER BY chitNumber DESC;
END $$


DROP PROCEDURE IF EXISTS getArchivedORMChitsCompany$$
CREATE PROCEDURE getArchivedORMChitsCompany(
	p_company INT
)
BEGIN
	SELECT Chit.*, Leader.*, Midshipman.* FROM Chit, Leader, Midshipman WHERE
     username = creator AND
    creator = alpha AND
    Midshipman.company = p_company AND
    archiveactive = 1 AND
	ormURL is not null
    ORDER BY chitNumber DESC;
END $$




DROP PROCEDURE IF EXISTS deleteChit$$
CREATE PROCEDURE deleteChit(
	p_chitNumber INT
)
BEGIN
	UPDATE Chit
    SET archiveactive = 1
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS restoreChit$$
CREATE PROCEDURE restoreChit(
	p_chitNumber INT
)
BEGIN
	UPDATE Chit
    SET archiveactive = 0
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS getAdmins$$
CREATE PROCEDURE getAdmins()
BEGIN
	SELECT DISTINCT auth_access.user, auth_access.access, auth_access.value, Leader.* from auth_access, Leader where auth_access.user = Leader.username and auth_access.access = "admin" GROUP BY (auth_access.user);
END $$



DROP PROCEDURE IF EXISTS getStaff$$
CREATE PROCEDURE getStaff()
BEGIN
	SELECT * FROM Leader WHERE level = "Officer" or level = "SEL";
END $$


DROP PROCEDURE IF EXISTS getMISLOs$$
CREATE PROCEDURE getMISLOs()
BEGIN
	SELECT DISTINCT auth_access.user, auth_access.access, auth_access.value, Leader.* from auth_access, Leader where auth_access.user = Leader.username and auth_access.access = "MISLO" GROUP BY (auth_access.user);
END $$

DROP PROCEDURE IF EXISTS getSafeties$$
CREATE PROCEDURE getSafeties()
BEGIN
	SELECT DISTINCT auth_access.user, auth_access.access, auth_access.value, Leader.* from auth_access, Leader where auth_access.user = Leader.username and auth_access.access = "safety" GROUP BY (auth_access.user);
END $$


DROP PROCEDURE IF EXISTS getCompleteMids$$
CREATE PROCEDURE getCompleteMids()
BEGIN
	SELECT Leader.*, Midshipman.* FROM Leader, Midshipman WHERE Leader.username = Midshipman.alpha AND `level` = "MID";
END $$



DROP PROCEDURE IF EXISTS getInCompleteMids$$
CREATE PROCEDURE getInCompleteMids()
BEGIN
	SELECT Leader.* FROM Leader WHERE Leader.level = "MID" and Leader.accesslevel != "MISLO" and Leader.accesslevel != "safety" and Leader.accesslevel != "admin" and Leader.username NOT IN (SELECT Midshipman.alpha FROM Midshipman);
END $$


DROP PROCEDURE IF EXISTS getCompany$$
CREATE PROCEDURE getCompany(
p_company INT
)
BEGIN
	SELECT Leader.*, Midshipman.* FROM Leader, Midshipman WHERE username = alpha AND Midshipman.company = p_company;
END $$


DROP PROCEDURE IF EXISTS getNonAdmins$$
CREATE PROCEDURE getNonAdmins()
BEGIN
	SELECT * FROM Leader WHERE accesslevel = "user";
END $$


DROP PROCEDURE IF EXISTS designateAdmin$$
CREATE PROCEDURE designateAdmin(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "admin"
    WHERE username = p_username;
END $$


DROP PROCEDURE IF EXISTS designateMISLO$$
CREATE PROCEDURE designateMISLO(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "MISLO"
    WHERE username = p_username;
END $$


DROP PROCEDURE IF EXISTS designateSafety$$
CREATE PROCEDURE designateSafety(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "safety"
    WHERE username = p_username;
END $$



DROP PROCEDURE IF EXISTS removeAdmin$$
CREATE PROCEDURE removeAdmin(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "user"
    WHERE username = p_username;
END $$

DROP PROCEDURE IF EXISTS removeMISLO$$
CREATE PROCEDURE removeMISLO(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "user"
    WHERE username = p_username;
END $$


DROP PROCEDURE IF EXISTS removeSafety$$
CREATE PROCEDURE removeSafety(
	p_username varchar(10)
)
BEGIN
	UPDATE Leader
    SET accesslevel = "user"
    WHERE username = p_username;
END $$




DROP PROCEDURE IF EXISTS addORM$$
CREATE PROCEDURE addORM(
	p_chitNumber INT,
    p_ormURL VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET ormURL = p_ormURL
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS removeORM$$
CREATE PROCEDURE removeORM(
	p_chitNumber INT
)
BEGIN
	UPDATE Chit
    SET ormURL = NULL
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS addDOCS$$
CREATE PROCEDURE addDOCS(
	p_chitNumber INT,
    p_supportingDocsURL VARCHAR(200)
)
BEGIN
	UPDATE Chit
    SET supportingDocsURL = p_supportingDocsURL
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS removeDOCS$$
CREATE PROCEDURE removeDOCS(
	p_chitNumber INT
)
BEGIN
	UPDATE Chit
    SET supportingDocsURL = NULL
    WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS getActiveChits$$
CREATE PROCEDURE getActiveChits()
BEGIN
	SELECT Chit.*, Midshipman.*, Leader.* FROM Chit, Midshipman, Leader WHERE creator = username AND username = alpha and Chit.archiveactive = 0;
END $$


DROP PROCEDURE IF EXISTS getArchivedChits$$
CREATE PROCEDURE getArchivedChits()
BEGIN
	SELECT Chit.*, Midshipman.*, Leader.* FROM Chit, Midshipman, Leader WHERE creator = username AND username = alpha and Chit.archiveactive = 1;
END $$


DROP PROCEDURE IF EXISTS deleteUser$$
CREATE PROCEDURE deleteUser(
	p_username varchar(10)
)
BEGIN
    DELETE FROM Leader WHERE username = p_username;
END $$


DROP PROCEDURE IF EXISTS permanentlyDeleteChit$$
CREATE PROCEDURE permanentlyDeleteChit(
	p_chitNumber INT
)
BEGIN
    DELETE FROM Chit WHERE chitNumber = p_chitNumber;
END $$


DROP PROCEDURE IF EXISTS blastChitsCompany$$
CREATE PROCEDURE blastChitsCompany(
	p_company INT
)
BEGIN
    DELETE FROM Chit where creator in (SELECT alpha FROM Midshipman WHERE company = p_company);
END $$


DROP PROCEDURE IF EXISTS blastChits$$
CREATE PROCEDURE blastChits()
BEGIN
    TRUNCATE TABLE Chit;
END $$


DROP PROCEDURE IF EXISTS getNumUsers$$
CREATE PROCEDURE getNumUsers()
BEGIN
    SELECT COUNT(*) as 'count' FROM Leader;
END $$


DROP PROCEDURE IF EXISTS getNumMids$$
CREATE PROCEDURE getNumMids()
BEGIN
    SELECT COUNT(*) as 'count' FROM Leader where level = 'MID';
END $$


DROP PROCEDURE IF EXISTS getNumTotalChits$$
CREATE PROCEDURE getNumTotalChits()
BEGIN
    SELECT COUNT(*) as 'count' FROM Chit;
END $$


DROP PROCEDURE IF EXISTS getNumActiveChits$$
CREATE PROCEDURE getNumActiveChits()
BEGIN
    SELECT COUNT(*) as 'count' FROM Chit where archiveactive = 0;
END $$


DROP PROCEDURE IF EXISTS getNumCompanies$$
CREATE PROCEDURE getNumCompanies()
BEGIN
    SELECT COUNT(DISTINCT company) as 'count' FROM Midshipman;
END $$



DROP PROCEDURE IF EXISTS getNumBigOs$$
CREATE PROCEDURE getNumBigOs()
BEGIN
    SELECT COUNT(*) as 'count' FROM Leader where rank = "CDR" or rank = "CAPT" or rank = "Col" or rank = "LtCol";
END $$


DROP PROCEDURE IF EXISTS getNumOfficers$$
CREATE PROCEDURE getNumOfficers()
BEGIN
    SELECT COUNT(*) as 'count' FROM Leader where level = "Officer";
END $$


DROP PROCEDURE IF EXISTS getNumSELs$$
CREATE PROCEDURE getNumSELs()
BEGIN
    SELECT COUNT(*) as 'count' FROM Leader where level = "SEL";
END $$

DROP PROCEDURE IF EXISTS getSubordinates$$
CREATE PROCEDURE getSubordinates(
	p_coc varchar(10)
)
BEGIN
	SELECT Leader.*, Midshipman.* FROM Leader, Midshipman WHERE
    Leader.username = Midshipman.alpha AND
    (coc_0 = p_coc or
    coc_1 = p_coc or
    coc_2 = p_coc or
    coc_3 = p_coc or
    coc_4 = p_coc or
    coc_5 = p_coc or
    coc_6 = p_coc);
END $$

DELIMITER ;

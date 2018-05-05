DROP TABLE IF EXISTS `Rates`;
CREATE TABLE Rates(
	rate VARCHAR(10) primary key 
);

INSERT INTO Rates (rate) values ('ABC'), ('ACC'), ('ADC'), ('AEC'), ('AGC'), ('AMC'), ('AOC'), ('ASC'), ('ATC'), ('AWC'), ('AZC'), ('PRC'), ('BUC'), ('CEC'), ('CMC'), ('EAC'), ('EOC'), ('SWC'), ('UTC'), ('HMC'), ('BMC'), ('CSC'), ('CTIC'), ('CTMC'), ('CTNC'), ('CTRC'), ('CTTC'), ('EODC'), ('ETC'), ('FCC'), ('FTC'), ('GMC'),  
('ISC'), ('ITC'), ('LNC'), ('LSC'), ('MAC'), ('MCC'), ('MNC'), ('MTC'), ('MUC'), ('NCC'), ('OSC'), ('PSC'), ('QMC'), ('RPC'), ('SBC'), ('SHC'), ('SOC'), ('STC'), ('YNC'), ('DCC'), ('EMC'), ('ENC'), ('GSC'), ('HTC'), ('ICC'), ('MMC'), ('MRC'), ('NDC'), ('ABCS'), ('ACCS'), ('ADCS'), ('AECS'), ('AGCS'),
('AMCS'), ('AOCS'), ('ASCS'), ('ATCS'), ('AWCS'), ('AZCS'), ('PRCS'), ('BUCS'), ('CECS'), ('CMCS'), ('EACS'), ('EOCS'), ('SWCS'), ('UTCS'), ('HMCS'), ('BMCS'), ('CSCS'), ('CTICS'), ('CTMCS'), ('CTNCS'), ('CTRCS'), ('CTTCS'), ('EODCS'), ('ETCS'), ('FCCS'), ('FTCS'), ('GMCS'), ('ISCS'), ('ITCS'), ('LNCS'), ('LSCS'), ('MACS'), ('MCCS'),
('MNCS'), ('MTCS'), ('MUCS'), ('NCCS'), ('OSCS'), ('PSCS'), ('QMCS'), ('RPCS'), ('SBCS'), ('SHCS'), ('SOCS'), ('STCS'), ('YNCS'), ('DCCS'), ('EMCS'), ('ENCS'), ('GSCS'), ('HTCS'), ('ICCS'), ('MMCS'), ('MRCS'), ('NDCS'); 


ALTER TABLE `Leader` DROP COLUMN salt;

ALTER TABLE `Leader` DROP COLUMN accesslevel;

ALTER TABLE `Leader` DROP COLUMN hashedPassword;

ALTER TABLE `Midshipman` ADD coc_7 VARCHAR(10) NULL AFTER coc_6;
ALTER TABLE `Midshipman` ADD FOREIGN KEY (coc_7) REFERENCES Leader(username);

ALTER TABLE `Midshipman` ADD coc_8 VARCHAR(10) NULL AFTER coc_7;
ALTER TABLE `Midshipman` ADD FOREIGN KEY (coc_8) REFERENCES Leader(username);

ALTER TABLE `Chit` MODIFY coc_0_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_1_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_2_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_3_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_4_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_5_status varchar(20);
ALTER TABLE `Chit` MODIFY coc_6_status varchar(20);



ALTER TABLE `Chit` ADD coc_7_username varchar(10) NULL AFTER coc_6_time;
ALTER TABLE `Chit` ADD FOREIGN KEY (coc_7_username) REFERENCES Leader(username);
ALTER TABLE `Chit` ADD coc_7_status varchar(20) AFTER coc_7_username;
ALTER TABLE `Chit` ADD coc_7_comments varchar(200) AFTER coc_7_status;
ALTER TABLE `Chit` ADD coc_7_date varchar(7) AFTER coc_7_comments;
ALTER TABLE `Chit` ADD coc_7_time varchar(4) AFTER coc_7_date;

ALTER TABLE `Chit` ADD coc_8_username varchar(10) NULL AFTER coc_7_time;
ALTER TABLE `Chit` ADD FOREIGN KEY (coc_8_username) REFERENCES Leader(username);
ALTER TABLE `Chit` ADD coc_8_status varchar(20) AFTER coc_8_username;
ALTER TABLE `Chit` ADD coc_8_comments varchar(200) AFTER coc_8_status;
ALTER TABLE `Chit` ADD coc_8_date varchar(7) AFTER coc_8_comments;
ALTER TABLE `Chit` ADD coc_8_time varchar(4) AFTER coc_8_date;

INSERT INTO auth_access values
('m194020', 'level', 'MID'),
('m194020', 'admin', 'admin'),
('m194020', 'admin', 'MISLO'),
('m194020', 'admin', 'safety'),
('m194020', 'site', 'become'),
('m194020', 'admin', 'become');

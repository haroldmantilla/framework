DROP TABLE IF EXISTS `Rates`;
CREATE TABLE Rates(
	rate VARCHAR(10) primary key
);

INSERT INTO Rates (rate) values ('CMC'), ('ABCM'), ('ACCM'), ('ADCM'), ('AECM'), ('AGCM'),
('AMCM'), ('AOCM'), ('ASCM'), ('ATCM'), ('AWCM'), ('AZCM'), ('PRCM'), ('BUCM'), ('CECM'), ('CMCM'), ('EACM'), ('EOCM'), ('SWCM'), ('UTCM'), ('HMCM'), ('BMCM'), ('CMCM'), ('CTICM'), ('CTMCM'), ('CTNCM'), ('CTRCM'), ('CTTCM'), ('EODCM'), ('ETCM'), ('FCCM'), ('FTCM'), ('GMCM'), ('ISCM'), ('ITCM'), ('LNCM'), ('LSCM'), ('MACM'), ('MCCM'),
('MNCM'), ('MTCM'), ('MUCM'), ('NCCM'), ('OSCM'), ('PSCM'), ('QMCM'), ('RPCM'), ('SBCM'), ('SHCM'), ('SOCM'), ('STCM'), ('YNCM'), ('DCCM'), ('EMCM'), ('ENCM'), ('GSCM'), ('HTCM'), ('ICCM'), ('MMCM'), ('MRCM'), ('NDCM');


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

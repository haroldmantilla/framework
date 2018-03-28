###############################################################################
## Default MySQL tables for autentication purposes within template

# Database configuration for use with this authentication script
DROP TABLE IF EXISTS auth_api;
DROP TABLE IF EXISTS auth_access;
DROP TABLE IF EXISTS auth_session;
DROP TABLE IF EXISTS auth_user;
CREATE TABLE `auth_user` (
  `user` VARCHAR(45) NOT NULL,
  `fullname` VARCHAR(250) NULL,
  `first` VARCHAR(250) NULL,
  `last` VARCHAR(250) NULL,
  `department` VARCHAR(250) NULL,
  `session` TEXT NULL,
  `lastlogin` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT PK_auth_user PRIMARY KEY (user)
);

# Store Session IDs of successfully logged on instances
DROP TABLE IF EXISTS auth_session;
CREATE TABLE auth_session (
 `user` VARCHAR(45) NOT NULL,
 `id` VARCHAR(96) NOT NULL,
 `lastvisit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT PK_auth_session PRIMARY KEY (id),
 CONSTRAINT FK_auth_session_user FOREIGN KEY(user)
  REFERENCES auth_user (user)
  ON DELETE CASCADE ON UPDATE CASCADE
);

# Store any specific accesses this user has beyond being a simple student/instructor
DROP TABLE IF EXISTS auth_access;
CREATE TABLE `auth_access` (
  `user` VARCHAR(45) NOT NULL,
  `access` VARCHAR(250) NOT NULL,
  `value` VARCHAR(250) NOT NULL,
  CONSTRAINT PK_auth_access PRIMARY KEY (user, access, value),
  CONSTRAINT FK_auth_access_user FOREIGN KEY(user)
   REFERENCES auth_user (user)
   ON DELETE CASCADE ON UPDATE CASCADE
);

# API Key table
DROP TABLE IF EXISTS auth_api;
CREATE TABLE `auth_api` (
  `user` VARCHAR(45) NOT NULL,
  `apikey` VARCHAR(99) NOT NULL,
  `expires` DATE DEFAULT "2099-01-01",
  CONSTRAINT PK_auth_api PRIMARY KEY (user),
  CONSTRAINT FK_auth_api_user FOREIGN KEY(user)
   REFERENCES auth_user (user)
   ON DELETE CASCADE ON UPDATE CASCADE
);

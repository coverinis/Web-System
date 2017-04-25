/*
 *======================================================================================================================================
 * SCRIPT v.32
 *======================================================================================================================================
 */

/*
 * FILE          : EMS_Database.sql
 * PROJECT       : INFO2030 - EMS-PSS
 * PROGRAMMER    : Justin Hergott, Zach Walters, Bobby Vu, Shawn Coverini
 * FIRST VERSION : 2017-04-25
 * DESCRIPTION   : SQL database schema, triggers, procedures, and data.
 */
 
/*
 *======================================================================================================================================
 * DATABASE
 *======================================================================================================================================
 */

DROP DATABASE IF EXISTS ems_pss;
CREATE DATABASE ems_pss;

USE ems_pss;

/*
 *======================================================================================================================================
 * TABLES
 *======================================================================================================================================
 */

-- Employee table
CREATE TABLE employee
(
	employeeID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    firstName NVARCHAR(50),
    lastName NVARCHAR(50),
    socialInsuranceNumber CHAR(9),
    dateOfBirth DATE,
    incomplete BOOL NOT NULL,
    PRIMARY KEY(employeeID)
);

-- Employee Type Table
CREATE TABLE employeeType
(
	employeeTypeID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    employeeTypeName NVARCHAR(50),
    PRIMARY KEY(employeeTypeID)
);

-- Company table
CREATE TABLE company
(
	companyID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    companyName NVARCHAR(50),
    PRIMARY KEY(companyID)
);

-- User Type table
CREATE TABLE userType
(
	userTypeID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    userTypeName NVARCHAR(20),
    securityLevel TINYINT UNSIGNED,
    PRIMARY KEY(userTypeID)
);

-- Users table
CREATE TABLE users
(
	userID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    userTypeID INT UNSIGNED NOT NULL,
    pass VARCHAR(26),
    firstName NVARCHAR(50),
	lastName NVARCHAR(50),
    active BOOL NOT NULL,
    PRIMARY KEY(userID),
    FOREIGN KEY(userTypeID) REFERENCES userType(userTypeID)
);

-- Work Term table
CREATE TABLE workTerm
(
	workTermID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    employeeID INT UNSIGNED NOT NULL,
    companyID INT UNSIGNED NOT NULL,
    employeeTypeID INT UNSIGNED NOT NULL,
    reasonForLeaving VARCHAR(300),
    dateOfHire DATE,
    dateOfTermination DATE,
    pay DECIMAL(8,2),
    incomplete BOOL NOT NULL,
    PRIMARY KEY(workTermID),
    FOREIGN KEY(employeeID) REFERENCES employee(employeeID),
    FOREIGN KEY(companyID) REFERENCES company(companyID),
    FOREIGN KEY(employeeTypeID) REFERENCES employeeType(employeeTypeID)
);

-- Users table
CREATE TABLE timeCard
(
	timeCardID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    workTermID INT UNSIGNED NOT NULL,
    cardDate DATE,
	sunHours INT UNSIGNED,
    monHours INT UNSIGNED,
    tueHours INT UNSIGNED,
    wedHours INT UNSIGNED,
    thuHours INT UNSIGNED,
    friHours INT UNSIGNED,
    satHours INT UNSIGNED,
    piecesComplete INT UNSIGNED,
    sunPieces INT UNSIGNED,
    monPieces INT UNSIGNED,
    tuePieces INT UNSIGNED,
    wedPieces INT UNSIGNED,
    thuPieces INT UNSIGNED,
    friPieces INT UNSIGNED,
    satPieces INT UNSIGNED,
    PRIMARY KEY(timeCardID),
    FOREIGN KEY(workTermID) REFERENCES workTerm(workTermID)
);

-- Audit table
CREATE TABLE audit
(
	auditID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    userID INT UNSIGNED,
    eventType CHAR(6),
    attributeName VARCHAR(30),
    oldValue NVARCHAR(300),
    newValue NVARCHAR(300),
    eventTimestamp TIMESTAMP,
    PRIMARY KEY(auditID)
);

-- Employee Audit table
CREATE TABLE employeeAudit
(
	employeeID INT UNSIGNED NOT NULL,
    auditID INT UNSIGNED NOT NULL,
    FOREIGN KEY(auditID) REFERENCES audit(auditID)
);

-- Time Card Audit table
CREATE TABLE timeCardAudit
(
	timeCardID INT UNSIGNED NOT NULL,
    auditID INT UNSIGNED NOT NULL,
    FOREIGN KEY(auditID) REFERENCES audit(auditID)
);

-- Work Term Audit table
CREATE TABLE workTermAudit
(
	workTermID INT UNSIGNED NOT NULL,
    FOREIGN KEY(auditID) REFERENCES audit(auditID)
);

-- User Audit table
CREATE TABLE userAudit
(
	userID INT UNSIGNED NOT NULL,
    auditID INT UNSIGNED NOT NULL,
    FOREIGN KEY(userID) REFERENCES users(userID),
    FOREIGN KEY(auditID) REFERENCES audit(auditID)
);

/*
 *======================================================================================================================================
 * VIEWS
 *======================================================================================================================================
 */

-- Employees view
CREATE OR REPLACE VIEW `employeeWorkterm` AS
SELECT DISTINCT
	`workterm`.`workTermID`,
	`employee`.`employeeID`,
	`employee`.`firstName`,
    `employee`.`lastName`,
    `company`.`companyName`,
    `workterm`.`dateOfHire`,
    `workterm`.`dateOfTermination`,
    `employee`.`socialInsuranceNumber`,
	`workterm`.`pay`,
    `timecard`.`piecesComplete`,
    `employee`.`dateOfBirth`,
    `employeetype`.`employeeTypeName`,
	`workterm`.`reasonForLeaving`
FROM
	`workterm`
	LEFT JOIN `employee` 
	ON `workterm`.`employeeID` = `employee`.`employeeID`
	LEFT JOIN `employeetype` 
	ON `workterm`.`employeeTypeID` = `employeetype`.`employeeTypeID`
	LEFT JOIN `company` 
	ON `workterm`.`companyID` = `company`.`companyID`
    LEFT JOIN `timecard` 
	ON `workterm`.`workTermID` = `timecard`.`workTermID`
ORDER BY `employee`.`employeeID`;

-- View for timecard
CREATE OR REPLACE VIEW employeeTimeCardInfo AS
SELECT 
    workterm.workTermID,
    workterm.employeeID,
    timecard.cardDate,
    timecard.sunHours,
    timecard.monHours,
    timecard.tueHours,
    timecard.wedHours,
    timecard.thuHours,
    timecard.friHours,
    timecard.satHours,
    timecard.sunPieces,
    timecard.monPieces,
    timecard.tuePieces,
    timecard.wedPieces,
    timecard.thuPieces,
    timecard.friPieces,
    timecard.satPieces
FROM 
    timecard
    INNER JOIN workterm ON workterm.worktermID = timecard.worktermID;

/*
 *======================================================================================================================================
 * Seniority Report
 *======================================================================================================================================
 */

-- Seniority Report
CREATE OR REPLACE VIEW `seniorityreport` AS 
select 
	concat(`employee`.`lastName`,', ',`employee`.`firstName`) AS `Employee Name`,
    `employee`.`socialInsuranceNumber` AS `SIN`,
    `employeetype`.`employeeTypeName` AS `Type`,
    `workterm`.`dateOfHire` AS `Date of Hire`,
    `company`.`companyID` AS `Company`,
    if(((`workterm`.`dateOfTermination` is not null) and (`workterm`.`dateOfTermination` < curdate())),if((((to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)) / 365) >= 1),concat(round(((to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)) / 365),0),' years'),if((((to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)) / 12) >= 1),concat(round(((to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)) / (365 / 12)),0),' months'),concat(round((to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)),0),' days'))),if((((to_days(curdate()) - to_days(`workterm`.`dateOfHire`)) / 365) >= 1),concat(round(((to_days(curdate()) - to_days(`workterm`.`dateOfHire`)) / 365),0),' years'),if((((to_days(curdate()) - to_days(`workterm`.`dateOfHire`)) / 12) >= 1),concat(round(((to_days(curdate()) - to_days(`workterm`.`dateOfHire`)) / (365 / 12)),0),' months'),concat(round((to_days(curdate()) - to_days(`workterm`.`dateOfHire`)),0),' days')))) AS `Years of Service`,
    if(((`workterm`.`dateOfTermination` is not null) and (`workterm`.`dateOfTermination` < curdate())),(to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)),(to_days(curdate()) - to_days(`workterm`.`dateOfHire`))) AS `Days` 
from 
	(((`workterm` 
		left join `employee` on((`workterm`.`employeeID` = `employee`.`employeeID`))) 
		left join `employeetype` on((`workterm`.`employeeTypeID` = `employeetype`.`employeeTypeID`))) 
        left join `company` on((`workterm`.`companyID` = `company`.`companyID`))) 
        order by `company`.`companyID`,if(((`workterm`.`dateOfTermination` is not null) and (`workterm`.`dateOfTermination` < curdate())),(to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)),(to_days(curdate()) - to_days(`workterm`.`dateOfHire`))) desc;

/*
 * PROCEDURE   : getSeniorityReport
 * DESCRIPTION : Return seniority report of  the company requested
 * PARAMETERS  : Company VARCHAR(50) : Company name to search for
 * RETURNS     : Seniority table
 */
DROP procedure IF EXISTS `getSeniorityReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getSeniorityReport` (IN Company VARCHAR(50))
getSeniorityReport:BEGIN
-- Variables
DECLARE ID INT;
SET ID = 0;
	IF NOT EXISTS(SELECT * FROM `company` WHERE `company`.`companyName`=Company)
		THEN LEAVE getSeniorityReport;
	ELSE
		SET ID = (SELECT `company`.`companyID` FROM `company` WHERE `company`.`companyName`=Company);
	END IF;
	SELECT `Employee Name`, `SIN`, `Type`, `Date of Hire`, `Years of Service` FROM `seniorityreport` WHERE `seniorityreport`.`Company`=ID
    ORDER BY `Days` DESC,`Employee Name`;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Weekly Hours Worked Report
 *======================================================================================================================================
 */

-- Weekly Hours Worked Report
CREATE OR REPLACE VIEW `weeklyhoursworkedreport` AS 
select 
	concat(`employee`.`lastName`,', ',`employee`.`firstName`) AS `Employee Name`,
    `employee`.`socialInsuranceNumber` AS `SIN`,
    ((((((`timecard`.`sunHours` + `timecard`.`monHours`) + `timecard`.`tueHours`) + `timecard`.`wedHours`) + `timecard`.`thuHours`) + `timecard`.`friHours`) + `timecard`.`satHours`) AS `Hours`,
    `workterm`.`companyID` AS `Company`,
    `employeetype`.`employeeTypeID` AS `Employee ID`,
    `timecard`.`cardDate` AS `Card Date` 
from 
	((((`employee` 
    left join `workterm` on((`workterm`.`employeeID` = `employee`.`employeeID`))) 
    left join `employeetype` on((`workterm`.`employeeTypeID` = `employeetype`.`employeeTypeID`))) 
    left join `company` on((`workterm`.`companyID` = `company`.`companyID`))) 
    left join `timecard` on((`workterm`.`workTermID` = `timecard`.`workTermID`))) 
    order by `company`.`companyID`,`timecard`.`cardDate`;

/*
 * PROCEDURE   : getWeeklyHoursWorkedReport
 * DESCRIPTION : Return weekly hours worked report of the company requested for the
 *               specified date.
 * PARAMETERS  : Company VARCHAR(50) : Company name to search for
 *               CardDate DATE       : Date of payroll 
 * RETURNS     : WeeklyHoursWorked table
 */
USE `ems_pss`;
DROP procedure IF EXISTS `getWeeklyHoursWorkedReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getWeeklyHoursWorkedReport` (IN Company VARCHAR(50),IN CardDate DATE)
getWeeklyHoursWorkedReport:BEGIN

-- Variables
DECLARE ID INT;

SET ID = 0;
	IF NOT EXISTS(SELECT * FROM `company` WHERE `company`.`companyName`=Company)
		THEN LEAVE getWeeklyHoursWorkedReport;
	ELSE
		SET ID = (SELECT `company`.`companyID` FROM `company` WHERE `company`.`companyName`=Company);
	END IF;
    
	SELECT 
		`Employee Name`, 
		`SIN`, 
        `Hours`, 
        (SELECT `employeetype`.`employeeTypeName` FROM `employeetype` WHERE `employeetype`.`employeeTypeID`=`Employee ID`) AS 'Employee Type' 
	FROM `weeklyhoursworkedreport`
    WHERE `weeklyhoursworkedreport`.`Company`=ID AND `weeklyhoursworkedreport`.`Card Date`=CardDate
    ORDER BY `Employee ID`, `Employee Name`;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Payroll Report
 *======================================================================================================================================
 */

-- Payroll Report
CREATE OR REPLACE VIEW `payrollreport` AS 
select 
	concat(`employee`.`lastName`,', ',`employee`.`firstName`) AS `Employee Name`,
    `employee`.`socialInsuranceNumber` AS `SIN`,
    ((((((`timecard`.`sunHours` + `timecard`.`monHours`) + `timecard`.`tueHours`) + `timecard`.`wedHours`) + `timecard`.`thuHours`) + `timecard`.`friHours`) + `timecard`.`satHours`) AS `Hours`,
    `workterm`.`pay` AS `Pay`,
    `workterm`.`companyID` AS `Company`,
    `employeetype`.`employeeTypeID` AS `Employee ID`,
    `timecard`.`cardDate` AS `Card Date`,
    `timecard`.`piecesComplete` AS `Pieces`,
    (to_days(`workterm`.`dateOfTermination`) - to_days(`workterm`.`dateOfHire`)) AS `Days`,
    `workterm`.`dateOfTermination` AS `Termination`
from 
	((((`workterm` 
    left join `employee` on((`workterm`.`employeeID` = `employee`.`employeeID`))) 
    left join `employeetype` on((`workterm`.`employeeTypeID` = `employeetype`.`employeeTypeID`))) 
    left join `company` on((`workterm`.`companyID` = `company`.`companyID`))) 
    left join `timecard` on((`workterm`.`workTermID` = `timecard`.`workTermID`))) 
    order by `company`.`companyID`,`timecard`.`cardDate`;

/*
 * PROCEDURE   : getPayrollReport
 * DESCRIPTION : Get company payroll for specified date
 * PARAMETERS  : Company VARCHAR(50) : Company name to search for
 *               CardDate DATE       : Date of payroll 
 * RETURNS     : Payroll table
 */
USE `ems_pss`;
DROP procedure IF EXISTS `getPayrollReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getPayrollReport` (IN Company VARCHAR(50),IN CardDate DATE)
getPayrollReport:BEGIN

-- Variables
DECLARE ID INT;

SET ID = 0;
SET @SIN = (SELECT `SIN` FROM payrollReport WHERE `payrollReport`.`Company`=(SELECT `companyID` FROM `company` 
				WHERE `company`.`companyName`=Company) AND `payrollReport`.`Card Date`=CardDate ORDER BY Pieces DESC LIMIT 1);
	IF NOT EXISTS(SELECT * FROM `company` WHERE `company`.`companyName`=Company)
		THEN LEAVE getPayrollReport;
	ELSE
		SET ID = (SELECT `company`.`companyID` FROM `company` WHERE `company`.`companyName`=Company);
	END IF;
    
	SELECT 
		`Employee Name`,
        `Hours`,
        (
        IF(
			`Employee ID`=1,ROUND(`Pay`/52,2),
		IF(
			`Employee ID`=2,IF(`Hours`>40,ROUND((`Pay`*40)+(`Pay`*(`Hours`-40)),2),ROUND(`Pay`*`Hours`,2)),
		IF(
			`Employee ID`=3,IF(`Hours`>=40,ROUND((`Pay`*`Pieces`)+150,2),ROUND(`Pay`*`Pieces`,2)),
		IF(
			`Employee ID`=4,ROUND(`Pay`*7/`Days`),0
		))))) AS 'Gross', 
        (SELECT `employeetype`.`employeeTypeName` FROM `employeetype` WHERE `employeetype`.`employeeTypeID`=`Employee ID`) 
				AS 'Employee Type',
        IF(`Employee ID`=1 AND `Hours`<37.5,'Not Full Work Week',IF(`Employee ID`=3 AND `SIN`=@SIN,'Most Productive',
        IF(`Employee ID`=4,CONCAT(DATEDIFF(`Termination`,`Card Date`),' days remaining '),
        IF(`Employee ID`=2 AND `Hours`>40,CONCAT(`Hours`-40,' hrs. Overtime'),'')))) AS 'Notes'
	FROM `payrollReport`
    WHERE `payrollReport`.`Company`=ID AND `payrollReport`.`Card Date`=CardDate
    ORDER BY `Employee ID`, `Employee Name`;
    
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Active/Inactive Employment Report
 *======================================================================================================================================
 */

-- Active Employment Report
CREATE OR REPLACE VIEW `activeemploymentreport` AS 
select distinct 
	concat(`employee`.`lastName`,', ',`employee`.`firstName`) AS `Employee Name`,
    `employeetype`.`employeeTypeName` AS `Type`,
    `workterm`.`dateOfHire` AS `Date of Hire`,
    `workterm`.`dateOfTermination` AS `Date of Termination`,
    `workterm`.`reasonForLeaving` AS `Reason for Leaving`,
    ((select ((((((sum(`timecard`.`sunHours`) + sum(`timecard`.`monHours`)) + sum(`timecard`.`tueHours`)) + sum(`timecard`.`wedHours`)) + sum(`timecard`.`thuHours`)) + sum(`timecard`.`friHours`)) + sum(`timecard`.`satHours`)) from `timecard` where (`timecard`.`workTermID` = `workterm`.`workTermID`)) / (select count(0) from `timecard` where (`timecard`.`workTermID` = `workterm`.`workTermID`))) AS `Avg. Hours`,
    `company`.`companyID` AS `Company` 
from 
	((((`workterm` 
    left join `employee` on((`workterm`.`employeeID` = `employee`.`employeeID`))) 
    left join `employeetype` on((`workterm`.`employeeTypeID` = `employeetype`.`employeeTypeID`))) 
    left join `company` on((`workterm`.`companyID` = `company`.`companyID`))) 
    left join `timecard` on((`workterm`.`workTermID` = `timecard`.`workTermID`))) 
    order by `Company`;

/*
 * PROCEDURE   : getActiveEmploymentReport
 * DESCRIPTION : Get company list of active employees
 * PARAMETERS  : Company VARCHAR(50) : Company name to search for
 * RETURNS     : ActiveEmployment table
 */
DROP procedure IF EXISTS `getActiveEmploymentReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getActiveEmploymentReport` (IN Company VARCHAR(50))
getActiveEmploymentReport:BEGIN
-- Variables
DECLARE ID INT;
SET ID = 0;
	IF NOT EXISTS(SELECT * FROM `company` WHERE `company`.`companyName`=Company)
		THEN LEAVE getActiveEmploymentReport;
	ELSE
		SET ID = (SELECT `company`.`companyID` FROM `company` WHERE `company`.`companyName`=Company);
	END IF;
	SELECT `Employee Name`, `Date of Hire`,`Avg. Hours`,`Type` FROM `activeEmploymentReport` WHERE `activeEmploymentReport`.`Company`=ID 
			AND (`Date of Termination` > CURDATE() OR `Date of Termination` IS NULL)
    ORDER BY `Type`,`Date of Hire`, `Employee Name` DESC;
END$$
DELIMITER ;

/*
 * PROCEDURE   : getInactiveEmploymentReport
 * DESCRIPTION : Get company list of inactive employees
 * PARAMETERS  : Company VARCHAR(50) : Company name to search for
 * RETURNS     : InactiveEmployment table
 */
DROP procedure IF EXISTS `getInactiveEmploymentReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getInactiveEmploymentReport` (IN Company VARCHAR(50))
getInactiveEmploymentReport:BEGIN
# Variables
DECLARE ID INT;
SET ID = 0;
	IF NOT EXISTS(SELECT * FROM `company` WHERE `company`.`companyName`=Company)
		THEN LEAVE getInactiveEmploymentReport;
	ELSE
		SET ID = (SELECT `company`.`companyID` FROM `company` WHERE `company`.`companyName`=Company);
	END IF;
	SELECT `Employee Name`,
    `Date of Hire` AS 'Hired',
    `Date of Termination` AS 'Terminated',
    `Type`, `Reason for Leaving` 
    FROM `activeEmploymentReport` 
    WHERE `activeEmploymentReport`.`Company`=ID AND (`Date of Termination` < CURDATE() AND `Date of Termination` IS NOT NULL)
    ORDER BY `Type`,`Date of Hire`, `Employee Name` DESC;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Audit Employee Report
 *======================================================================================================================================
 */

/*
 * PROCEDURE   : getAuditEmployeeReport
 * DESCRIPTION : Get audit data for employee
 * PARAMETERS  : Id INT       : EmployeeID
 *               NResults INT : Number of results to return
 * RETURNS     : EmployeeAudit table
 */
DROP procedure IF EXISTS `getAuditEmployeeReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getAuditEmployeeReport` (IN Id INT,IN NResults INT)
getAuditEmployeeReport:BEGIN
	SELECT *
    FROM audit
    WHERE auditID IN (SELECT auditID FROM employeeaudit WHERE employeeID=Id)
    ORDER BY auditID
    LIMIT NResults;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Audit Workterm Report
 *======================================================================================================================================
 */

/*
 * PROCEDURE   : getAuditWorktermReport
 * DESCRIPTION : Get audit data for workterm
 * PARAMETERS  : Id INT       : WorktermID
 *               NResults INT : Number of results to return
 * RETURNS     : WorktermAudit table
 */
DROP procedure IF EXISTS `getAuditWorktermReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getAuditWorktermReport` (IN Id INT,IN NResults INT)
getAuditWorktermReport:BEGIN
	SELECT *
    FROM audit
    WHERE auditID IN (SELECT auditID FROM worktermaudit WHERE workTermID=Id)
    ORDER BY auditID
    LIMIT NResults;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Audit Time Card Report
 *======================================================================================================================================
 */

/*
 * PROCEDURE   : getAuditTimeCardReport
 * DESCRIPTION : Get audit data for timecard
 * PARAMETERS  : Id INT       : Time Card ID
 *               NResults INT : Number of results to return
 * RETURNS     : TimeCardAudit table
 */
DROP procedure IF EXISTS `getAuditTimeCardReport`;
DELIMITER $$
USE `ems_pss`$$
CREATE PROCEDURE `getAuditTimeCardReport` (IN Id INT,IN NResults INT)
getAuditTimeCardReport:BEGIN
	SELECT *
    FROM audit
    WHERE auditID IN (SELECT auditID FROM timecardaudit WHERE timeCardID=Id)
    ORDER BY auditID
    LIMIT NResults;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Employee Trigger
 *======================================================================================================================================
 */

-- EmployeeUpdate
DROP TRIGGER IF EXISTS `EmployeeUpdate`;
DELIMITER $$
CREATE TRIGGER EmployeeUpdate 
    BEFORE UPDATE ON employee
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.employeeID;
	
    -- employeeID
	IF NEW.employeeID!=OLD.employeeID OR (NEW.employeeID IS NOT NULL AND OLD.employeeID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='employeeID',
		oldValue=OLD.employeeID,
		newValue=NEW.employeeID,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- firstName
	IF NEW.firstName!=OLD.firstName OR (NEW.firstName IS NOT NULL AND OLD.firstName IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='firstName',
		oldValue=OLD.firstName,
		newValue=NEW.firstName,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- lastName
	IF NEW.lastName!=OLD.lastName OR (NEW.lastName IS NOT NULL AND OLD.lastName IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='lastName',
		oldValue=OLD.lastName,
		newValue=NEW.lastName,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- socialInsuranceNumber
	IF NEW.socialInsuranceNumber!=OLD.socialInsuranceNumber 
	OR (NEW.socialInsuranceNumber IS NOT NULL AND OLD.socialInsuranceNumber IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='socialInsuranceNumber',
		oldValue=OLD.socialInsuranceNumber,
		newValue=NEW.socialInsuranceNumber,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- dateOfBirth
	IF NEW.dateOfBirth!=OLD.dateOfBirth OR (NEW.dateOfBirth IS NOT NULL AND OLD.dateOfBirth IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='dateOfBirth',
		oldValue=OLD.dateOfBirth,
		newValue=NEW.dateOfBirth,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- incomplete
	IF NEW.incomplete!=OLD.incomplete OR (NEW.incomplete IS NOT NULL AND OLD.incomplete IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='incomplete',
		oldValue=OLD.incomplete,
		newValue=NEW.incomplete,
		eventTimestamp = NOW();
        
        INSERT INTO employeeaudit
        SET
        employeeID=@ID,
        employeeaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
END$$
DELIMITER ;

-- EmployeeInsert
DROP TRIGGER IF EXISTS `EmployeeInsert`;
DELIMITER $$
CREATE TRIGGER EmployeeInsert 
    AFTER INSERT ON employee
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.employeeID;
    
	-- employeeID
	INSERT INTO audit
	SET 
		eventType ='insert',
		attributeName='employeeID',
		oldValue=NULL,
		newValue=NEW.employeeID,
		eventTimestamp = NOW();
    
	INSERT INTO employeeaudit
	SET
		employeeID=@ID,
		employeeaudit.auditID=(SELECT LAST_INSERT_ID());
END$$
DELIMITER ;

-- EmployeeDelete
DROP TRIGGER IF EXISTS `EmployeeDelete`;
DELIMITER $$
CREATE TRIGGER EmployeeDelete 
    BEFORE DELETE ON employee
    FOR EACH ROW 
BEGIN
	SET SQL_SAFE_UPDATES = 0;
	SET @ID = OLD.employeeID;
    
	-- employeeID
	INSERT INTO audit
	SET 
	eventType ='delete',
	attributeName='employeeID',
	oldValue=@ID,
	newValue=NULL,
	eventTimestamp = NOW();
    
	INSERT INTO employeeaudit
	SET
	employeeID=@ID,
	employeeaudit.auditID=(SELECT LAST_INSERT_ID());
    
    DELETE FROM timecard WHERE timecard.workTermID=(SELECT workTermID FROM workterm WHERE workterm.employeeID=@ID);
    DELETE FROM workterm WHERE workterm.employeeID=@ID;
END$$
DELIMITER ;

-- EmployeeDeleteAfter
DROP TRIGGER IF EXISTS `EmployeeDeleteAfter`;
DELIMITER $$
CREATE TRIGGER EmployeeDeleteAfter 
    AFTER DELETE ON employee
    FOR EACH ROW 
BEGIN
    SET SQL_SAFE_UPDATES = 1;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Timecard Trigger
 *======================================================================================================================================
 */
 
-- TimeCardUpdate
DROP TRIGGER IF EXISTS `TimeCardUpdate`;
DELIMITER $$
CREATE TRIGGER TimeCardUpdate 
    BEFORE UPDATE ON timecard
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.timeCardID;
    
	-- timeCardID
	IF NEW.timeCardID!=OLD.timeCardID OR (NEW.timeCardID IS NOT NULL AND OLD.timeCardID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='timeCardID',
		oldValue=OLD.timeCardID,
		newValue=NEW.timeCardID,
		eventTimestamp = NOW();
        
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- workTermID
	IF NEW.workTermID!=OLD.workTermID OR (NEW.workTermID IS NOT NULL AND OLD.workTermID IS NULL) THEN
    
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='workTermID',
		oldValue=OLD.workTermID,
		newValue=NEW.workTermID,
		eventTimestamp = NOW();
        
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- cardDate
	IF NEW.cardDate!=OLD.cardDate OR (NEW.cardDate IS NOT NULL AND OLD.cardDate IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='cardDate',
		oldValue=OLD.cardDate,
		newValue=NEW.cardDate,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- sunHours
	IF NEW.sunHours!=OLD.sunHours OR (NEW.sunHours IS NOT NULL AND OLD.sunHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='sunHours',
		oldValue=OLD.sunHours,
		newValue=NEW.sunHours,
		eventTimestamp = NOW();
        
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- monHours
	IF NEW.monHours!=OLD.monHours OR (NEW.monHours IS NOT NULL AND OLD.monHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='monHours',
		oldValue=OLD.monHours,
		newValue=NEW.monHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- tueHours
	IF NEW.tueHours!=OLD.tueHours OR (NEW.tueHours IS NOT NULL AND OLD.tueHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='tueHours',
		oldValue=OLD.tueHours,
		newValue=NEW.tueHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- wedHours
	IF NEW.wedHours!=OLD.wedHours OR (NEW.wedHours IS NOT NULL AND OLD.wedHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='wedHours',
		oldValue=OLD.wedHours,
		newValue=NEW.wedHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- thuHours
	IF NEW.thuHours!=OLD.thuHours OR (NEW.thuHours IS NOT NULL AND OLD.thuHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='thuHours',
		oldValue=OLD.thuHours,
		newValue=NEW.thuHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- friHours
	IF NEW.friHours!=OLD.friHours OR (NEW.friHours IS NOT NULL AND OLD.friHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='friHours',
		oldValue=OLD.friHours,
		newValue=NEW.friHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- satHours
	IF NEW.satHours!=OLD.satHours OR (NEW.satHours IS NOT NULL AND OLD.satHours IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='satHours',
		oldValue=OLD.satHours,
		newValue=NEW.satHours,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- piecesComplete
	IF NEW.piecesComplete!=OLD.piecesComplete OR (NEW.piecesComplete IS NOT NULL AND OLD.piecesComplete IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='piecesComplete',
		oldValue=OLD.piecesComplete,
		newValue=NEW.piecesComplete,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- sunPieces
	IF NEW.sunPieces!=OLD.sunPieces OR (NEW.sunPieces IS NOT NULL AND OLD.sunPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='sunPieces',
		oldValue=OLD.sunPieces,
		newValue=NEW.sunPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- monPieces
	IF NEW.monPieces!=OLD.monPieces OR (NEW.monPieces IS NOT NULL AND OLD.monPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='monPieces',
		oldValue=OLD.monPieces,
		newValue=NEW.monPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- tuePieces
	IF NEW.tuePieces!=OLD.tuePieces OR (NEW.tuePieces IS NOT NULL AND OLD.tuePieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='tuePieces',
		oldValue=OLD.tuePieces,
		newValue=NEW.tuePieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- wedPieces
	IF NEW.wedPieces!=OLD.wedPieces OR (NEW.wedPieces IS NOT NULL AND OLD.wedPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='wedPieces',
		oldValue=OLD.wedPieces,
		newValue=NEW.wedPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- thuPieces
	IF NEW.thuPieces!=OLD.thuPieces OR (NEW.thuPieces IS NOT NULL AND OLD.thuPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='thuPieces',
		oldValue=OLD.thuPieces,
		newValue=NEW.thuPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- friPieces
	IF NEW.friPieces!=OLD.friPieces OR (NEW.friPieces IS NOT NULL AND OLD.friPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='friPieces',
		oldValue=OLD.friPieces,
		newValue=NEW.friPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- satPieces
	IF NEW.satPieces!=OLD.satPieces OR (NEW.satPieces IS NOT NULL AND OLD.satPieces IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='satPieces',
		oldValue=OLD.satPieces,
		newValue=NEW.satPieces,
		eventTimestamp = NOW();
        INSERT INTO timecardaudit
        SET
        timeCardID=@ID,
        timecardaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
END$$
DELIMITER ;

-- TimeCardInsert
DROP TRIGGER IF EXISTS `TimeCardInsert`;
DELIMITER $$
CREATE TRIGGER TimeCardInsert 
    AFTER INSERT ON timecard
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.timeCardID;
    
	-- timeCardID
	INSERT INTO audit
	SET 
	eventType ='insert',
	attributeName='timeCardID',
	oldValue=NULL,
	newValue=NEW.timeCardID,
	eventTimestamp = NOW();
    
	INSERT INTO timecardaudit
	SET
	timeCardID=@ID,
	timecardaudit.auditID=(SELECT LAST_INSERT_ID());
END$$
DELIMITER ;

-- TimeCardInsertBefore
DROP TRIGGER IF EXISTS `TimeCardInsertBefore`;
DELIMITER $$
CREATE TRIGGER TimeCardInsertBefore 
    BEFORE INSERT ON timecard
    FOR EACH ROW 
BEGIN
    SET NEW.piecesComplete = NEW.sunPieces + NEW.monPieces + NEW.tuePieces + NEW.wedPieces + NEW.thuPieces + NEW.friPieces + NEW.satPieces;
END$$
DELIMITER ;

-- TimeCardDelete
DROP TRIGGER IF EXISTS `TimeCardDelete`;
DELIMITER $$
CREATE TRIGGER TimeCardDelete 
    BEFORE DELETE ON timecard
    FOR EACH ROW 
BEGIN
	SET SQL_SAFE_UPDATES = 0;

	SET @ID = OLD.timeCardID;
	
    -- timeCardID
	INSERT INTO audit
	SET 
	eventType ='delete',
	attributeName='timeCardID',
	oldValue=@ID,
	newValue=NULL,
	eventTimestamp = NOW();
	INSERT INTO timecardaudit
	SET
	timeCardID=@ID,
	timecardaudit.auditID=(SELECT LAST_INSERT_ID());
END$$
DELIMITER ;

-- TimeCardDeleteAfter
DROP TRIGGER IF EXISTS `TimeCardDeleteAfter`;
DELIMITER $$
CREATE TRIGGER TimeCardDeleteAfter 
    AFTER DELETE ON timecard
    FOR EACH ROW 
BEGIN
    SET SQL_SAFE_UPDATES = 1;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * Workterm Trigger
 *======================================================================================================================================
 */

-- WorktermUpdate
DROP TRIGGER IF EXISTS `WorktermUpdate`;
DELIMITER $$
CREATE TRIGGER WorktermUpdate 
    BEFORE UPDATE ON workterm
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.workTermID;
	-- workTermID
	IF NEW.workTermID!=OLD.workTermID OR (NEW.workTermID IS NOT NULL AND OLD.workTermID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='workTermID',
		oldValue=OLD.workTermID,
		newValue=NEW.workTermID,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- employeeID
	IF NEW.employeeID!=OLD.employeeID OR (NEW.employeeID IS NOT NULL AND OLD.employeeID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='employeeID',
		oldValue=OLD.employeeID,
		newValue=NEW.employeeID,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- companyID
	IF NEW.companyID!=OLD.companyID OR (NEW.companyID IS NOT NULL AND OLD.companyID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='companyID',
		oldValue=OLD.companyID,
		newValue=NEW.companyID,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- employeeTypeID
	IF NEW.employeeTypeID!=OLD.employeeTypeID OR (NEW.employeeTypeID IS NOT NULL AND OLD.employeeTypeID IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='employeeTypeID',
		oldValue=OLD.employeeTypeID,
		newValue=NEW.employeeTypeID,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- reasonForLeaving
	IF NEW.reasonForLeaving!=OLD.reasonForLeaving OR (NEW.reasonForLeaving IS NOT NULL AND OLD.reasonForLeaving IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='reasonForLeaving',
		oldValue=OLD.reasonForLeaving,
		newValue=NEW.reasonForLeaving,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- dateOfHire
	IF NEW.dateOfHire!=OLD.dateOfHire OR (NEW.dateOfHire IS NOT NULL AND OLD.dateOfHire IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='dateOfHire',
		oldValue=OLD.dateOfHire,
		newValue=NEW.dateOfHire,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- dateOfTermination
	IF NEW.dateOfTermination!=OLD.dateOfTermination OR (NEW.dateOfTermination IS NOT NULL AND OLD.dateOfTermination IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='dateOfTermination',
		oldValue=OLD.dateOfTermination,
		newValue=NEW.dateOfTermination,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- pay
	IF NEW.pay!=OLD.pay OR (NEW.pay IS NOT NULL AND OLD.pay IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='pay',
		oldValue=OLD.pay,
		newValue=NEW.pay,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
    
    -- incomplete
	IF NEW.incomplete!=OLD.incomplete OR (NEW.incomplete IS NOT NULL AND OLD.incomplete IS NULL) THEN
		INSERT INTO audit
		SET 
		eventType ='update',
		attributeName='incomplete',
		oldValue=OLD.incomplete,
		newValue=NEW.incomplete,
		eventTimestamp = NOW();
        INSERT INTO worktermaudit
        SET
        workTermID=@ID,
        worktermaudit.auditID=(SELECT LAST_INSERT_ID());
	END IF;
END$$
DELIMITER ;

-- WorktermInsert
DROP TRIGGER IF EXISTS `WorktermInsert`;
DELIMITER $$
CREATE TRIGGER WorktermInsert 
    AFTER INSERT ON workterm
    FOR EACH ROW 
BEGIN
	SET @ID = NEW.workTermID;
	-- employeeID
	INSERT INTO audit
	SET 
	eventType ='insert',
	attributeName='workTermID',
	oldValue=NULL,
	newValue=NEW.workTermID,
	eventTimestamp = NOW();
	INSERT INTO worktermaudit
	SET
	workTermID=@ID,
	worktermaudit.auditID=(SELECT LAST_INSERT_ID());
END$$
DELIMITER ;

-- WorktermDelete
DROP TRIGGER IF EXISTS `WorktermDelete`;
DELIMITER $$
CREATE TRIGGER WorktermDelete 
    BEFORE DELETE ON workterm
    FOR EACH ROW 
BEGIN
	SET SQL_SAFE_UPDATES = 0;
	SET @ID = OLD.workTermID;
    
	-- employeeID
	INSERT INTO audit
	SET 
	eventType ='delete',
	attributeName='workTermID',
	oldValue=@ID,
	newValue=NULL,
	eventTimestamp = NOW();
	INSERT INTO worktermaudit
	SET
	workTermID=@ID,
	worktermaudit.auditID=(SELECT LAST_INSERT_ID());
    
    DELETE FROM timecard WHERE timecard.workTermID=@ID;
END$$
DELIMITER ;

-- WorktermDeleteAfter
DROP TRIGGER IF EXISTS `WorktermDeleteAfter`;
DELIMITER $$
CREATE TRIGGER WorktermDeleteAfter 
    AFTER DELETE ON workterm
    FOR EACH ROW 
BEGIN
    SET SQL_SAFE_UPDATES = 1;
END$$
DELIMITER ;

/*
 *======================================================================================================================================
 * DATA
 *======================================================================================================================================
 */
INSERT INTO employee (firstName, lastName, socialInsuranceNumber, dateOfBirth, incomplete) 
VALUES
	("Rochelle", "Anderson",  "375435807", "1948-10-1", false),
	("Courtney", "Reese",     "019948199", "1957-7-22", true),
	("Tomas",    "Garza",     "304755978", "1951-9-30", false),
	("Darrel",   "Martin",    "042244194", "1979-2-27", true),
	("Bill",     "Neal",      "324154665", "1970-2-17", false),
	("Linda",    "Massey",    "334074499", "1990-12-4", false),
	("Everett",  "Cannon",    "015255185", "1942-11-20", false),
	("Wilson",   "Patterson", "581906336", "1980-12-18", false),
	("Faith",    "Cohen",     "776910499", "1995-11-24", false),
	("Mercedes", "Morrison",  "484219738", "1976-5-24", true),
	("Randy",    "Moran",     "739399186", "1994-5-6", false),
	("Justin",   "Fisher",    "166404376", "1973-6-19", false),
	("Matthew",  "Garrett",   "710085507", "1982-7-8", false),
	("Geneva",   "Mcbride",   "465716462", "1977-7-22", true),
	("Abel",     "Wade",      "859740482", "1974-10-4", false),
	("Mamie",    "Sullivan",  "355240672", "1989-12-2", false),
	("Amos",     "Roy",       "272097528", "1996-3-13", true),
	("Verna",    "Gilbert",   "596014423", "1986-7-17", true),
	("Gordon",   "Goodman",   "906253042", "1958-3-5", false),
	("Byron",    "Stevens",   "494073646", "1947-11-9", false),
	("Beverly",  "Glover",    "752414417", "1942-7-30", false),
	("Hannah",   "Romero",    "042541797", "1992-11-17", false),
	("Joanne",   "Thornton",  "800444291", "1992-5-28", true),
	("Moses",    "Mcdonald",  "453702524", "1954-7-12", false),
	("Gerard",   "Castillo",  "090390824", "1972-11-30", false);
        
INSERT INTO company (companyName) 
VALUES
	("Microsoft"), 
	("Conestoga College"), 
	("BlackBerry"), 
	("Walmart"), 
    ("Twitch"), 
    ("Google"),
    ("Scotiabank"), 
    ("McDonalds");
                                        
INSERT INTO employeeType(employeeTypeName) 
VALUES 
	("Full Time"),
	("Part Time"),
    ("Seasonal"),
    ("Contract");
                                                    
INSERT INTO workterm (employeeID, companyID, employeeTypeID, dateOfHire, dateOfTermination, incomplete, pay, reasonForLeaving) 
VALUES 
	#Microsoft
	(1, 1, 1, "2016-5-6", "2017-04-16", false, 72572, "terminated"),
	(2, 1, 2, "2015-1-9", "2017-4-12", false, 22.00, "retired"),
	(3, 1, 4, "2015-6-1", "2017-4-3", true, 15523, "contract lapsed"),
    
    #Conestoga College
	(4, 2, 3, "2014-2-1", null, false, 1.20, null),
	(5, 2, 1, "2016-6-22", null, false, 72312, null),
	(6, 2, 2, "2014-2-5", "2017-4-5", false, 20.00, "quit"),
    
    #BlackBerry
	(7, 3, 4, "2017-3-1", "2017-04-24", false, 13733, "contract lapsed"),
	(8, 3, 3, "2016-5-25", null, true, 2.10, null),
	(9, 3, 1, "2015-1-21", "2017-4-10", false, 53632, "retired"),
    
    #Walmart
	(10, 4, 2, "2015-6-22", null, false, 11.40, null),
	(11, 4, 4, "2017-1-1", "2017-04-24", false, 18643, "contract lapsed"),
	(12, 4, 3, "2015-10-28", null, false, 0.85, null),
    
    #Twitch
	(13, 5, 1, "2015-9-14", null, true, 92122, null),
	(14, 5, 2, "2016-2-7", "2017-1-1", false, 16.22, "terminated"),
	(15, 5, 4, "2016-6-1", "2017-6-30", false, 13623, "contract lapsed"),
    
    #Google
	(16, 6, 3, "2016-1-8", "2017-10-18", false, 1.44, "season ended"),
	(17, 6, 1, "2015-2-24", null, true, 84532, null),
	(18, 6, 2, "2016-5-1", null, false, 18.00, null),
    
    #Scotiabank
	(19, 7, 4, "2017-3-1", "2018-3-1", false, 15143, "contract lapsed"),
	(20, 7, 3, "2016-7-7", "2017-7-7", false, 3.92, "retired"),
	(21, 7, 1, "2016-9-24", null, false, 44512, null),
    
    #McDonalds
	(22, 8, 2, "2014-12-13", null, false, 11.40, null),
	(23, 8, 3, "2014-3-1", "2015-9-30", true, 11143, "season ended"),
	(24, 8, 4, "2015-5-22", null, false, 0.25, null),
	(25, 8, 1, "2015-8-16", null, false, 32572, null);

INSERT INTO timecard 
	(workTermID,cardDate,sunHours,monHours,tueHours,
     wedHours,thuHours,friHours,satHours,piecesComplete,
     sunPieces,monPieces,tuePieces,wedPieces,thuPieces,
     friPieces,satPieces)
VALUES
	#Microsoft
	(1,"2017-04-03",0,8,8,8,8,8,0,0,0,0,0,0,0,0,0),
    (2,"2017-04-03",0,8,8,8,10,8,0,0,0,0,0,0,0,0,0),
    (3,"2017-04-03",0,8,8,8,10,8,0,0,0,0,0,0,0,0,0),
    
    #Conestoga College
    (4,"2017-04-03",10,0,8,8,10,8,10,0,100,0,100,100,50,50,50),
    (5,"2017-04-03",0,8,8,8,8,0,0,0,0,0,0,0,0,0,0),
    (6,"2017-04-03",0,8,8,8,8,8,0,0,0,0,0,0,0,0,0),
    
    #BlackBerry
    (7,"2017-04-03",0,8,8,8,8,0,0,0,0,0,0,0,0,0,0),
    (8,"2017-04-03",10,0,8,8,10,8,10,0,100,0,100,100,50,50,50),
    (9,"2017-04-03",0,8,5,6,8,8,0,0,0,0,0,0,0,0,0),
    
    #Walmart
    (10,"2017-04-03",0,8,8,8,8,0,0,0,0,0,0,0,0,0,0),
    (11,"2017-04-03",0,8,5,6,8,8,0,0,0,0,0,0,0,0,0),
    (12,"2017-04-03",10,0,8,8,10,8,10,0,100,0,100,100,50,50,50),
    
    #Twitch
    (13,"2017-04-03",0,9,8,8,8,7,0,0,0,0,0,0,0,0,0),
    (14,"2017-04-03",0,8,5,6,8,8,0,0,0,0,0,0,0,0,0),
    (15,"2017-04-03",10,0,8,8,10,8,10,0,100,0,100,100,50,50,50);

INSERT INTO usertype(userTypeName, securityLevel) 
VALUES
	('Administrator', 1),
	('General', 2);

INSERT INTO users(userTypeID, pass, firstName, lastName, active) 
VALUES
	(1, 'password', 'Justin', 'Hergott', true),
	(2, 'password', 'Bobby', 'Vu', true);
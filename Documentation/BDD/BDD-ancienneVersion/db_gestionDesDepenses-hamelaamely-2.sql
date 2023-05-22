-- *********************************************
-- * Standard SQL generation
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2
-- * Generator date: Sep 14 2021
-- * Generation date: Wed May 10 15:42:57 2023
-- * LUN file: C:\Users\hamelaamely\Desktop\db_gestionDesDepenses.lun
-- * Schema: DB_GestDepenses/SQL
-- *********************************************


--- Database Section
-- ________________
CREATE DATABASE DB_GestDepenses;

-- Tables Section
-- _____________
CREATE TABLE t_roles (
     idRoles INT NOT NULL,
     name VARCHAR(50) NOT NULL,
     PRIMARY KEY (idRoles)
);

CREATE TABLE t_users (
     idUsers INT NOT NULL,
     useName VARCHAR(50) NOT NULL,
     useEmail VARCHAR(50) NOT NULL,
     usePassword VARCHAR(255) NOT NULL,
     useCreated_at DATE NOT NULL,
     useUpdated_at DATE NOT NULL,
     fkRoles INT NOT NULL,
     PRIMARY KEY (idUsers),
     FOREIGN KEY (fkRoles) REFERENCES t_roles(idRoles)
);

CREATE TABLE t_activities (
     idActivities INT NOT NULL,
     title VARCHAR(255) NOT NULL,
     description VARCHAR(50) NOT NULL,
     isSuperUser INT NOT NULL,
     created_at DATE NOT NULL,
     updated_at DATE NOT NULL,
     PRIMARY KEY (idActivities),
     FOREIGN KEY (isSuperUser) REFERENCES t_users(idUsers)
);

CREATE TABLE t_expenses (
     idExpenses INT NOT NULL,
     expTitle VARCHAR(255) NOT NULL,
     expDescription VARCHAR(255) NOT NULL,
     expAmount DECIMAL(10,2) NOT NULL,
     expCreated_at DATE NOT NULL,
     expUpdated_at DATE NOT NULL,
     idActivities INT NOT NULL,
     fkActivities INT NOT NULL,
     PRIMARY KEY (idExpenses),
     FOREIGN KEY (fkActivities) REFERENCES t_activities(idActivities)
);

CREATE TABLE t_owned (
     idOwned INT NOT NULL AUTO_INCREMENT,
     fkExpenses INT NOT NULL,
     fkPayer INT NOT NULL,
     PRIMARY KEY (idOwned),
     FOREIGN KEY (fkExpenses) REFERENCES t_expenses(idExpenses),
     FOREIGN KEY (fkPayer) REFERENCES t_users(idUsers)
);

CREATE TABLE t_expense_participants (
     idExpenseParticipant INT NOT NULL AUTO_INCREMENT,
     fkExpenses INT NOT NULL,
     fkUser INT NOT NULL,
     PRIMARY KEY (idExpenseParticipant),
     FOREIGN KEY (fkExpenses) REFERENCES t_expenses(idExpenses),
     FOREIGN KEY (fkUser) REFERENCES t_users(idUsers)
);

CREATE TABLE t_activity_superuser (
     idActivity INT NOT NULL,
     fkUsers INT NOT NULL,
     PRIMARY KEY (idActivity, fkUsers),
     FOREIGN KEY (idActivity) REFERENCES t_activities(idActivities),
     FOREIGN KEY (fkUsers) REFERENCES t_users(idUsers)
);

-- Index Section
-- _____________
CREATE INDEX ID_t_roles_IND ON t_roles (idRoles);
CREATE INDEX ID_t_users_IND ON t_users (idUsers);
CREATE INDEX REF_t_use_t_rol_IND ON t_users (fkRoles);
CREATE INDEX ID_t_activities_IND ON t_activities (idActivities);
CREATE INDEX ID_t_expenses_IND ON t_expenses (idExpenses);
CREATE INDEX REF_t_exp_t_act_IND ON t_expenses (fkActivities);
CREATE UNIQUE INDEX ID_create_IND ON t_owned (idOwned);
CREATE INDEX REF_creat_t_use_IND ON t_owned (fkPayer);
CREATE UNIQUE INDEX ID_expense_participant_IND ON t_expense_participants (idExpenseParticipant);
CREATE INDEX REF_expense_participant_expenses_IND ON t_expense_participants (fkExpenses);
CREATE INDEX REF_expense_participant_user_IND ON t_expense_participants (fkUser);

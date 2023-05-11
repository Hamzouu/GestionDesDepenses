-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Wed May 10 10:40:15 2023 
-- * LUN file:  
-- * Schema: Gestion/1 
-- ********************************************* 


-- Database Section
-- ________________ 

CREATE DATABASE db_gestionDepenses;

-- DBSpace Section
-- _______________

-- Tables Section
-- _____________

CREATE TABLE t_activities (
     idActivities CHAR(1) NOT NULL,
     actTitle VARCHAR(50) NOT NULL,
     actDescription VARCHAR(255) NOT NULL,
     actIsSuperUser TINYINT(1) NOT NULL,
     actCreated_at DATE NOT NULL,
     actUpdated_at DATE NOT NULL,
     CONSTRAINT PK_t_activities PRIMARY KEY (idActivities)
);

CREATE TABLE t_users (
     idUsers INT NOT NULL AUTO_INCREMENT,
     useName VARCHAR(50) NOT NULL,
     useEmail VARCHAR(50) NOT NULL,
     usePassword VARCHAR(255) NOT NULL,
     useCreated_at DATE NOT NULL,
     useUpdated_at DATE NOT NULL,
     fkRoles INT NOT NULL,
     CONSTRAINT PK_t_users PRIMARY KEY (idUsers),
     CONSTRAINT FK_t_users_roles FOREIGN KEY (fkRoles) REFERENCES t_roles(idRoles)
);

CREATE TABLE t_roles (
     idRoles INT NOT NULL AUTO_INCREMENT,
     rolName VARCHAR(50) NOT NULL,
     CONSTRAINT PK_t_roles PRIMARY KEY (idRoles)
);

CREATE TABLE t_expenses (
     idExpenses INT NOT NULL AUTO_INCREMENT,
	 fkUsers INT NOT NULL,
     expTitle VARCHAR(255) NOT NULL,
     expDescription VARCHAR(255) NOT NULL,
     expAmount NUMERIC(10,2) NOT NULL,
     expCreated_at DATE NOT NULL,
     expUpdated_at DATE NOT NULL,
	 CONSTRAINT FK_t_expenses_payer FOREIGN KEY (fkUsers) REFERENCES t_users(idUsers),
     CONSTRAINT PK_t_expenses PRIMARY KEY (Expenses)
);

CREATE TABLE t_activityExpenses (
     idActivityExpenses INT NOT NULL AUTO_INCREMENT,
     fkActivity CHAR(1) NOT NULL,
     fkExpenses INT NOT NULL,
     CONSTRAINT PK_t_activityExpenses PRIMARY KEY (idActivityExpenses),
     CONSTRAINT FK_t_activityExpenses_activities FOREIGN KEY (fkActivity) REFERENCES t_activities(idActivities),
     CONSTRAINT FK_t_activityExpenses_expenses FOREIGN KEY (fkExpenses) REFERENCES t_expenses(idExpenses)
);

CREATE TABLE t_create (
     fkActivity CHAR(1) NOT NULL,
     fkUsers INT NOT NULL,
     CONSTRAINT PK_create PRIMARY KEY (idActivities, idUsers),
     CONSTRAINT FK_create_activities FOREIGN KEY (fkActivity) REFERENCES t_activities(idActivities),
     CONSTRAINT FK_create_users FOREIGN KEY (fkUsers) REFERENCES t_users(idUsers)
);

CREATE TABLE t_activityUsers (
     fkActivity INT NOT NULL,
     fkUsers INT NOT NULL,
     CONSTRAINT PK_t_activity_users PRIMARY KEY (fkActivity, fkUsers),
     CONSTRAINT FK_t_activity_users_activities FOREIGN KEY (fkActivity) REFERENCES t_activities(idActivity),
     CONSTRAINT FK_t_activity_users_users FOREIGN KEY (fkUsers) REFERENCES t_users(idUser)
);

CREATE TABLE t_expenseUsers (
     fkExpense INT NOT NULL,
     fkUsers INT NOT NULL,
	 expAmountPaid NUMERIC(10,2) NOT NULL,
     CONSTRAINT PK_t_expense_users PRIMARY KEY (idExpense, idUser),
     CONSTRAINT FK_t_expense_users_expenses FOREIGN KEY (fkExpense) REFERENCES t_expenses(idExpense),
     CONSTRAINT FK_t_expense_users_users FOREIGN KEY (fkUsers) REFERENCES t_users(idUser)
);


-- Constraints Section
-- ___________________

ALTER TABLE t_roles ADD CONSTRAINT CHK_t_roles_users CHECK (
     EXISTS(SELECT * FROM t_users WHERE t_users.idRoles = t_roles.idRoles)
);

ALTER TABLE t_activities ADD CONSTRAINT CHK_t_activities_create CHECK (
     EXISTS(SELECT * FROM create WHERE create.idActivities = t_activities.idActivities)
);


-- Index Section
-- _____________

CREATE UNIQUE INDEX ID_create_IND ON create (idActivities, idUsers);
CREATE INDEX FK_create_users_IND ON create (idUsers);

CREATE UNIQUE INDEX ID_t_users_IND ON t_users (idUsers);
CREATE INDEX FK_t_users_roles_IND ON t_users (idRoles);

CREATE UNIQUE INDEX ID_t_roles_IND ON t_roles (idRoles);

CREATE UNIQUE INDEX ID_t_activities_IND ON t_activities (idActivities);
CREATE INDEX FK_t_activityExpenses_activities_IND ON t_activityExpenses (idActivities);
CREATE INDEX FK_t_activityExpenses_expenses_IND ON t_activityExpenses (idExpenses);

-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Mon May 15 10:20:18 2023 
-- * LUN file: C:\Users\hamelaamely\TPI\Documentation\BDD\MCD\GestDepenses.lun 
-- * Schema: DB_GestDepenses/1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database DB_GestDepenses;
use DB_GestDepenses;


-- Tables Section
-- _____________ 

CREATE TABLE t_users (
     idUsers INT NOT NULL,
     useName VARCHAR(50) NOT NULL,
     useEmail VARCHAR(50) NOT NULL,
     usePassword VARCHAR(255) NOT NULL,
     useCreated_at DATE NOT NULL,
     useUpdated_at DATE NOT NULL,
     idRoles INT NOT NULL,
     CONSTRAINT ID_t_users_ID PRIMARY KEY (idUsers)
);


CREATE TABLE t_activities (
     idActivities INT NOT NULL,
     actTitle VARCHAR(255) NOT NULL,
     actDescription VARCHAR(255) NOT NULL,
     actCreated_at DATE NOT NULL,
     actUpdated_at DATE NOT NULL,
     idUsers INT NOT NULL,
     CONSTRAINT ID_t_activities_ID PRIMARY KEY (idActivities)
);

CREATE TABLE t_expenses (
     idExpenses INT NOT NULL,
     expTitle VARCHAR(255) NOT NULL,
     expDescription VARCHAR(255) NOT NULL,
     expAmount DECIMAL(10,2) NOT NULL,
     expCreated_at DATE NOT NULL,
     expUpdated_at DATE NOT NULL,
     idActivities INT NOT NULL,
     idUsers INT NOT NULL,
     CONSTRAINT ID_t_expenses_ID PRIMARY KEY (idExpenses)
);

CREATE TABLE t_roles (
     idRoles INT NOT NULL,
     name VARCHAR(50) NOT NULL,
     CONSTRAINT ID_t_roles_ID PRIMARY KEY (idRoles)
);

CREATE TABLE expenseParticipants (
     idExpenses INT NOT NULL,
     idUsers INT NOT NULL,
     CONSTRAINT ID_expenseParticipants_ID PRIMARY KEY (idExpenses, idUsers)
);

CREATE TABLE participate (
     idActivities INT NOT NULL,
     idUsers INT NOT NULL,
     CONSTRAINT ID_participate_ID PRIMARY KEY (idActivities, idUsers)
);
-- Constraints Section
-- ___________________

ALTER TABLE t_users ADD CONSTRAINT FKR_FK
     FOREIGN KEY (idRoles)
     REFERENCES t_roles (idRoles);

ALTER TABLE t_activities ADD CONSTRAINT FKactivitySuperuser__FK
     FOREIGN KEY (idUsers)
     REFERENCES t_users (idUsers);

ALTER TABLE t_expenses ADD CONSTRAINT FKrelateTo_FK
     FOREIGN KEY (idActivities)
     REFERENCES t_activities (idActivities);

ALTER TABLE t_expenses ADD CONSTRAINT FKcreated_FK
     FOREIGN KEY (idUsers)
     REFERENCES t_users (idUsers);

ALTER TABLE expenseParticipants ADD CONSTRAINT FKexp_t_u_FK
     FOREIGN KEY (idUsers)
     REFERENCES t_users (idUsers);

ALTER TABLE expenseParticipants ADD CONSTRAINT FKexp_t_e
     FOREIGN KEY (idExpenses)
     REFERENCES t_expenses (idExpenses);

ALTER TABLE participate ADD CONSTRAINT FKpar_t_u_FK
     FOREIGN KEY (idUsers)
     REFERENCES t_users (idUsers);

ALTER TABLE participate ADD CONSTRAINT FKpar_t_a
     FOREIGN KEY (idActivities)
     REFERENCES t_activities (idActivities);



-- Index Section
-- _____________ 

create unique index ID_t_users_IND
     on t_users (idUsers);

create index FKR_IND
     on t_users (idRoles);

create unique index ID_t_activities_IND
     on t_activities (idActivities);

create index FKactivitySuperuser__IND
     on t_activities (idUsers);

create unique index ID_t_expenses_IND
     on t_expenses (idExpenses);

create index FKrelateTo_IND
     on t_expenses (idActivities);

create index FKcreated_IND
     on t_expenses (idUsers);

create unique index ID_t_roles_IND
     on roles (idRoles);

create unique index ID_expenseParticipants_IND
     on expenseParticipants (idExpenses, idUsers);

create index FKexp_t_u_IND
     on expenseParticipants (idUsers);

create unique index ID_participate_IND
     on participate (idActivities, idUsers);

create index FKpar_t_u_IND
     on participate (idUsers);


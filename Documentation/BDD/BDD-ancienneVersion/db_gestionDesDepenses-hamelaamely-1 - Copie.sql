-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Wed May 10 15:42:57 2023 
-- * LUN file: C:\Users\hamelaamely\Desktop\db_gestionDesDepenses.lun 
-- * Schema: DB_GestDepenses/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 

create database DB_GestDepenses;


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________ 

create table t_owned (
     fkExpenses char(1) not null,
     fkUsers char(1) not null,
     constraint ID_create_ID primary key (fkExpenses, fkUsers));

create table t_participate (
     fkActivities char(1) not null,
     fkUsers char(1) not null,
     constraint ID_participate_ID primary key (fkActivities, fkUsers));

create table t_activities (
     idActivities char(1) not null,
     title char(1) not null,
     description varchar(50) not null,
     isSuperUser char(1) not null,
     created_at date not null,
     updated_at date not null,
     constraint ID_t_activities_ID primary key (idActivities));

create table t_expenses (
     idExpenses char(1) not null,
     expTitle varchar(255) not null,
     expDescription varchar(255) not null,
     expAmount varchar(255) not null,
     expCreated_at date not null,
     expUpdated_at date not null,
     idActivities char(1) not null,
     fkActivities char(1) not null,
     constraint ID_t_expenses_ID primary key (idExpenses));

create table t_roles (
     idRoles -- Compound attribute -- not null,
     name varchar(50) not null,
     constraint ID_t_roles_ID primary key (idRoles -- Compound attribute --));

create table t_users (
     idUsers char(1) not null,
     useName varchar(50) not null,
     useEmail varchar(50) not null,
     usePassword varchar(255) not null,
     useCreated_at date not null,
     useUpdated_at date not null,
     fkRoles -- Compound attribute -- not null,
     constraint ID_t_users_ID primary key (idUsers));


-- Constraints Section
-- ___________________ 

alter table t_owned add constraint REF_t_owned_t_use_FK
     foreign key (fkUsers)
     references t_users;

alter table t_owned add constraint EQU_creat_t_exp
     foreign key (fkExpenses)
     references t_expenses;

alter table t_participate add constraint REF_parti_t_use_FK
     foreign key (fkUsers)
     references t_users;

alter table t_participate add constraint EQU_parti_t_act
     foreign key (fkActivities)
     references t_activities;

alter table t_activities add constraint ID_t_activities_CHK
     check(exists(select * from t_participate
                  where t_participate.fkActivities = idActivities)); 

alter table t_expenses add constraint ID_t_expenses_CHK
     check(exists(select * from t_owned
                  where t_owned.fkExpenses = idExpenses)); 

alter table t_expenses add constraint REF_t_exp_t_act_FK
     foreign key (fkActivities)
     references t_activities;

alter table t_users add constraint REF_t_use_t_rol_FK
     foreign key (fkRoles -- Compound attribute --)
     references t_roles;


-- Index Section
-- _____________ 

create unique index ID_create_IND
     on t_owned (fkExpenses, fkUsers);

create index REF_creat_t_use_IND
     on t_owned (fkUsers);

create unique index ID_participate_IND
     on t_participate (fkActivities, fkUsers);

create index REF_parti_t_use_IND
     on t_participate (fkUsers);

create unique index ID_t_activities_IND
     on t_activities (idActivities);

create unique index ID_t_expenses_IND
     on t_expenses (idExpenses);

create index REF_t_exp_t_act_IND
     on t_expenses (fkActivities);

create unique index ID_t_roles_IND
     on t_roles (idRoles -- Compound attribute --);

create unique index ID_t_users_IND
     on t_users (idUsers);

create index REF_t_use_t_rol_IND
     on t_users (fkRoles -- Compound attribute --);


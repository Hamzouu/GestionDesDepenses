-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Wed May 10 14:26:46 2023 
-- * LUN file: C:\Users\hamelaamely\Desktop\db_gestionDesDepenses.lun 
-- * Schema: Gestion/1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database Gestion;
use Gestion;


-- Tables Section
-- _____________ 

create table ceate (
     idActivities char(1) not null,
     idUsers -- Index attribute not implemented -- not null,
     constraint ID_ceate_ID primary key (idActivities, idUsers));

create table t_expenses (
     idExpenses char(1) not null,
     expTitle varchar(255) not null,
     expDescription varchar(255) not null,
     expAmount varchar(255) not null,
     expCreated_at date not null,
     expUpdated_at date not null);

create table t_activities (
     idActivities char(1) not null,
     title char(1) not null,
     description varchar(50) not null,
     isSuperUser char(1) not null,
     created_at date not null,
     updated_at date not null,
     constraint ID_t_activities_ID primary key (idActivities));

create table t_roles (
     idRoles -- Compound attribute -- not null,
     name varchar(50) not null,
     constraint ID_t_roles_ID primary key (idRoles -- Compound attribute --));

create table t_users_ (
     idUsers -- Index attribute not implemented -- not null,
     name varchar(50) not null,
     email varchar(50) not null,
     password varchar(255) not null,
     created_at date not null,
     updated_at date not null,
     idRoles -- Compound attribute -- not null,
     constraint ID_t_users__ID primary key (idUsers));


-- Constraints Section
-- ___________________ 

alter table ceate add constraint FKcea_t_u_FK
     foreign key (idUsers)
     references t_users_ (idUsers);

alter table ceate add constraint FKcea_t_a
     foreign key (idActivities)
     references t_activities (idActivities);

-- Not implemented
-- alter table t_activities add constraint ID_t_activities_CHK
--     check(exists(select * from ceate
--                  where ceate.idActivities = idActivities)); 

-- Not implemented
-- alter table t_roles add constraint ID_t_roles_CHK
--     check(exists(select * from t_users_
--                  where t_users_.idRoles = idRoles)); 

alter table t_users_ add constraint FKR_1_FK
     foreign key (idRoles -- Compound attribute --)
     references t_roles (idRoles -- Compound attribute --);


-- Index Section
-- _____________ 

create unique index ID_ceate_IND
     on ceate (idActivities, idUsers);

create index FKcea_t_u_IND
     on ceate (idUsers);

create unique index ID_t_activities_IND
     on t_activities (idActivities);

create unique index ID_t_roles_IND
     on t_roles (idRoles -- Compound attribute --);

create unique index ID_t_users__IND
     on t_users_ (idUsers);

create index FKR_1_IND
     on t_users_ (idRoles -- Compound attribute --);


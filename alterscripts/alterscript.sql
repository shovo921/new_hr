--DATE : 03-04-2024
----------------------------------------------------------------------
--Creating KPI_FIELDS
create table KPI_FIELDS
(
    ID         NUMBER generated as identity,
    FIELD_NAME VARCHAR2(50),
    STATUS     NUMBER(1),
    CREATED_AT DATE default SYSDATE not null
)
    /
--------------------------------------------------------------------------------------------------------------------------------------------
--Creating EMPLOYEE_KPI
create table EMPLOYEE_KPI
(
    ID          NUMBER generated as identity
        constraint "EMPLOYEE_KPI_pk"
            primary key,
    EMPLOYEE_ID VARCHAR2(30)              not null,
    KPI_YEAR    VARCHAR2(10),
    KPI_DATA    CLOB,
    CREATED_AT  DATE      default SYSDATE not null,
    STATUS      NUMBER(1) default 1       not null,
    constraint EMPLOYEE_KPI_UNIQUE
        unique (EMPLOYEE_ID, KPI_YEAR)
)
    /

comment on table EMPLOYEE_KPI is 'Employee KPI information will be stored here'
/

comment on column EMPLOYEE_KPI.STATUS is '1 = Active, 2 = In active'
/


--------------------------------------------------------------------------------------------------------------------------------------------


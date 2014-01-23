/* 
CPSC 332 Final Project 
Name: Daniel Jordan 
Email: daniel_jordan@csu.fullerton.edu 
File: 332_Project_Schema.sql 
*/ 

DROP TABLE IF EXISTS PROFESSOR,DEGREE,DEPARTMENT,COURSE,SECTION,PREREQUISET,STUDENT,MINORS,ENROLLMENT; 

CREATE TABLE PROFESSOR 
  ( 
     PROFESSOR_SSN    NUMERIC(9) NOT NULL, 
     PROFESSOR_NAME   VARCHAR(20) NOT NULL, 
     PROFESSOR_STREET VARCHAR(30) NOT NULL, 
     PROFESSOR_CITY   VARCHAR(15) NOT NULL, 
     PROFESSOR_STATE  CHAR(2) NOT NULL, 
     PROFESSOR_ZIP    VARCHAR(10) NOT NULL, /*Alphanumeric 10 digit zipcodes for international schools. */ 
     PROFESSOR_SEX    CHAR(1) NOT NULL, 
     PROFESSOR_PHONE  NUMERIC(10) NOT NULL, 
     PROFESSOR_TITLE  ENUM('Dr.','Mr.','Mrs.','Ms.'), 
     PRIMARY KEY(PROFESSOR_SSN) 
  ); 
CREATE TABLE DEGREE 
  ( 
     DEGREE_NAME      VARCHAR(20) NOT NULL, 
     DEGREE_OWNER_SSN NUMERIC(9) NOT NULL, 
     PRIMARY KEY(DEGREE_NAME, DEGREE_OWNER_SSN), 
     FOREIGN KEY(DEGREE_OWNER_SSN) REFERENCES PROFESSOR(PROFESSOR_SSN) 
  ); 

CREATE TABLE DEPARTMENT 
  ( 
     DEPARTMENT_NUMBER    NUMERIC(5) NOT NULL, 
     DEPARTMENT_NAME      VARCHAR(20) NOT NULL, 
     DEPARTMENT_PHONE     NUMERIC(10) NOT NULL, 
     DEPARTMENT_OFFICE    VARCHAR(10) NOT NULL, 
     DEPARTMENT_CHAIR_SSN NUMERIC(9) NOT NULL, 
     PRIMARY KEY(DEPARTMENT_NUMBER, DEPARTMENT_CHAIR_SSN), 
     FOREIGN KEY(DEPARTMENT_CHAIR_SSN) REFERENCES PROFESSOR(PROFESSOR_SSN) 
  ); 

CREATE TABLE COURSE 
  ( 
     COURSE_NUMBER            VARCHAR(10) NOT NULL, 
     COURSE_DEPARTMENT_NUMBER NUMERIC(5) NOT NULL, 
     COURSE_TITLE             VARCHAR(50) NOT NULL, 
     COURSE_TEXTBOOK          VARCHAR(50) NOT NULL, 
     COURSE_UNITS             NUMERIC(1) NOT NULL, 
     PRIMARY KEY(COURSE_NUMBER, COURSE_DEPARTMENT_NUMBER), 
     FOREIGN KEY(COURSE_DEPARTMENT_NUMBER) REFERENCES DEPARTMENT(DEPARTMENT_NUMBER) 
  ); 

CREATE TABLE SECTION 
  ( 
     SECTION_NUMBER         NUMERIC(5) NOT NULL, 
     SECTION_COURSE_NUMBER  VARCHAR(10) NOT NULL, 
     SECTION_PROFESSOR_SSN  VARCHAR(9) NOT NULL, 
     SECTION_CLASSROOM      VARCHAR(10) NOT NULL, 
     SECTION_DAYS           CHAR(8) NOT NULL, /* MW, TTH, MWF, MTWTHF, MTWTHFS, MTWTHFSS */ 
     SECTION_SEATS          NUMERIC(3) NOT NULL, 
     SECTION_BEGINNING_TIME TIME NOT NULL, 
     SECTION_ENDING_TIME    TIME NOT NULL, 
     PRIMARY KEY(SECTION_NUMBER, SECTION_COURSE_NUMBER), 
     FOREIGN KEY(SECTION_COURSE_NUMBER) REFERENCES COURSE(COURSE_NUMBER), 
     FOREIGN KEY(SECTION_PROFESSOR_SSN) REFERENCES PROFESSOR(PROFESSOR_SSN) 
  ); 

CREATE TABLE PREREQUISET 
  ( 
     PREREQUISET_NUMBER        VARCHAR(10) NOT NULL,  
     PREREQUISET_COURSE_NUMBER VARCHAR(10) NOT NULL, 
     PRIMARY KEY(PREREQUISET_NUMBER, PREREQUISET_COURSE_NUMBER), 
     FOREIGN KEY(PREREQUISET_NUMBER) REFERENCES COURSE(COURSE_NUMBER), 
     FOREIGN KEY(PREREQUISET_COURSE_NUMBER) REFERENCES COURSE(COURSE_NUMBER) 
  ); 

CREATE TABLE STUDENT 
  ( 
     STUDENT_CCWID             NUMERIC(10) NOT NULL, 
     STUDENT_DEPARTMENT_NUMBER NUMERIC(5) NOT NULL, 
     STUDENT_FIRST_NAME        VARCHAR(20) NOT NULL, 
     STUDENT_LAST_NAME         VARCHAR(20) NOT NULL, 
     STUDENT_PHONE             NUMERIC(10) NOT NULL, 
     STUDENT_STREET            VARCHAR(30) NOT NULL, 
     STUDENT_CITY              VARCHAR(15) NOT NULL, 
     STUDENT_STATE             CHAR(2) NOT NULL, 
     STUDENT_ZIP               VARCHAR(10) NOT NULL,  /* Allows alphanumeric zips for international students */ 
     PRIMARY KEY(STUDENT_CCWID, STUDENT_DEPARTMENT_NUMBER), 
     FOREIGN KEY(STUDENT_DEPARTMENT_NUMBER) REFERENCES DEPARTMENT(DEPARTMENT_NUMBER) 
  ); 

CREATE TABLE MINORS 
  ( 
     MINOR_DEPARTMENT_NUMBER NUMERIC(5) NOT NULL, 
     MINOR_STUDENT_CCWID     NUMERIC(10) NOT NULL, 
     PRIMARY KEY(MINOR_DEPARTMENT_NUMBER, MINOR_STUDENT_CCWID), 
     FOREIGN KEY(MINOR_STUDENT_CCWID) REFERENCES STUDENT(STUDENT_CCWID), 
     FOREIGN KEY(MINOR_DEPARTMENT_NUMBER) REFERENCES DEPARTMENT(DEPARTMENT_NUMBER) 
  ); 

CREATE TABLE ENROLLMENT 
  ( 
     ENROLLMENT_CCWID          NUMERIC(10) NOT NULL, 
     ENROLLMENT_GRADE          ENUM('A+','A-','A','B+','B','B-','C+','C','C-','D+','D','D-','F') NOT NULL, 
     ENROLLMENT_SECTION_NUMBER NUMERIC(10) NOT NULL, 
     ENROLLMENT_COURSE_NUMBER  VARCHAR(10) NOT NULL, 
     PRIMARY KEY(ENROLLMENT_SECTION_NUMBER, ENROLLMENT_CCWID, ENROLLMENT_COURSE_NUMBER), 
     FOREIGN KEY(ENROLLMENT_SECTION_NUMBER) REFERENCES SECTION(SECTION_NUMBER), 
     FOREIGN KEY(ENROLLMENT_CCWID) REFERENCES STUDENT(STUDENT_CCWID), 
     FOREIGN KEY (ENROLLMENT_COURSE_NUMBER) REFERENCES COURSE(COURSE_NUMBER) 
  ); 
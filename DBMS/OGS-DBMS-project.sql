---create database named OGS
create database OGS;

---use the database OGS to create table within it

use OGS;

---create table named student

create table student(
student_id int primary key identity(1,1),
first_name varchar(255) not null,
last_name varchar(255) not null,
registration_date date,
email varchar(255) unique not null,
password varchar(255) not null
);

---create table named course

create table course(
course_code varchar(255) primary key,
course_name varchar(255) not null,
credit_hour int not null,
instructor varchar(255) not null,
);

---create table named grade

create table grade(
grade_id int primary key,
student_id int foreign key references student(student_id),
course_code varchar(255) foreign key references course(course_code),
semester_year varchar(255) not null,
grade char(1) not null,
GPA decimal(3,2) not null
);

--create table named student course enrollment
create table StudentCourseEnrollment(
student_id int foreign key references student(student_id),
course_code varchar(255) foreign key references course(course_code),
semester varchar(20)
);


---create table named grade student

create table GradeStudent(
grade_id int foreign key references grade(grade_id),
student_id int foreign key references student(student_id),
);

---create table named grade course

create table GradeCourse(
grade_id int foreign key references grade(grade_id),
course_code varchar(255) foreign key references course(course_code),
);

---group memebers
--Eyuel Abiyot - 04570/14
--Abel Mesfin - 04575/14
--Abdulselam Jeylan - 06117/14
--Yohanes Asirat - 04579/14
/* Generate everything */

/* First clear all data */
/*
DROP TABLE reserve;
DROP TABLE booking;
DROP TABLE user;
DROP TABLE facility;
DROP TABLE hotel;
*/
/* Second create the tables */
CREATE TABLE hotel(
hotelid INT PRIMARY KEY AUTO_INCREMENT,
hotelname VARCHAR(128) NOT NULL,
country VARCHAR(64) NOT NULL,
city VARCHAR(64) NOT NULL,
street VARCHAR(256),
star INT DEFAULT 1 CHECK(star > 0 and star < 7),
sustain_certified BOOL DEFAULT 0 NOT NULL,
aircon BOOL DEFAULT 0 NOT NULL,
meeting_rm BOOL DEFAULT 0 NOT NULL,
pets_allowed BOOL DEFAULT 0 NOT NULL,
restaurant BOOL DEFAULT 0 NOT NULL,
car_park BOOL DEFAULT 0 NOT NULL,
internet BOOL DEFAULT 0 NOT NULL,
child_facility BOOL DEFAULT 0 NOT NULL,
no_smoking BOOL DEFAULT 0 NOT NULL,
biz_centre BOOL DEFAULT 0 NOT NULL,
reduced_mobility_rm BOOL DEFAULT 0 NOT NULL,
fitness_club BOOL DEFAULT 0 NOT NULL,
swimming_pool BOOL DEFAULT 0 NOT NULL,
thalassotherapy_centre BOOL DEFAULT 0 NOT NULL,
golf BOOL DEFAULT 0 NOT NULL,
tennis BOOL DEFAULT 0 NOT NULL);

/* Weak identity */
CREATE TABLE facility(
hotelid INT,
room_class INT CHECK(room_class > 0 and room_class < 6),
bed_size INT CHECK(bed_size > 0 and bed_size < 7),
no_bed INT CHECK(no_bed > 0),
room_desc VARCHAR(256),
room_count INT CHECK(room_count > 0),
PRIMARY KEY(hotelid, room_class, bed_size, no_bed),
FOREIGN KEY(hotelid) REFERENCES hotel(hotelid) ON DELETE CASCADE);

CREATE TABLE user(
email VARCHAR(60) PRIMARY KEY CHECK(email != '' AND email LIKE '%@%'),
password VARCHAR(256),
user_name VARCHAR(128),
isAdmin BOOL DEFAULT 0);

CREATE TABLE booking(
ref VARCHAR(20) PRIMARY KEY,
uid VARCHAR(60),
status VARCHAR(60) NOT NULL,
checkin DATE,
checkout DATE CHECK(checkout > checkin),
FOREIGN KEY(uid) REFERENCES user(email) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE reserve(
ref VARCHAR(20),
hotelid INT,
room_class INT,
bed_size INT,
no_bed INT,
count INT DEFAULT 1 NOT NULL CHECK(count > 0),
FOREIGN KEY(ref)  REFERENCES booking(ref) ON DELETE CASCADE,
FOREIGN KEY(hotelid, room_class, bed_size, no_bed) 
REFERENCES facility(hotelid, room_class, bed_size, no_bed) ON DELETE SET NULL);




/* Third fill in data */
/* Hotels */
INSERT INTO hotel(hotelname, country, city, street, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel California',
'Singapore',
'Singapore',
'123, California Road',3,
0,0,0,1,1,1,1,0,1,0,1,1,0,0,0,0);

INSERT INTO hotel(hotelname, country, city, street, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel Florida',
'United States of America',
'Florida',
'123, Florida Road',4,
0,1,0,1,1,1,1,0,1,0,1,1,0,1,0,0);

INSERT INTO hotel(hotelname, country, city, street, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel Singapore',
'Singapore',
'Singapore',
'123, Singapore Road',3,
0,0,0,1,0,1,0,0,1,0,1,1,0,0,0,0);

INSERT INTO hotel(hotelname, country, city, street, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel India',
'India',
'New Dheli',
'123, India Road',2,
0,0,0,1,0,0,0,0,1,0,1,1,0,0,0,0);

INSERT INTO hotel(hotelname, country, city, street, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel Vietnam',
'Vietnam',
'Ho Chi Ming',
'123, Vietnam Road',1,
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

/* Facilities */
INSERT INTO facility VALUES(1, 1, 3, 1, '', 100);
INSERT INTO facility VALUES(1, 2, 3, 1, '', 100);
INSERT INTO facility VALUES(1, 3, 3, 1, '', 100);
INSERT INTO facility VALUES(1, 4, 3, 1, '', 100);

/* Users */
INSERT INTO user VALUES('a0000001@abc.com', '123321', 'a1', 0);
INSERT INTO user VALUES('a0000002@abc.com', '123321', 'a2', 0);
INSERT INTO user VALUES('a0000003@abc.com', '123321', 'a3', 0);
INSERT INTO user VALUES('a0000004@abc.com', '123321', 'a4', 0);

/* Bookings */
INSERT INTO booking VALUES('0000001', 'a0000001@abc.com', 'successful', '20130201', '20130210');

/* Reservations */
INSERT INTO reserve VALUES('0000001', 1, 1, 3, 1, 1);
INSERT INTO reserve VALUES('0000001', 1, 2, 3, 1, 1);

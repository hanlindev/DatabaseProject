CREATE TABLE hotel(
hotelid INT PRIMARY KEY AUTO_INCREMENT,
hotelname VARCHAR(128) NOT NULL,
location VARCHAR(256) NOT NULL,
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

CREATE TABLE facility(
hotelid INT REFERENCES hotel(hotelid),
room_class INT CHECK(room_class > 0 and room_class < 6),
bed_size INT CHECK(bed_size > 0 and bed_size < 7),
no_bed INT CHECK(no_bed > 0),
room_desc VARCHAR(256),
room_count INT CHECK(room_count > 0),
PRIMARY KEY(hotelid, room_class, bed_size, no_bed));

CREATE TABLE user(
email VARCHAR(60) PRIMARY KEY,
password VARCHAR(256),
user_name VARCHAR(128),
isAdmin BOOL DEFAULT 0);

CREATE TABLE booking(
ref VARCHAR(20) PRIMARY KEY,
uid VARCHAR(60) REFERENCES user(email),
status VARCHAR(60) NOT NULL,
checkin DATE,
checkout DATE CHECK(checkout > checkin));

CREATE TABLE reserve(
ref VARCHAR(20) REFERENCES booking(ref),
hotelid INT,
room_class INT,
bed_size INT,
no_bed INT,
count INT DEFAULT 1 NOT NULL CHECK(count > 0),
FOREIGN KEY(hotelid, room_class, bed_size, no_bed) 
REFERENCES facility(hotelid, room_class, bed_size, no_bed));

INSERT INTO hotel(hotelname, location, star, sustain_certified, aircon, meeting_rm, pets_allowed, restaurant, car_park, internet, child_facility, no_smoking, biz_centre, reduced_mobility_rm, fitness_club, swimming_pool, thalassotherapy_centre, golf, tennis)
 VALUES(
'Hotel California',
'123, California Road, Singapore',
3,
0,
0,
0,
1,
1,
1,
1,
0,
1,
0,
1,
1,
0,
0,
0,
0);

ALTER TABLE reserve ADD count INT DEFAULT 1 CHECK(count > 0);
ALTER TABLE booking DROP FOREIGN KEY(hotelid, room_class, bed_size, no_bed) REFERENCES facility(hotelid, room_class, bed_size, no_bed);

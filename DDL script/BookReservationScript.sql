/* Unfortunately, mysql doesn't support check, to save time we don't use check
at all, so implement all checking in server end php scripts. :-O for the sake
of easy references, CHECK constraints are still written below but they won't be
parsed. sigh */
/* Schema */
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

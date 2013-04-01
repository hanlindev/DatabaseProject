drop table booking;
drop table facility;
drop table hotel;
drop table user;

SELECT h.hotelid, f.room_count
FROM hotel h, facility f, reserve r, booking b
WHERE h.hotelid = f.hotelid AND
	h.country LIKE '%Singapore%' AND h.city LIKE '%Singapore%' AND h.street LIKE '%123, California Road%' AND h.star=3 AND
	f.room_class=1 AND f.bed_size=3 AND f.no_bed=1 AND
	h.pets_allowed=1 AND h.restaurant=1
GROUP BY h.hotelid, f.hotelid, f.room_class, f.bed_size, f.no_bed, f.room_count
HAVING f.room_count > (
	SELECT SUM(r.count)
	FROM facility f, reserve r, booking b
	WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size AND r.no_bed=f.no_bed AND r.ref=b.ref AND
	b.checkin > '2013-01-31' AND b.checkout < '2013-02-12');

SELECT SUM(r.count)
FROM facility f, reserve r, booking b
WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size AND r.no_bed=f.no_bed AND r.ref=b.ref AND
b.checkin > '2013-01-31' AND b.checkout < '2013-02-12';

SELECT ro.hotelid, ro.room_class, ro.bed_size, ro.no_bed, ro.room_count - re.rCount
FROM (
	SELECT f.hotelid, f.room_class, f.bed_size, f.no_bed, f.room_count
	FROM hotel h, facility f, reserve r, booking b
	WHERE h.hotelid = f.hotelid AND
		h.country LIKE '%Singapore%' AND h.city LIKE '%Singapore%' AND h.street LIKE '%123, California Road%' AND h.star=3 AND
		f.room_class=1 AND f.bed_size=3 AND f.no_bed=1 AND
		h.pets_allowed=1 AND h.restaurant=1
	GROUP BY h.hotelid, f.hotelid, f.room_class, f.bed_size, f.no_bed, f.room_count
	HAVING f.room_count > (
		SELECT SUM(r.count)
		FROM facility f, reserve r, booking b
		WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size AND r.no_bed=f.no_bed AND r.ref=b.ref AND
		b.checkin > '2013-01-31' AND b.checkout < '2013-02-12')) AS ro
JOIN (
	SELECT SUM(r.count) as rCount, r.hotelid, r.room_class, r.bed_size, r.no_bed
	FROM facility f, reserve r, booking b
	WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size AND r.no_bed=f.no_bed AND r.ref=b.ref AND
	b.checkin > '2013-01-31' AND b.checkout < '2013-02-12'
	GROUP BY r.hotelid, r.room_class, r.bed_size, r.no_bed) AS re
ON ro.hotelid = re.hotelid AND ro.room_class = re.room_class AND ro.bed_size = re.bed_size AND ro.no_bed = re.no_bed;


insert into booking values(0000002, 'hanlin.ta@gmail.com', 'successful', '2013-03-20', '2013-03-25');

insert into reserve values(0000002, 1, 1, 3, 1, 10);

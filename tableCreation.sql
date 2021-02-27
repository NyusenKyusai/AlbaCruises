create table users (
userID			integer					NOT NULL auto_increment,
username		varchar(20)				NOT NULL,
password		varchar(100)			NOT NULL,
dateBirth		date					NOT NULL,
email			varchar(50)				NOT NULL,
adminStatus		enum('admin','client')	NOT NULL,
primary key (userID)
);

create table travelSchedule (
portOfDepart	varchar(5)				NOT NULL,
departDay		varchar(10)				NOT NULL,
departTime1		time					NOT NULL,
arrivalTime1	time					NOT NULL,
departTime2		time,
arrivalTime2	time,
timeAshore		decimal(2,1),
primary key (portOfDepart, departDay)
);

create table bookingsInfo (
bookingID		integer					NOT NULL	auto_increment,
userID			integer					NOT NULL,
bookingForename	varchar(50)				NOT NULL,
bookingSurname	varchar(50)				NOT NULL,
address1		varchar(100)			NOT NULL,
address2		varchar(100),
contact			varchar(20)				NOT NULL,
postcode		varchar(20)				NOT NULL,
trueOrigin		varchar(5)				NOT NULL,
trueDestination varchar(5)				NOT NULL,
dateOfTravel	date					NOT NULL,
ticketType		varchar(10),
primary key (bookingID),
foreign key (userID) references users(userID)
);

create table bookingPorts (
bookingID		integer					NOT NULL,
legOfJourney	varchar(5)				NOT NULL,
passTotal		integer					NOT NULL,
legOrigin		varchar(5)				NOT NULL,
legDestination	varchar(5)				NOT NULL,
disability		integer					NOT NULL,
primary key (bookingID, legOfJourney),
foreign key (bookingID) references bookingsInfo(bookingID)
);

create table bookingPassengers (
passNumber		integer					NOT NULL,
bookingID 		integer					NOT NULL,
passForename	varchar(20)				NOT NULL,
passSurname		varchar(20)				NOT NULL,
passType		varchar(10)				NOT NULL,
primary key (bookingID, passNumber),
foreign key (bookingID) references bookingsInfo(bookingID)
);

select passTotal 
from bookingPorts, bookingsInfo
where (bookingPorts.bookingID = bookingsInfo.bookingID)
and (dateOfTravel = '2020-12-28')
and (legOrigin = 'Morar')
and (legDestination = 'Eigg');

select * from users;

select * from travelSchedule;

select * from bookingsInfo;
select * from bookingPorts;
select * from bookingPassengers;

DELETE FROM bookingPassengers WHERE (userID = '1') AND (bookingID = '1');

SELECT portOfDepart FROM travelSchedule WHERE departDay = 'Monday';

SELECT dateOfTravel FROM bookingsInfo WHERE bookingID = '1';

SELECT * FROM Users WHERE username = '123';

SELECT passTotal FROM Bookings WHERE dateOfTravel = '2020-01-01'AND origin = 'Morar';

SELECT LAST_INSERT_ID();

SELECT disability FROM bookingsInfo, bookingPorts WHERE bookingPorts.bookingID = bookingsInfo.bookingID and (dateOfTravel = '2021-01-01')and (legOrigin = 'Morar')and (legDestination = 'Eigg');

SELECT passTotal FROM bookingsInfo, bookingPorts WHERE bookingPorts.bookingID = bookingsInfo.bookingID and (dateOfTravel = '2021-01-01')and (legOrigin = 'Morar')and (legDestination = 'Eigg');

SELECT passForename, passSurname FROM bookingPassengers WHERE (bookingID = '1');

drop table Users;
drop table travelSchedule;
drop table bookingPorts;
drop table bookingPassengers;
drop table bookingsInfo;

UPDATE bookingsInfo SET bookingForename='123', bookingSurname='Juliao Toral', address1='29', address2='123', contact='123', postcode='123' WHERE (bookingID = '') AND (userID = '1');

UPDATE users SET username='1233', password='$2y$10$MZBoq3Y1cUfaKuJVFucGaeB6qAVvcuTGBjOCBBI2U/8p1pWagbKRW', dateBirth='2020-12-25', email='123@gmail.com' WHERE userID = 1 LIMIT 1;

UPDATE users SET adminStatus='admin' WHERE userID = 2 LIMIT 1;

INSERT INTO Users (username, password, dateBirth, email, adminStatus) VALUES ('123', '$2y$10$UwobbbI7r/33csodOhTEH.voXVVXPn2zXjRyIsynbWmrTMiAmKVFC', '2020-12-10', '123@gmail.com', 'client');

INSERT INTO travelSchedule VALUES ('Morar', 'Monday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Tuesday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Wednesday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Thursday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Friday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Saturday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Morar', 'Sunday', '11:00', '17:30', NULL, NULL, NULL);
INSERT INTO travelSchedule VALUES ('Eigg', 'Monday', '12:00', '12:30', '16:00', '16:30', '4.5');
INSERT INTO travelSchedule VALUES ('Eigg', 'Tuesday', '12:00', '12:30', '16:00', '16:30', '5.0');
INSERT INTO travelSchedule VALUES ('Eigg', 'Wednesday', '12:00', '12:30', '16:00', '16:30', '4.5');
INSERT INTO travelSchedule VALUES ('Eigg', 'Friday', '12:00', '12:30', '16:00', '16:30', '4.5');
INSERT INTO travelSchedule VALUES ('Eigg', 'Saturday', '12:00', '12:30', '16:00', '16:30', '5.0');
INSERT INTO travelSchedule VALUES ('Eigg', 'Sunday', '12:00', '12:30', '16:00', '16:30', '4.5');
INSERT INTO travelSchedule VALUES ('Muck', 'Monday', '13:30', '15:30', NULL, NULL, '2.5');
INSERT INTO travelSchedule VALUES ('Muck', 'Wednesday', '13:30', '15:30', NULL, NULL, '2.5');
INSERT INTO travelSchedule VALUES ('Muck', 'Friday', '13:30', '15:30', NULL, NULL, '2.5');
INSERT INTO travelSchedule VALUES ('Muck', 'Sunday', '13:30', '15:30', NULL, NULL, '2.5');
INSERT INTO travelSchedule VALUES ('Rum', 'Tuesday', '13:30', '15:30', NULL, NULL, '2.0');
INSERT INTO travelSchedule VALUES ('Rum', 'Thursday', '12:45', '15:45', NULL, NULL, '3.0');
INSERT INTO travelSchedule VALUES ('Rum', 'Saturday', '13:30', '15:30', NULL, NULL, '2.0');

INSERT INTO bookingsInfo (userID, bookingForename, bookingSurname, address1, address2, contact, trueOrigin, trueDestination) VALUES ('1', '123', '123', '123', '123', '123', 'Morar', 'Muck');
INSERT INTO bookingPorts (bookingID, legOfJourney, passTotal, legOrigin, legDestination, disability) VALUES ('1', 'Leg 1', '1', 'Morar', 'Eigg', '1');
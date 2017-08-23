drop table vlc_boys;
create table vlc_boys(
    id		int(12)		not null primary key auto_increment,
    name	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null,
    sname	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null,
    nick	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci,
    address	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null,
    birthdate	date		not null,
    zdravi	longtext	CHARACTER SET utf8 COLLATE utf8_czech_ci,
    member	tinyint(1)	not null default 1,
    photo	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci default 'blank.jpg',
    telM	int(12),
    telO	int(12),
    mailM	varchar(127)	CHARACTER SET utf8 COLLATE utf8_czech_ci,
    mailO	varchar(127)	CHARACTER SET utf8 COLLATE utf8_czech_ci
);

insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Jan', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Jiří', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Filip', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Hynek', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Ondřej', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Ignác', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Jakub', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Petr', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Pavel', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Josef', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Adam', 'Novák', 'Drtič', '', now(), true );
insert into vlc_boys ( name, sname, nick, address, birthdate, member ) values ( 'Antonín', 'Novák', 'Drtič', '', now(), true );





drop table d2016_members;
create table d2016_members(
    id	int(12)	primary key not null
);

insert into d2016_members ( id ) values ( 1 );
insert into d2016_members ( id ) values ( 2 );
insert into d2016_members ( id ) values ( 3 );
insert into d2016_members ( id ) values ( 4 );
insert into d2016_members ( id ) values ( 5 );
insert into d2016_members ( id ) values ( 6 );
insert into d2016_members ( id ) values ( 7 );
insert into d2016_members ( id ) values ( 8 );
insert into d2016_members ( id ) values ( 9 );
insert into d2016_members ( id ) values ( 10 );
insert into d2016_members ( id ) values ( 11 );
insert into d2016_members ( id ) values ( 12 );
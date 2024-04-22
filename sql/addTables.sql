create table paamelding
(
    id        int auto_increment,
    fornavn   tinytext not null,
    etternavn tinytext not null,
    constraint paamelding_pk
        primary key (id)
);

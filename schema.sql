begin;

CREATE SCHEMA `telefonica` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

use telefonica;

create table user(
    userid int not null primary key auto_increment,
    username varchar(150) not null,
    email varchar(200) not null,
    password varchar(32) not null
);

create table phones(
    telefoneid int not null primary key auto_increment,
    phonenum varchar(100) not null,
    userid int not null,
    constraint fk_userphoes foreign key (userid) references user(userid)
);

INSERT INTO `user` VALUES (2,'Diego Rosa dos Santos','www.diegosantos.com.br@gmail.com','078c007bd92ddec308ae2f5115c1775d');
INSERT INTO `user` VALUES (3,'Administrator','admin@admin.com','21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `phones` VALUES (1,'41 3325-1852',2),
                            (6,'43 3542-8585',2),
                            (7,'43 9995255844',2),
                            (8,'52 5252525',2);
commit;

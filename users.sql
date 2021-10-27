CREATE TABLE `test`.`users`
(
    `id`            INT(255) NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(255) NOT NULL,
    `surname`       VARCHAR(255) NOT NULL,
    `date_of_birth` DATE         NOT NULL,
    `birth_city`    VARCHAR(255) NOT NULL,
    `sex`           INT(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
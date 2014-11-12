
-- Event site group 2 user id and profile RED or GREEN events
CREATE TABLE user (
userId       INT UNSIGNED AUTO_INCREMENT NOT NULL,
email        VARCHAR(128)                NOT NULL,
passwordHash VARCHAR(128)                NOT NULL,
salt         VARCHAR(64)                 NOT NULL,
authToken    VARCHAR(32)                 NOT NULL,
)
CREATE TABLE profile (
profileId  INT UNSIGNED AUTO_INCREMENT   NOT NULL,
userId     INT UNSIGNED                  NOT NULL,
firstName    VARCHAR(32)                 NOT NULL,
lastName     VARCHAR(32)                 NOT NULL,
dateOfBirth  VARCHAR(32)                 NOT NULL,
gender       INT UNSIGNED AUTO_INCREMENT NOT NULL,
PRIMARY KEY(profileId),
UNIQUE (userId),
FOREIGN KEY (userId) REFERENCES user (userId)
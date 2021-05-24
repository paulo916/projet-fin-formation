USE clients
;

DROP TABLE IF EXISTS members
;

CREATE TABLE IF NOT EXISTS members(
	mail VARCHAR(255) PRIMARY KEY,
    pseudo VARCHAR(30) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    active TINYINT,
    status ENUM('A', 'M')
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

-- Cryptage
-- MD5, SHA1, SHA2, etc..

-- Ajouter un membre

-- Cryptage du mail :
SELECT SHA1(CONCAT(MD5('lesly@lodin.org'), LENGTH('lesly@lodin.org')))
;

-- Cryptage du mot de passe :
select SHA2(CONCAT(sha1('secret'), 'lesly@lodin.org'), 512)
;

INSERT INTO members(
	mail, 
    pseudo, 
    pass, 
    active, 
    status)
VALUES(
	SHA1(CONCAT(MD5('lesly@lodin.org'), LENGTH('lesly@lodin.org'))),
	'lesly',
    SHA2(CONCAT(sha1('secret'), 'lesly@lodin.org'), 512),
	0,
    'M'
);

SELECT *
FROM members
;
USE clients
;

DROP TABLE IF EXISTS clients
;

CREATE TABLE IF NOT EXISTS clients(
	mail VARCHAR(255) PRIMARY KEY,
    pseudo VARCHAR(30) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    active TINYINT,
    status ENUM('A', 'M')
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

-- Cryptage
-- MD5, SHA1, SHA2, etc...
SELECT MD5('Flaviu')
; -- 27163f54dcfd24dd45a6acd378e00ebf

SELECT MD5('Kamal')
; -- 908017453b69d6ec045f7919411c56b0

SELECT MD5('$id0n1e')
; -- db53e907aabcbc33e5d491d20e0ac422

-- Ajouter un membre

-- Cryptage du mail :
SELECT SHA1(CONCAT(MD5('ricardomagalhaessousa58@gmail.com'), LENGTH('ricardomagalhaessousa58@gmail.com')))
;

-- Cryptage du mot de passe :
select SHA2(CONCAT(sha1('test'), 'ricardomagalhaessousa58@gmail.com'), 512)
;

INSERT INTO clients(
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
FROM clients
;
CREATE TABLE IF NOT EXISTS forms (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    fio VARCHAR(150) NOT NULL DEFAULT "",
    tel VARCHAR(30) NOT NULL DEFAULT "",
    email VARCHAR(50) NOT NULL DEFAULT "",
    gender VARCHAR(6) NOT NULL DEFAULT "Male",
    birth_date DATE,
    bio TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS langs (
    id_lang INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name_lang VARCHAR(30),
    PRIMARY KEY (id_lang)
);

CREATE TABLE IF NOT EXISTS favlangs (
    id INT(10) UNSIGNED NOT NULL,
    id_lang INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (id, id_lang),
    FOREIGN KEY (id) REFERENCES forms(id),
    FOREIGN KEY (id_lang) REFERENCES langs(id_lang)
);

INSERT INTO langs (name_lang) VALUES
    ('Prolog'),
    ('JavaScript'),
    ('PHP'),
    ('C++'),
    ('Java'),
    ('C#'),
    ('Haskell'),
    ('Clojure'),
    ('Scala'),
    ('Pascal'),
    ('Python');


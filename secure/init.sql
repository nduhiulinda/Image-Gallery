-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );
CREATE TABLE dogs(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL UNIQUE,
  file_name TEXT NOT NULL UNIQUE,
  file_ext TEXT NOT NULL
);

CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL UNIQUE
);

CREATE TABLE dogs_tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  dogs_id INTEGER NOT NULL,
  tags_id INTEGER NOT NULL
);


-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');


INSERT INTO dogs (id, name, file_name, file_ext) VALUES (1, 'Australian Retriever', 'australian_retriever.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (2, 'Cocker Spaniel', 'cocker_spaniel.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (3, 'Collie', 'collie.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (4, 'Corgi Inu', 'corgi_inu.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (5, 'Dalmatian', 'dalmatian.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (6, 'King Shepherd', 'king_shepherd.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (7, 'Mastiff', 'mastiff.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (8, 'Poodle', 'poodle.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (9, 'Pug', 'pug.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (10, 'Rottweiler', 'rottweiler.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (11, 'Spitz', 'spitz.jpg', 'jpg');
INSERT INTO dogs (id, name, file_name, file_ext) VALUES (12, 'Terrier', 'terrier.jpg', 'jpg');



INSERT INTO tags (id, name) VALUES (1, 'Working Dogs');
INSERT INTO tags (id, name) VALUES (2, 'Sporting Dogs');
INSERT INTO tags (id, name) VALUES (3, 'Companion Dogs');
INSERT INTO tags (id, name) VALUES (4, 'Herding Dogs');
INSERT INTO tags (id, name) VALUES (5, 'Mixed Breed Dogs');

INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (1, 7, 1);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (2, 10, 1);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (3, 1, 2);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (4, 2, 2);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (5, 2, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (6, 3, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (7, 4, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (8, 5, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (9, 8, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (10, 9, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (11, 11, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (12, 12, 3);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (13, 3, 4);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (14, 4, 4);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (15, 6, 4);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (16, 1, 5);
INSERT INTO dogs_tags (id, dogs_id, tags_id) VALUES (17, 4, 5);


COMMIT;

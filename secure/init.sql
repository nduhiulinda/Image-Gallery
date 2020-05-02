-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );
CREATE TABLE dogs(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  citation TEXT NOT NULL
);

CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL UNIQUE
);

CREATE TABLE dogs_tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  dog_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL
);


-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');


INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (1, 'Australian Retriever', 'australian_retriever.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (2, 'Cocker Spaniel', 'cocker_spaniel.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (3, 'Collie', 'collie.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (4, 'Corgi Inu', 'corgi_inu.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (5, 'Dalmatian', 'dalmatian.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (6, 'King Shepherd', 'king_shepherd.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (7, 'Mastiff', 'mastiff.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (8, 'Poodle', 'poodle.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (9, 'Pug', 'pug.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (10, 'Rottweiler', 'rottweiler.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (11, 'Spitz', 'spitz.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');
INSERT INTO dogs (id, name, file_name, file_ext, citation) VALUES (12, 'Terrier', 'terrier.jpg', 'jpg', 'https://dogtime.com/dog-breeds/profiles');



INSERT INTO tags (id, name) VALUES (1, 'Working Dogs');
INSERT INTO tags (id, name) VALUES (2, 'Sporting Dogs');
INSERT INTO tags (id, name) VALUES (3, 'Companion Dogs');
INSERT INTO tags (id, name) VALUES (4, 'Herding Dogs');
INSERT INTO tags (id, name) VALUES (5, 'Mixed Breed Dogs');

INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (1, 7, 1);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (2, 10, 1);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (3, 1, 2);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (4, 2, 2);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (5, 2, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (6, 3, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (7, 4, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (8, 5, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (9, 8, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (10, 9, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (11, 11, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (12, 12, 3);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (13, 3, 4);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (14, 4, 4);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (15, 6, 4);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (16, 1, 5);
INSERT INTO dogs_tags (id, dog_id, tag_id) VALUES (17, 4, 5);


COMMIT;

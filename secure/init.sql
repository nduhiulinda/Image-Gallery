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
  file_name TEXT NOT NULL UNIQUE
);

CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL,
  dogs_id INTEGER NOT NULL
);


-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');


INSERT INTO dogs ( name, file_name) VALUES ( 'Australian Retriever', 'australian_retriever.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Cocker Spaniel', 'cocker_spaniel.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Collie', 'collie.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Corgi Inu', 'corgi_inu.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Dalmatian', 'dalmatian.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'King Shepherd', 'king_shepherd.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Mastiff', 'mastiff.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Poodle', 'poodle.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Pug', 'pug.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Rottweiler', 'rottweiler.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Spitz', 'spitz.jpg');
INSERT INTO dogs ( name, file_name) VALUES ( 'Terrier', 'terrier.jpg');



INSERT INTO tags ( name, dogs_id) VALUES ( 'Working Dogs', 7);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Working Dogs', 10);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Sporting Dogs', 2);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Sporting Dogs', 1);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 2);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 3);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 4);
INSERT INTO tags ( name, dogs_id) VALUES ('Companion Dogs', 5);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 8);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 9);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 11);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Companion Dogs', 12);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Herding Dogs', 4);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Herding Dogs', 6);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Herding Dogs', 3);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Mixed Breed Dogs', 4);
INSERT INTO tags ( name, dogs_id) VALUES ( 'Mixed Breed Dogs', 1);



COMMIT;

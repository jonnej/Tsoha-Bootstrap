-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Player (nickname, password, admin) VALUES ('joju', 'joju1', true);
INSERT INTO Player (nickname, password) VALUES ('kris', 'kris1');
INSERT INTO Area (player_id, name, description) VALUES (1, 'Kotimaa', 'Keskustelua kotimaastamme');
INSERT INTO Area (player_id, name, description) VALUES (1, 'Ulkomaat', 'Keskustelua ulkomaista');
INSERT INTO Topic (area_id, player_id, name) VALUES (1, 1, 'Juntein kaupunki');
INSERT INTO Topic (area_id, player_id, name) VALUES (1, 2, 'Paras kaupunki');
INSERT INTO Message (player_id, topic_id, msgtext) VALUES (1, 1, 'Hesa');
INSERT INTO Message (player_id, topic_id, msgtext) VALUES (2, 1, 'Vantaa');
INSERT INTO Message (player_id, topic_id, msgtext) VALUES (1, 2, 'Vantaa');

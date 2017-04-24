-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Player(
  id SERIAL PRIMARY KEY,
  nickname varchar(20) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  added timestamp DEFAULT current_timestamp,
  admin boolean DEFAULT FALSE
);

CREATE TABLE Tag(
  id SERIAL PRIMARY KEY,
  name varchar(20)
);

CREATE TABLE Area(
  id SERIAL PRIMARY KEY,
  player_id INTEGER REFERENCES Player(id),
  name varchar(50) NOT NULL,
  description varchar(150) NOT NULL
);

CREATE TABLE Topic(
  id SERIAL PRIMARY KEY,
  area_id INTEGER REFERENCES Area(id) ON DELETE CASCADE,
  player_id INTEGER REFERENCES Player(id),
  name varchar(75) NOT NULL,
  added timestamp DEFAULT current_timestamp,
  modified timestamp
);

CREATE TABLE Message(
  id SERIAL PRIMARY KEY,
  player_id INTEGER REFERENCES Player(id) ON DELETE CASCADE,
  topic_id INTEGER REFERENCES Topic(id) ON DELETE CASCADE,
  msgtext varchar(1000) NOT NULL,
  added timestamp DEFAULT current_timestamp,
  modified timestamp
);

CREATE TABLE Topictag(
  id SERIAL PRIMARY KEY,
  topic_id INTEGER REFERENCES Topic(id),
  tag_id INTEGER REFERENCES Tag(id)
);

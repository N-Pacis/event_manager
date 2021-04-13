CREATE TABLE IF NOT EXISTS events(
      event_id int auto_increment primary key,
      event_name varchar(255) not null,
      event_description longtext not null,
      event_duration date not null,
      creator int not null,
      FOREIGN KEY(creator) REFERENCES users(user_id) ON UPDATE CASCADE
);
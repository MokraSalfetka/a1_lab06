CREATE TABLE post (
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      subject TEXT NOT NULL,
                      content TEXT NOT NULL
);

CREATE TABLE comment (
                         id INTEGER PRIMARY KEY AUTOINCREMENT,
                         post_id INTEGER NOT NULL,
                         author TEXT NOT NULL,
                         content TEXT NOT NULL,
                         FOREIGN KEY (post_id) REFERENCES post (id)
);

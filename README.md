# ToDo-Website

### Instructions

The per-requisites are that you have a device with docker installed and can run a docker compose file from the given directory. 

### Clone Repo

```
git clone https://github.com/Jj1910/ToDo-Website.git
```

### Run Docker Container

```
docker compose up -d
```

### Configure Database

```
docker exec -it ToDoDB /bin/bash
mysql -u ${MYSQL_USER} -p${MYSQL_PASSWORD}

mysql->use ${MYSQL_DB};

mysql->CREATE TABLE users (
	id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

mysql->CREATE TABLE CREATE TABLE tasks (
  id int NOT NULL AUTO_INCREMENT,
  description varchar(255) NOT NULL,
  user_id int NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
)

INSERT INTO users (username, pwd) VALUES ('admin', '${HASHED PASSWORD}');
```

### Go to http://localhost:9006 to see the website.

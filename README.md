# ToDo-Website

A small PHP + MySQL to-do app packaged for Docker.  Everything — database,
schema, default account, web server — is set up automatically on
`docker compose up`.  There is no manual SQL step.

### Prerequisites

A machine with Docker and the Docker Compose plugin installed.

### Clone Repo

```
git clone https://github.com/Jj1910/ToDo-Website.git
```

### Run

```
docker compose up -d
```

Then open <http://localhost:9006>.

### Default login

| Username | Password  |
|----------|-----------|
| `admin`  | `admin123`|

> **Change this password before using the site anywhere untrusted.**
> The password is stored as a bcrypt hash in `users.pwd`.  To set a new one:
>
> ```
> # 1. Generate a hash
> docker run --rm php:8.3 php -r "echo password_hash('MyNewPassword', PASSWORD_BCRYPT);"
>
> # 2. Store it
> docker compose exec ToDoDB mysql -utodo_user -pSuperSecurePassword todo_site \
>   -e "UPDATE users SET pwd='<paste-hash-here>' WHERE username='admin';"
> ```

### Repeatability

The schema in `db/init.sql` is **idempotent**, and a one-shot `db-init`
service re-applies it on **every** `docker compose up`.  That means:

- a fresh clone just works — the tables and the `admin` user are created for
  you;
- if tables were dropped or the data directory is in a weird state, the next
  `up` recreates/repairs everything automatically.

To reset to a completely blank database:

```
sudo rm -rf ./Data
docker compose up -d
```

### Configuration

Copy `.env.example` to `.env` to override the MySQL account/database
defaults.  The app, the DB and the init service all read the **same**
variables, so overrides apply end-to-end.

| Variable       | Default               | Meaning              |
|----------------|-----------------------|----------------------|
| `MYSQL_USER`   | `todo_user`           | MySQL app user       |
| `MYSQL_PASSWORD` | `SuperSecurePassword` | MySQL password       |
| `MYSQL_DATABASE` | `todo_site`           | database name        |

### Ports

| Host port | Service              |
|-----------|----------------------|
| 9006      | web app (Apache/PHP) |
| 9007      | MySQL (debug access) |

### Troubleshooting

- **`db-init` fails at startup** — the DB didn't come up in time or the
  credentials don't match.  Check `docker compose logs db-init ToDoDB`.
- **App can't reach the database** — check `docker compose logs todosite`;
  the PHP app reads the `MYSQL_*` environment variables (see Configuration).
- **Login works but the page keeps bouncing** — make sure your browser isn't
  blocking the session cookie, and that you're not mixing hosts (the cookie
  is scoped to the host you logged in on).

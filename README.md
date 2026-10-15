# GreenPower CCSM

GreenPower CCSM is an independently installable club-management application.
The dbold.es portfolio and CCSM use separate application code, configuration,
and databases.

## Local development

1. Copy `config/config.example.php` to `config/config.php`.
2. Set the local database connection and URL in `config/config.php`.
3. Create an empty database for CCSM and import/install its schema.
4. Keep uploads, sessions, logs, and `config/config.php` out of Git.

## Hosting

For `ccsm.dbold.es`, configure the subdomain's document root to the CCSM
application directory. Upload this repository's contents there and run
`https://ccsm.dbold.es/install.php`. Configure a dedicated database and
database user for CCSM; do not reuse dbold.es credentials or database.

See [DESPLIEGUE_PRODUCCION.md](./DESPLIEGUE_PRODUCCION.md) for the full
installation and update procedure.

## VS Code SFTP

The optional `Natizyskunk.sftp` extension can upload this project over SFTP.
Copy `.vscode/sftp.json.example` to `.vscode/sftp.json` and fill in the server,
username, and remote application path from FileZilla. The example keeps
upload-on-save disabled and excludes local configuration and runtime data.
The extension prompts for the password if none is stored in its config.

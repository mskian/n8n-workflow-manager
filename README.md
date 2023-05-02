# n8n Workflow Manager

A simple web page to ON and OFF n8n Workflow using webhook Trigger.

## Usage

- PHP for API
- n8n webhook GET for trigger the workflow
- MYSQL PDO database for ON and OFF conditon validation
- Bulma CSS Framework

## Setup

- Create a database setup table and connect it with api
- add the webhook URL and database credentials in `.env` File
- Done

```env

ACTIVATE=https://n8n.example.com/webhook/xxxxxxxxxxxxxxxxx
DEACTIVATE=https://n8n.example.com/webhook/xxxxxxxxxxxxxxx

DBHOST=YOURDBHOST
DBNAME=YOURDBNAME
DBUSERNAME=YOURDBUSERNAME
DBPASSWORD=YOURDBPASSWORD

```

```sql

CREATE TABLE `n8n` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

```

> Still it's on ⚠ WIP if you have any ideas your PR's are Welcome 😊  

**Note**: Don't use this on Production server or any other online platforms use it locally and manage it via localhost server

```sh
# Localhost server using PHP

php -S localhost:5001

```
- Now open your browser with the following URL
```
http://localhost:5001
```

## LICENSE

MIT

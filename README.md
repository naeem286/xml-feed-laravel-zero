# XML Data Feed Task
PHP 8.2
## Description

This Laravel Zero project allows users to parse an XML file, extract data from it, and save it into a database. The project prompts the user to enter the path of the XML file and the desired name for the JSON file. It then performs the following actions:

1. Parses the XML file and saves the extracted data into a JSON file.
2. Inserts the data into a selected database.
3. Supports two types of databases: MongoDB and MySQL. The desired database can be configured in the `.env` file by setting the `DB_CONNECTION` value to either "mongodb" or "mysql".

## Installation

To install the project dependencies, run the following command:

```shell
composer install
```

## Docker

This project utilizes Docker to run the required databases, namely MySQL and MongoDB. To set up the Docker containers, execute the following commands:

```shell
docker-compose build
docker-compose up -d
```

## Usage

- After setting up the Docker containers, run the following command to start the project:

```shell
php qna migrate
```

To start the project, run the following command in the terminal:

```shell
php qna feed:insert
```
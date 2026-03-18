# URL Shortener and Monitoring System

## Description

This project implements a web system that allows users to shorten URLs and monitor their usage. The system generates a short link based on a base URL and redirects users to the original address when accessed.

Additionally, the system records information about each access, including the IP address, access date and time, and the country of origin obtained through an external service. This information is used to provide basic statistics about the usage of each shortened URL.

## Features

* Define a base URL for the system.
* Generate a shortened URL from an original URL.
* Redirect users from the shortened URL to the original URL.
* Log each access with IP address, date, and country.
* Display information for each shortened URL, including:

  * Creation date
  * Total number of accesses
  * List of countries from which the URL was accessed
  * Access frequency grouped by day

## System Overview

The system follows a simple client-server architecture. The backend is responsible for handling URL generation, redirection, and data storage, while the frontend displays the information and statistics to the user.

Each shortened URL is stored along with its original URL and creation date. Every time a user accesses a shortened URL, a new access record is created. This allows the system to compute statistics dynamically using database queries.

## Data Model

The system uses a relational database with two main entities:

* **ShortCut**: Stores the original URL, the generated short code, the base URL, and the creation date.
* **AccessLog**: Stores each access event, including the associated shortcut, IP address, country, and timestamp.

There is a one-to-many relationship between ShortCut and AccessLog, where one shortcut can have multiple access records.

## Distribution

```text
│
├── .github
│   ├── ISSUE_TEMPLATE
│   └── PULL_REQUEST_TEMPLATE.md
│
├── docs
│   ├── research
│   │   ├── software_stack.md
│   │   └── lamp_stack.md
│   └── api_documentation.md
│
├── database
│   ├── schema.sql
│   └── seed.sql
│
├── public
│   ├── index.html
│   ├── css
│   │   └── styles.css
│   ├── js
│   │   ├── app.js
│   │   └── api.js
│   └── assets
│       └── logo.png
│
├── api
│   ├── shorten.php
│   ├── redirect.php
│   └── stats.php
│
├── config
│   └── database.php
│
├── src
│   ├── db.php
│   ├── url_service.php
│   └── utils.php
│
├── README.md
└── .gitignore
```

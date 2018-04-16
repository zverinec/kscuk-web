K-SCUK website
--------------

Author: Jan Papoušek, Jan Drábek, Vendula Němcová, Honza Horáček
Maintenance: <kscuk@fi.muni.cz>

Requirements
------------
 - PHP >= 5.3
 - Composer

Installation
------------
1. Clone this repository
2. Run composer update from the repository root
3. Make /temp and /log and /www/storage writable (recursively)
4. Create /app/config/config.local.neon according to to /app/config/config.neon (overload database info, admin credentials and mailer if neede)
5. Run it!

Usage
-----

Prepare for new event:

 - Create new database (or empty the old one)
 - Prepare questions in /app/import/questions.xml
   BEWARE: that question with name has to contain "jméno a příjmení" and no other question should have this (needed for proper behaviour of health declaration)
           that question with e-mail has to contain "e-mail" and no other question should have this (needed for proper behaviour of health declaration)
 - Prepare /app/config.neon according to comments. Do not forget to set:
      - Registration start and end and other events detail
      - Admin password and address of K-SCUK mailbox
      - Database access
 - Run it ;-) (tables, views etc will be created automatically)

Health declaration:

  - If there are multiple same e-mail addresses it will fail, solution: correct in database
  - Link: /forms/health-declaration

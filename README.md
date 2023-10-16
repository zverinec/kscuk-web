K-SCUK website
==============

 * Author: Jan Papoušek, Jan Drábek, Vendula Němcová, Honza Horáček
 * Maintenance: <kscuk@fi.muni.cz>

## Requirements

 * PHP >= 7
 * Composer

## Installation

 0. Install `composer global require kiwicom/loopbind` for local deployment.
 1. Clone this repository.
 2. Run composer install/update from the repository root.
 3. Make `/temp` and `/log` and `/www/storage` and `/vendor/mpdf/mpdf/tmp`
    writable (recursively).
 4. Create `/app/config/config.local.neon` according to to
    `/app/config/config.neon` (overload database info, admin credentials and
    mailer if neede).
 5. Prepare mapping `loopbind apply`
 6. Run docker `docker-compose up -d`
 7. Access [https://kscuk.test](https://kscuk.test) or [https://kscuk.test:8080](https://kscuk.test:8080) for database access, use `kscuk` and `password1234` credentials. 

## Usage

### Prepare for new event

 * Prepare submission questions in
   [app/import/questions/current.xml](app/import/questions/current.xml).
   BEWARE:
   - question with name has to contain "jméno a příjmení" and no other
     question should have this (needed for proper behaviour of health
     declaration).
   - question with e-mail has to contain "e-mail" and no other question should
     have this (needed for proper behaviour of health declaration)
 * Create new database (or empty the old one).
   - E.g. via <https://kscuk.fi.muni.cz/org>
 * Prepare [app/config/config.neon](app/config/config.neon) according to comments.
   Do not forget to set:
      - Registration start and end and other events detail
      - Admin password and address of K-SCUK mailbox
      - Database access
 * Run it ;-) (tables, views etc will be created automatically)

### Update date, about, status and other info on front page

 * Edit [app/config/config.neon](app/config/config.neon).

### Update orgs on front page

 * Update [app/templates/Default/orgs.latte](app/templates/Default/orgs.latte)
 * In case you need to upload new photo, upload it to
   [www/img/orgs](www/img/orgs)

### Health declaration

 * Questions are hardcoded.
 * If there are multiple same e-mail addresses it will fail,
   solution: correct in database.
 * Beware if the food alergies question changes it needs to be changed in the code 2x.
 * Link: `/forms/health-declaration`

### Add past event to archive

 * Prepare php file with data in `/app/data/archive`, with the year number as
   filename. Copy the data structure from some existing file. (JSON doesn't
   permit breaking long lines for readability, sorry.)
 * Choose up to 12 photos (but ideally exactly 12) to illustrate the event.
   Use `/archive-image-optimizer.py` to get copies of acceptable size and
   thumbnails. The script can be run from commandline, with a path to the photo
   directory as an optional first argument. (If you don't provide any path, the
   script will ask. Make sure your photo directory is accessible and writable.)
 * Create new directory in `/www/img/archive`, with the year number as dirname.
   Move the obtained photos into it.
 * That's all. Please check the website to see if the php structure didn't
   contain any errors.

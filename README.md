K-SCUK website
==============

 * Author: Jan Papoušek, Jan Drábek, Vendula Němcová, Honza Horáček
 * Maintenance: <kscuk@fi.muni.cz>

## Requirements

 * PHP >= 7
 * Composer

## Installation

 1. Clone this repository.
 2. Run composer update from the repository root.
 3. Make `/temp` and `/log` and `/www/storage` and `/vendor/mpdf/mpdf/tmp`
    writable (recursively).
 4. Create `/app/config/config.local.neon` according to to
    `/app/config/config.neon` (overload database info, admin credentials and
    mailer if neede).
 5. Run it!

## Usage

### Prepare for new event

 * Create new database (or empty the old one).
 * Prepare questions in /app/import/questions.xml. BEWARE:
   - question with name has to contain "jméno a příjmení" and no other
     question should have this (needed for proper behaviour of health
     declaration).
   - question with e-mail has to contain "e-mail" and no other question should
     have this (needed for proper behaviour of health declaration)
 * Prepare /app/config.neon according to comments. Do not forget to set:
      - Registration start and end and other events detail
      - Admin password and address of K-SCUK mailbox
      - Database access
 * Run it ;-) (tables, views etc will be created automatically)

### Health declaration

 * If there are multiple same e-mail addresses it will fail,
   solution: correct in database.
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

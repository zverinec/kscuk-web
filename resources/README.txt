K-SCUK web
----------

Supposed to be deployed on KSI server.

Requirements:
 - mod_rewrite enabled
 - Nette support
 - MySQL database

Installation:
 - Perform `chmod 777` on these dirs:
		/app/temp
		/app/log
		/www/storage/health_declaration
		/www/storage/people
 - Set passwords for database and backend in /app/config.ini
 - Check that /app/config.ini (and whole app) is not accessible from browser
 - Run it ;-)

Prepare for new event:
 - Create new database (or empty the old one)
 - Prepare questions in /app/import/questions.xml
   BEWARE: that question with name has to contain "jméno a příjmení" and no other question should have this (needed for proper behaviour of health declaration)
           that question with e-mail has to contain "e-mail" and no other question should have this (needed for proper behaviour of health declaration)
 - Prepare /app/config.ini according to comments. Do not forget to set:
      - Registration start and end
      - Admin password and address of K-SCUK mailbox
      - Database access
      - Ensure that `mode.debug = FALSE debug.enable = FALSE` is set in [production] section
 - Run it ;-) (tables, views etc will be created automatically)

 Health declaration:
  - If there is multiple same e-mail addresse it will fail, solution: correct in database
  - Link: /forms/health-declaration
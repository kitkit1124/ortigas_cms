# Codifire

## Requirements

1. Apache
1. PHP 5.5+ or 7.x
1. MySQL or MariaDB
1. OpenSSL
1. Node.js
1. Libraries
    1. curl
    1. gd
    1. mysql client
1. Domain/subdomain


## Installation

1. Prepare the DNS record. eg. cms.projectname.com
1. Prepare the MySQL/MariaDB database with username and password
1. Create the folder in the web server. eg. /web/cms.projectname.com
1. Clone this project in that folder
    * $ ```cd /web/cms.projectname.com```
    * $ ```git clone http://url.of.git ./```
1. Create a virtual host that points to the created folder adding /pub at the end. eg. /web/cms.projectname.com/pub
1. Open pub/index.php and change the environment
    * ```define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');```
1. Copy app/config/_database.php to app/config/database.php then change the database hostname, username, password and database
1. Copy app/config/_config.php to app/config/config.php then
    1. Change the key_prefix value in $config['cache_drivers'] array
    1. Change the $config['base_url'] variable.  This should be the assigned domain/subdomain. eg. https://cms.projectname.com
    1. If https will be used, change $config['cookie_secure'] to TRUE then enable Rewrite for https in pub/.htaccess
1. Make the following directories writable to Apache user
    * ```app/cache```
    * ```app/logs```
    * ```pub/data/photos```
    * ```pub/data/uploads```
1. In a terminal, type the following:
    * $ ```cd /web/cms.projectname.com```
    * $ ```npm install``` << this will take time
    * $ ```grunt```
1. Install the initial database structure by opening a browser and going to Go to http://{domain/subdomain}/install. eg. https://cms.projectname.com/install
1. In a browser, go to http://{domain/subdomain}. eg. https://cms.projectname.com, login then go to Develop > Modules.  Install all modules.

\* Note: Get the login info from the developer
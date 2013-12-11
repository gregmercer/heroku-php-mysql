<?php 

/*

setup for heroku 

mkdir php-test
cd php-test/
ls
git init
vi index.php

git remote add github git@github.com:gregmercer/php-test.git

git add .
git commit -m 'Initial commit'
heroku create --stack cedar
git push heroku master
git push github master

heroku addons:add cleardb

heroku config --app <app name>
heroku config --app ancient-thicket-2675

.

define ('DB_USER','<user>');
define ('DB_PASSWORD','<pass>');
define ('DB_HOST','<host>');
define ('DB_NAME','<db>');

.

CREATE TABLE pet (name VARCHAR(20), owner VARCHAR(20), species VARCHAR(20), sex CHAR(1), birth DATE, death DATE);

*/

print 'php-test start' . '<br />';

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

$con = mysql_connect($server, $username, $password);
if (!$con) {
	die('Could not connect: ' . mysql_error() . '<br />');
}

echo 'Connected successfully' . '<br />';

$db_selected = mysql_select_db($db, $con);

if (!$db_selected) {
	die ("Can\'t use $db : " . mysql_error() . '<br />');
} else {
	echo "Selected db: $db" . '<br />';
}

$query = "select * from pet";

$rs = mysql_query($query);

if (!$rs) {
  echo "Could not execute query: $query" . '<br />';
  trigger_error(mysql_error(), E_USER_ERROR);
} else {
  echo "Query: $query executed" . '<br />';
}

$row = mysql_fetch_row($rs);

echo "Pet: $row[0] $row[1]" . '<br />';

mysql_close($con);

print 'php-test end' . '<br />';

//phpinfo(); 

?>

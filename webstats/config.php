<?php
//Enable or disable dark theme on navbar
$config["dark_theme"] = false;
//Set navbar title
$config["title"] = "TNTRun Webstats";
//Main background color
$config['background'] = "#FFF";
//Background image URL (leave it blank if you don't want to set a background image)
$config['background_imgurl'] = null;
//Background image repeat (if you set this to false the image will be automatically stretched)
$config['background_imgrepeat'] = false;
//Show a description box in the main page
$config['show_description'] = true;
//Description box text
$config['description'] = "<h2>TNTRun Webstats</h2><br>These are the TNTRun statistics of your server<br><br>You can customize this text from \"config.php\" file."; 
//Show the first three players of the server
$config['show_leaderboard'] = true;
//Number of users to show on the preview list
$config['previewlist_users'] = 15;
//Database provider (0 = MySQL, 1 = SQLite3)
$config['db_provider'] = 0;
//Database host of TNTRun plugin data
$config['db_host'] = "localhost";
//Database port (default 3306)
$config['db_port'] = 3306;
//Database username
$config['db_username'] = "root";
//Database password (you can leave it blank if your database doesn't need password)
$config['db_password'] = "";
//TNTRun database (it must be the one where you stored your TNTRun plugin data)
$config['db_database'] = "tntrun";
//TNTRun database table
$config['db_table'] = "tntstats";
?>

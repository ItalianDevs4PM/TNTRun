<?php
//Main background color
$config['background'] = "#EEE";
//Background image URL (leave it blank if you don't want to set a background image)
$config['background_imgurl'] = null;
//Background image repeat (if you set this to false the image will be automatically stretched)
$config['background_imgrepeat'] = true;
//Show a description box in the main page
$config['show_description'] = true;
//Description box text
$config['description'] = "<h2>TNTRun Webstats</h2><br>These are the TNTRun statistics of your server"; 
//Show the first three players of the server
$config['show_leaderboard'] = true;
//Show preview list
$config['show_previewlist'] = true;
//Number of users to show on the preview list
$config['previewlist_users'] = 15;
//Database provider (0 = MySQL, 1 = SQLite3)
$config["db_provider"] = 0;
//Database host of TNTRun plugin data
$config["db_host"] = "host";
//Database port (default 3306)
$config["db_port"] = 3306;
//Database username
$config["db_username"] = "username";
//Database password (you can leave it blank if your database doesn't need password)
$config["db_password"] = "";
//Database TNTRun database (it must be the one where you stored your TNTRun plugin data)
$config["db_database"] = "tntrun";
?>

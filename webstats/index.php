<!DOCTYPE html>
<?php
	$dark_theme = false;
	$title = "TNTRun Webstats";
	$background = "#FFF";
	$background_imgurl = null;
	$background_imgrepeat = false;
	$cfg_status = file_exists("config.php");
	if($cfg_status){
		include "config.php";
		$dark_theme = $config['dark_theme'];
		$title = $config['title'];
		$background = $config['background'];
		$background_imgurl = $config['background_imgurl'];
		$background_imgrepeat = $config['background_imgrepeat'];
		$db_provider = $config['db_provider'];
		if($db_provider == 0){
			$db = @new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database'], $config['db_port']);
			if($db->connect_error){
				$db_status = false;
			}else{
				$db_status = true;
			}
		}else{
			$db = @new mysqli($host, $username, $password, $database, $port);
			if($this->database->connect_error){
				$db_status = false;
			}else{
				$db_status = true;
			}
		}
	}
	if($dark_theme){
		$dark_theme_html = " navbar-dark";
	}else{
		$dark_theme_html = "";
	}
	if($background_imgurl != null){
		if(!$background_imgrepeat){
			$background_img_html = " background-image: url('" . $background_imgurl . "'); background-size: cover;";
		}else{
			$background_img_html = " background-image: url('" . $background_imgurl . "');";
		}
	}else{
		$background_img_html = "";
	}
	?>
<html lang="en"><head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<title><?php echo $title;?></title>
		<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<!-- Include xWeb js -->
		<script src="js/xWeb.js"></script>
		<!-- Include xWeb Stylesheet -->
		<link rel="stylesheet" href="css/xweb.css">
		<!-- Include Font-Awesome Stylesheet -->
		<link rel="stylesheet" href="css/font-awesome.css">
	</head>
	<body style="background: <?php echo $background . ";" . $background_img_html;?>">
		<nav class="navbar navbar-static nm<?php echo $dark_theme_html;?>">
			<a class="navbar-title" href="index.php"><?php echo $title;?></a>
		</nav>
		<br>
		<div class="content">
			<?php
				if(!$cfg_status){
					drawError("<b><i class=\"fa fa-exclamation-circle\"></i> Configuration file not found!</b><br><br>Please copy the \"config.php\" file on the TNTRun Webstats folder.");
				}else{
					if(!$db_status){
						drawError("<b><i class=\"fa fa-exclamation-circle\"></i> MySQL Error:</b> " . $db->connect_error);
					}else{
						if(!isset($_GET['action'])){
							?>
							<div class="row">
								<?php
									if($config['show_description']){
										echo "<div class=\"box square\">" . $config['description'] . "</div>";
									}
								?>
								<div class="col-rs-12 ns alignment-right">
									<form>
										<input type="hidden" name="action" value="userstats">
										<div class="input-group">
											<input type="text" class="input input" name="user" placeholder="Enter username...">
											<button type="submit" class="button"><i class="fa fa-search"></i> Search</button>
										</div>
									</form>
								</div>
							</div>
							<br>
							<?php
							if($config['show_leaderboard']){
							$array = mysqli_fetch_all($db->query("SELECT * FROM " . $config['db_table'] . " ORDER BY wins DESC"), MYSQLI_ASSOC);
							if($array != null){
							?>
							<div class="row">
								<div class="panel panel-primary" style="position: static;">
									<div class="panel-header">
										<h3 class="panel-title"><i class="fa fa-trophy"></i> Leaderboard</h3>
									</div>
									<div class="panel-content">
										<div class="col-rs-4">
										<?php
										if(isset($array[0])){
											drawThumbnail($array, 0);
										}
										?>
										</div>
										<div class="col-rs-4">
										<?php
										if(isset($array[1])){
											drawThumbnail($array, 1);
										}
										?>
										</div>
										<div class="col-rs-4">
										<?php
										if(isset($array[2])){
											drawThumbnail($array, 2);
										}
										?>
										</div>
									</div>
								</div>
							</div>
							<?php
							}else{
							?>
							<div class="row">
								<div class="panel panel-primary" style="position: static;">
									<div class="panel-header">
										<h3 class="panel-title"><i class="fa fa-trophy"></i> Leaderboard</h3>
									</div>
									<div class="panel-content">
									<?php
										drawInfo("<i class=\"fa fa-info-circle\"></i> No player data found.");
									?>
									</div>
								</div>
							</div>
							<?php
							}
							?>
							<?php
							}
							?>
							<div class="row">
								<div class="panel" style="position: static;">
									<div class="panel-header">
										<h3 class="panel-title"><i class="fa fa-bar-chart"></i> User statistics</h3>
									</div>
									<div class="panel-content">
										<?php
										$array = mysqli_fetch_all($db->query("SELECT * FROM " . $config['db_table'] . " ORDER BY wins DESC"), MYSQLI_ASSOC);
										if($array != null){
										?>
										<table class="table table-selectable">
											<thead>
												<tr>
													<th>#</th>
													<th>Username</th>
													<th>Matches won</th>
													<th>Matches lost</th>
													<th>Total matches</th>
												</tr>
											</thead>
											<tbody>
											<?php
												for($i = 0; $i < $config['previewlist_users']; $i++){
													if(isset($array[$i])){
														drawTable($array, $i);
													}else{
														break;
													}
												}
											?>
											</tbody>
										  </table>
										<a class="button button-primary full-width alignment-center" href="?action=userlist">Show All...</a>
										<?php
										}else{
											drawInfo("<i class=\"fa fa-info-circle\"></i> No player data found.");
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}elseif(strtolower($_GET['action']) == "userstats" && isset($_GET['user'])){
						$array = mysqli_fetch_all($db->query("SELECT * FROM " . $config['db_table'] . " WHERE name='" . $_GET['user'] . "'"), MYSQLI_ASSOC);
						if($array != null){
						?>
						<div class="row">
							<div class="panel" style="position: static;">
								<div class="panel-header">
									<h3 class="panel-title"><i class="fa fa-user"></i><?php echo " " . $array[0]['name'] . " statistics";?></h3>
								</div>
								<div class="panel-content">
									<table class="table table-bordered table-striped">
										<tbody>
										<tr class="info">
											<th>Username:</th>
											<td><?php echo $array[0]['name']; ?></td>
										</tr>
										<tr>
											<th>Matches won:</th>
											<td><?php echo $array[0]['wins']; ?></td>
										</tr>
										<tr>
											<th>Matches lost:</th>
											<td><?php echo ($array[0]['matches'] - $array[0]['wins']) ?></td>
										</tr>
										<tr>
											<th>Wins and losses average: </th>
											<td><?php echo ($array[0]['wins'] / ($array[0]['matches'] - $array[0]['wins'])) ?></td>
										</tr>
										<tr>
											<th>Total matches:</th>
											<td><?php echo $array[0]['matches']; ?></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php
							}else{
						?>
						<div class="row">
							<div class="panel" style="position: static;">
								<div class="panel-header">
									<h3 class="panel-title"><i class="fa fa-exclamation-circle"></i> User not found</h3>
								</div>
								<div class="panel-content">
								<?php drawError("<i class=\"fa fa-exclamation-circle\"></i> User not found in the database.");?>
								</div>
							</div>
						</div>
						<?php
							}
						?>
						<?php
						}elseif(strtolower($_GET['action']) == "userlist"){
						?>
							<div class="row">
								<div class="panel" style="position: static;">
									<div class="panel-header">
										<h3 class="panel-title"><i class="fa fa-bar-chart"></i> User statistics</h3>
									</div>
									<div class="panel-content">
										<?php
										$array = mysqli_fetch_all($db->query("SELECT * FROM " . $config['db_table'] . " ORDER BY wins DESC"), MYSQLI_ASSOC);
										if($array != null){
										?>
										<table class="table table-selectable" style="margin-bottom: 0;">
											<thead>
												<tr>
													<th>#</th>
													<th>Username</th>
													<th>Matches won</th>
													<th>Matches lost</th>
													<th>Total matches</th>
												</tr>
											</thead>
											<tbody>
											<?php
												for($i = 0; $i < count($array); $i++){
													if(isset($array[$i])){
														drawTable($array, $i);
													}else{
														break;
													}
												}
											?>
											</tbody>
										  </table>
										<?php
										}else{
											drawInfo("<i class=\"fa fa-info-circle\"></i> No player data found.");
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}else{
							header("Location: index.php");
						}
					}
				}
			?>
			<hr>
			<p class="alignment-center">Copyright &copy; 2015 <a href="https://github.com/ItalianDevs4PM">ItalianDevs4PM</a> &amp; <a href="http://www.evolsoft.tk">EvolSoft</a>. Licensed under <a href="https://github.com/ItalianDevs4PM/TNTRun/blob/master/LICENSE">GNU GPL v3.0</a></p>
			<p class="alignment-center">Webscript made using <a href="http://xweb.evolsoft.tk" target="_blank">xWeb Framework</a> by <a href="https://twitter.com/Flavius12_" target="_blank">Flavius12</a></p>
		</div>
	</body>
</html>
<?php
function drawError($message){
	echo "<div class=\"alert alert-error square\" style=\"margin-bottom: 0\">" . $message . "</div>";
}

function drawInfo($message){
	echo "<div class=\"alert alert-info square\" style=\"margin-bottom: 0\">" . $message . "</div>";
}

function drawTable($array, $i){
echo "<tr>";
echo "<th>" . ($i + 1) . "</th>";
echo "<td><a href=\"?action=userstats&user=" . $array[$i]['name'] . "\">" . $array[$i]['name'] . "</a></td>";
echo "<td>" . $array[$i]['wins'] . "</td>";
echo "<td>" . ($array[$i]['matches'] - $array[$i]['wins']) . "</td>";
echo "<td>" . $array[$i]['matches'] . "</td>";
echo "</tr>";
}

function drawThumbnail($array, $i){
    echo "<div class=\"thumbnail\">";
    echo "<div style=\"width: 100%; display: block;\">";
	if($i == 0){
		$url = "img/diamond.png";
		$pos = "1st: ";
	}elseif($i == 1){
		$url = "img/gold.png";
		$pos = "2nd: ";
	}elseif($i == 2){
		$url = "img/iron.png";
		$pos = "3rd: ";
	}
	echo "<img src=\"" . $url . "\" style=\"margin-left: auto; margin-right: auto; margin-top: 15px; display: block; height: 96px; width: 96px;\"></div>";
    echo "<div class=\"caption\">";
    echo "<h3 class=\"alignment-center\" id=\"thumbnail-label\">" . $pos . $array[$i]['name'] . "</h3>";
    echo "<h4 class=\"alignment-center out-gray\">" . $array[$i]['wins'] . " Matches won</h4><a class=\"button button-primary full-width alignment-center\" href=\"?action=userstats&user=" . $array[$i]['name'] . "\">View</a>";
    echo "</div>";
    echo "</div>";
}
?>

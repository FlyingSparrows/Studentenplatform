<?php session_start(); 
if (!isset($_SESSION["email"])){
    header ("Location: ../Login/login.php");
    exit();
}
$title = str_replace('_', ' ',$_GET['title']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="../Stylesheet/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/27922e58ca.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <img id="logo" src="../images/logo.png" alt="logo">
                <a id="navhome" href="../index.php?Home">Home</a>
                <a id="navblog" href="../index.php?Blog">Blog</a>
                <a id="navfaq" href="../index.php?FAQ">FAQ</a>
                <a id="navcontact" href="../index.php?Contact">Contact</a> 
                <div id="placelang">
                    <div><a href="../Login/logout.php">Sign out</a></div>
                </div>
                <?php
                ?>
        </header>
        <div id="banner">
            <?php
            	/*Read title from url*/
                $contenttitle = $_GET['title'];
                echo "<h1 id='title'> Blog </h1>";
            ?>
        </div>
        <main>
            <?php
            	/*RSS reader*/
            	$feed = "../include/XML/Article.xml";
            	$entries = array();
	            $xml = simplexml_load_file($feed);
	            $entries = array_merge($entries, $xml->xpath("//item"));	     
	        	foreach($entries as $entry){
	        		if ($entry->title == $title) {
	        			if(empty($entry->img)) {
			?>				<!-- Article content if image is empty-->
	        			<div class="articlecontainer">
	        				<h1 class="readblogtitle"><?= $entry->title ?></h1>
			        		<p class="readblogdesc"><?= $entry->description ?></p>
			        		<p class="readblogcontent"><?=$entry->content ?></p>
	        		    </div>
	        		<?php
	        			}
	        			else {
	        ?>				<!-- Article content if image is not empty-->	        		
	        			<div class="articlecontainer">
                            <h1 class="readblogtitle"><?= $entry->title ?></h1>
                                <p class="readblogdesc"><?= $entry->description ?></p>
                            <div>
                                <img class="readblogimg" src=../<?= $entry->img ?> alt="Article image">
                                <p class="readblogcontent"><?= $entry->content ?></p>
                            </div>
	        		    </div>

	        <?php
	        	} } } /*Closing brackets. 3 of them.*/
            ?>
        </main>
        <footer>       
            <p id="footerdate"> &copy; 2020 - 2021</p>
            <p id="footerprivacy"> <a class="footerwhite" href="https://www.nhlstenden.com/over-nhl-stenden/over-deze-website/privacy-statement" target="_blank">privacystatement</a> - <a class="footerwhite" href="../index.php?Profile">profile<i class="fas fa-user"></i></a></p>
        </footer>
    </body>
</html>

        <?php
       /*Check the value from the category selector, and put it in the variable $selectedcategory*/
            if(isset($_POST["submitblogfeed"])) {
                $selectedcategory = $_POST['blogselector'];
            }
        ?>        
        <?php
        //default feed
            if (empty($selectedcategory)) {
            $selectedcategory = "everything";
        }
        $feeds = array(
        "include/XML/Article.xml"
        );

        $entries = array();
        foreach($feeds as $feed) {
            $xml = simplexml_load_file($feed);
            $entries = array_merge($entries, $xml->xpath("//item"));
        }
        
        //Sort feed entries by pubDate
        usort($entries, function ($feed1, $feed2) {
            return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
        });
        ?>
        <div class="blogcontent">
            <div class="selectorcontainer">
                <!-- Category selector -->
            	<p>Select category:</p>
            	<form action="index.php?Blog" method="post"> 
    	        	<select class="blogselect" name="blogselector">
    	        		<option value="everything">Everything</option>
    	        		<option value="News">News</option>
    	        		<option value="Corona">Corona</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Important">Important</option>
            		</select>
            		<input class="bloginput" type="submit" name="submitblogfeed" value="Submit"/>
            	</form>
            </div>
            <!--PHP to make the ADD POST button invisible to students -->
                <?php
                if($_SESSION['userlevel'] === 'docent'){
                    echo'<div class="add-blog-button"><a class="add-blog-button" href="index.php?AddBlog">
                    <p><i class="fas fa-plus-circle"></i> Add Post</p></a></div>';
                }
                ?>
            <!-- JS based search box -->
            <div class="searchcontainer">
                <div>
		            <input type="text" id="search" placeholder="Search..." class="searchbarbutton">
		            <input class="searchButton" type="button" name="search" value="Go" onclick="search(document.getElementById('search').value)">
                   <!--  Reset button -->
                    <input class="searchButton" type="button" name="reset" value="Reset" onclick="document.location.href='index.php?Blog'">
        		</div>
            </div>        	
        </div>
        <!-- Flexbox with the contents of the RSS reader -->
        <div id="searchResultsBlog"></div>   
        <div id="blogcontentflex">	
            <?php
            //Print all the entries
            foreach($entries as $entry){
                /*Check if the category matches the selected value before printing it*/
                if (stristr($entry->category, $selectedcategory) OR ($selectedcategory == "everything")) {
                    if(empty($entry->img)) {
                ?>            
                <div>
                	<div class="blogs">
                        <br>
                        <p class="blogcategory <?= $entry->category?>"><?= $entry->category?></p>
	                    <h3><?= $entry->title ?></h3>
	                    <p><i><?= strftime('%A %e %B %Y %R', strtotime($entry->pubDate)) ?></i></p>
	                    <p class="nooverflow"><?= $entry->description ?></p>                        

                        <a class="leesmeer" href="Blog/readblog.php?title=<?=str_replace(" ", "_", $entry->title)?>">Read More</a>
                	</div>	            
            	</div>
            <?php 
                } else {                
            ?>
            <div>
                <div class="blogs">
                    <br>
                    <p class="blogcategory <?= $entry->category?>"><?= $entry->category?></p>
                    <h3><?= $entry->title ?></h3>
                    <p><i><?= strftime('%A %e %B %Y %R', strtotime($entry->pubDate)) ?></i></p>
                    <img class="blogimg" src=<?= $entry->img?> alt="Article image">
                    <p class="nooverflow"><?= $entry->description ?></p>                        
                    <a class="leesmeer" href="Blog/readblog.php?title=<?= str_replace(" ", "_", $entry->title)?>">Read More</a>
                    </div>              
                </div>
            <?php  } } }
        	?>
            <!-- end of print -->
        </div>
	        <script>
		        function search(string){
		            var content = document.getElementsByClassName("blogs");
		            var searchValue = string;
		              var canvas = document.getElementById("searchResultsBlog");
		            for(var i = 0; i < content.length; i++){
		              if(content[i].innerHTML.indexOf(searchValue) > -1){
		              canvas.appendChild(content[i]);		              
		              } else {
		              }
		              console.log(canvas);
		            }
		            document.getElementById("blogcontentflex").style.cssText = 'visibility: hidden';
		        }
            </script>
            







            
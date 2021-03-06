<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../Stylesheet/style.css">
        <meta charset="UTF-8">
        <title>Register | AQA</title>
    </head>
    <body id="bodyLogin"> 
        <main>
            <?php
            // old and not improved registratie systeem
                if(isset($_POST['register'])) {
                    $msg = "yikes";
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    if(!empty($email) && !empty($password)) {
                        $stringB = $email;
                        $find = "nhlstenden.com";
                        $resultaat = strchr($stringB,$find);  
                        if (strpos($resultaat, "nhlstenden.com") === FALSE) {
                            $acces = FALSE;
                        }
                        else {
                            $acces = TRUE;
                            $msg = "";
                        }
                        if ($acces === FALSE){
                            $msg = "<p id='NoMatch'><i/>U heeft geen toegang tot dit platform zonder gebruik van een NHL Stenden account</i></p><br>";
                        }
                        else {
                            $stringA = $email; 
                            $toFind = "@";
                            $result = strchr($stringA,$toFind);
                            if(strpos($result, "student") === FALSE){
                                $level = "docent";
                        }
                        else {
                            $level = "student";
                        }       
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $xml = simplexml_load_file("../include/XML/login.xml");
                        $sxe = new simpleXMLElement($xml->asXML());
                        $user = $sxe->addChild("user");
                        $user->addChild("gebruiker",$email);
                        $user->addChild("wachtwoord",$hash);
                        $user->addChild("level",$level);
                        $sxe->asXML("../include/XML/login.xml");                            
                        header('location:login.php');
                        }
                    }
                }
            ?> 
            <div class="containerLogin"> 
                <div class="formboxLogin">
                    <div Id="imgRegister">
						<h1 id="Loginh1">Register</h1>
						<img id="imageL" src="../Images/logo.png">
					</div>
                        <hr class="hrLogin">
                        <form action="register.php" method="POST">
                            <label for="email"><b>Email</b></label>
                            <input class="inputLogin" type="text" placeholder="Enter Email" name="email" id="email" required>
                            <label for="psw"><b>Password</b></label>
                            <input class="inputLogin" type="password" placeholder="Enter Password" name="password" id="password" required minlength="8">
                            <label for="psw2"><b>Repeat Password</b></label>
                            <input class="inputLogin" type="password" placeholder="Repeat Password" name="passwordconfirm" id="passwordconfirm" required minlength="8">
                            <hr class="hrLogin">
                        <?php
                            if(isset($POST['register'])){
                                if($_POST['password'] !== $_POST['passwordconfirm']) {
                                    echo "<p class='NoMatch'>Passwords do not match, please try again.<p>";
                                }
                                if(strlen($_POST['password']) <= 7 || strlen($_POST['passwordconfirm']) <= 7) {
                                    echo "<p class='NoMatch'>Your password is too short. Please fill in at least 8 characters.<p>";
                                }                        
                            }
                            if (!empty($msg)) {
                                echo $msg;
                            }
                        ?>
                        <p class="TenS">By making an account, you agree to our <a class="aLogin" href="https://www.nhlstenden.com/privacyverklaring" target=_blank>Terms of Service</a>.</p>
                        <input type="submit" value="Register" name="register" class="registerbtn">
                        <div class="signin">
                            <p class="AlreadyAcc">Already have an account? <a class="aLogin" href="login.php">Sign in</a>.</p>
                        </div>
                        <?php 
                            if(isset($_POST['register'])) {
                                if($_POST['password'] !== $_POST['passwordconfirm']) {
                                    exit;
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
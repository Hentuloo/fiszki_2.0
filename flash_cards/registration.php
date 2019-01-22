<?php
session_start();
//if(isset($_SESSION['active_user'])){
//    header('location: fiszki.php');
//    exit();
//}
if (isset($_POST['login']))
{
    $flag = true;//form result positive
    $login = trim($_POST['login']);
    if(strlen($login)<3 || strlen($login)>30){
        $flag=false;
        $_SESSION['e_login']='Nick musi posiadać od 3 do 20 znaków!';
    }
    if (ctype_alnum($login)==false)
		{
			$flag=false;
			$_SESSION['e_login']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
    
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
   if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($email!=$email)){
    $flag=false;
    $_SESSION['e_email']="Podaj poprawny adres e-mail!";
   }
    
    $pass1 = $_POST['passFirst'];
    $pass2 = $_POST['passSecond'];
    if ((strlen($pass1)<8) || (strlen($pass1)>20))
		{
			$flag=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($pass1!=$pass2)
		{
			$flag=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}	

    $password_hash = password_hash($pass1, PASSWORD_DEFAULT);
    
      
//    $reCaptchaCode = '';
//    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$reCaptchaCode.'&response='.$_POST['g-recaptcha-response']);
//    
//    $check = json_decode($check);
//    
//    if ($check->success==false)
//		{
//			$flag=false;
//			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
//		}		
		if(!isset($_POST['regulations'])){
            $flag=false;
			$_SESSION['e_regulations']="Chcąc założyć konto musisz zakceptować nasz regulamin";
        }
    
    //save value from post
    $_SESSION['f_login']=$_POST['login'];
    $_SESSION['f_email']=$_POST['email'];
    
    if($flag){
        require_once "base.php";
        
        $query = $db->prepare("SELECT id FROM users WHERE email = :email");
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute(); 
        
        if($query->rowCount()>0){
            $flag=false;
            $_SESSION['e_email']="Taki email jest już zarejestrowany";  
        }
        
        $query = $db->prepare("SELECT id FROM users WHERE login = :login");
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute(); 
        
        if($query->rowCount()>0){
            $flag=false;
            $_SESSION['e_login']='Taki nick jest już zajęty :('; 
        }
       
        if($flag){
$query = $db->prepare("INSERT INTO users (id, login, email, pass, chapters_max) VALUES (NULL, :login, :email, :pass, '3')");
$query->bindValue(':login', $login, PDO::PARAM_STR);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->bindValue(':pass', $password_hash, PDO::PARAM_STR);
$query->execute(); 
$_SESSION['hello']='true';       
    header('Location: hello.php');
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<body>
<section class="form restriction">
    <form action='registration.php' method="post" class="login">
        <h1>Tworzenie nowego konta</h1>
        <fieldset>
            <legend>Login:</legend><input type="text" name="login" <?=(isset($_SESSION['f_login']))?'value="'.$_SESSION['f_login'].'"':'';
        ?>>
        <?php 
            if(isset($_SESSION['e_login'])){ echo '<div class="error_form">' .$_SESSION['e_login'].'</div>'; unset($_SESSION['e_login']); } ?>
        </fieldset>
        <fieldset>
            <legend>E-mail:</legend><input type="email" name="email"
        <?=(isset($_SESSION['f_email']))?'value="'.$_SESSION['f_email'].'"':'';
        ?>>
            <?php 
            if(isset($_SESSION['e_email'])){ echo '<div class="error_form">' .$_SESSION['e_email'].'</div>'; unset($_SESSION['e_email']); } ?>
        </fieldset>
        <fieldset>
            <legend>Hasło:</legend><input type="password" name="passFirst">
             <?php 
            if(isset($_SESSION['e_password'])){ echo '<div class="error_form">' .$_SESSION['e_password'].'</div>'; unset($_SESSION['e_password']); } ?>
        </fieldset>
        <fieldset>
            <legend>Powtórz hasło:</legend><input type="password" name="passSecond">
        </fieldset>
       <br>
        <label>Akceptuje regulamin:<input type="checkbox" name="regulations"></label>
         <?php 
        if(isset($_SESSION['e_regulations'])){
            echo'<div class="error_form">'.$_SESSION['e_regulations']."</div>";
            unset($_SESSION['e_regulations']);
        }
        ?>
        <br>
        
 <div class="g-recaptcha" data-sitekey="6Le_MIcUAAAAAHqSLWxIncHUN0lTk8l6Su56GQa3"></div>
    <?php 
        if(isset($_SESSION['e_bot'])){
            echo'<div class="error_form">'.$_SESSION['e_bot']."</div>";
            unset($_SESSION['e_bot']);
        }
        ?>
        <input type="submit" value="REJESTRACJA">
    </form>
    </section>
</body>

</html>
<?php
session_start();
if(isset($_SESSION['active_user'])){
    header('location: fiszki.php');
    exit();
}
if (isset($_POST['login'])) {
    $login = trim($_POST['login']);
    $pass = filter_input(INPUT_POST, 'password');
    
    if (ctype_alnum($login)==false)
		{
        $_SESSION['e_login']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}else{
        require_once'base.php';
        $query = $db->prepare("SELECT id, pass FROM users WHERE login = :login");
        $query->bindValue(':login', $login, PDO::PARAM_STR);
		$query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount()>0){
        if ($user && password_verify($pass, $user['pass'])) {
            $_SESSION['active_user']=$user['id'];
            unset($_SESSION['bad_attempt']);
            header('location: fiszki.php');
            exit();
            }
            else{
                $_SESSION['bad_attempt'] = true;
            }
        }
        else{
            $_SESSION['bad_attempt'] = true;
        }
    }
     $_SESSION['f_login']= $_POST['login']; 
}


?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>
<body>
  <section class="form">
  <h1>Fiszki: technika nauki słówek</h1>
   <form action='index.php' method="post" class="login">
         <fieldset>
            <legend>Login:</legend><input type="text" name="login" placeholder="Login" <?=(isset($_SESSION['f_login']))?'value="'.$_SESSION['f_login'].'"':'';
        ?>></fieldset>
        <fieldset><legend>Password:</legend><input type="password" name="password" placeholder="Password"></fieldset><br>
        <?php
    if(isset($_SESSION['bad_attempt'])){
        echo '<span>Logowanie nie powiodło się. Proszę wpisać poprawne dane.</span>';
        unset($_SESSION['bad_attempt']);
    }
    ?>
        <input type="submit" value="LOGIN">
   </form>
   </section>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <label for="login">Login here</label>
    <form action="Login.php" method="post">
        <div id="login">
            <input type="text" id="loginName" placeholder="Username" class="inputField"><br>
            <input type="text" id="loginPass" placeholder="Password" class="inputField"><br>
            <button type="submit" id="loginBtn">Login</button>
        </div>
    </form>
    <br>
    <br> 
    <label for="signup">Signup here</label>
    <form action="Signup.php" method="post">
        <div>
            <input type="text" id="signupName" placeholder="Username" class="inputField" name="username"> <br>
            <input type="text" id="signupPass" placeholder="Password" class="inputField" name="password"> <br>
            <input type="email" id="signupEmail" placeholder="Email" class="inputField" name="email"> <br>
            <button type="submit" id="signupBtn">Signup</button>
        </div>
    </form>

</body>
</html>
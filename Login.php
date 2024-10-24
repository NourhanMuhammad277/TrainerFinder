<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Trainer Finder</title>
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: 'Jost', sans-serif;
			background: url("images/t.jpg") no-repeat center/cover;
			display: flex; /* Use flexbox */
			justify-content: center; /* Center horizontally */
			align-items: center; /* Center vertically */
			height: 100vh; /* Full viewport height */
		}
		#nav {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
            position: fixed; /* Fix the navbar at the top */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000; /* Ensure navbar stays on top of all content */
        }
        .navbar-brand img {
            height: 30px;
            width: 30px;
            margin-right: 10px;
        }
		.main {
			width: 350px;
			height: 500px;
			background: rgba(255, 255, 255, 0.8);
			overflow: hidden;
			border-radius: 10px;
			box-shadow: 5px 20px 50px rgba(0, 0, 0, 0.5);
			margin-top: 100px; /* You can remove this if you center it vertically */
		}
		#chk {
			display: none;
		}
		.signup, .login {
			position: relative;
			width: 100%;
			height: 100%;
		}
		label {
			color: green;
			font-size: 2.3em;
			justify-content: center;
			display: flex;
			margin: 60px;
			font-weight: bold;
			cursor: pointer;
			transition: .5s ease-in-out;
		}
		input {
			width: 60%;
			height: 20px;
			background: #e0dede;
			justify-content: center;
			display: flex;
			margin: 20px auto;
			padding: 10px;
			border: none;
			outline: none;
			border-radius: 5px;
		}
		button {
			width: 60%;
			height: 40px;
			margin: 10px auto;
			justify-content: center;
			display: block;
			color: black;
			background: green;
			font-size: 1em;
			font-weight: bold;
			margin-top: 20px;
			outline: none;
			border: none;
			border-radius: 5px;
			transition: .2s ease-in;
			cursor: pointer;
		}
		button:hover {
			background: #6d44b8;
		}
		.login {
			height: 460px;
			background: white;
			border-radius: 60% / 10%;
			transform: translateY(-180px);
			transition: .8s ease-in-out;
		}
		#chk:checked ~ .login {
			transform: translateY(-500px);
		}
		#chk:checked ~ .login label {
			transform: scale(1);	
		}
		#chk:checked ~ .signup label {
			transform: scale(.6);
		}
	</style>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-success" id="nav">
        <a class="navbar-brand" href="#">
            <img src="images/ss.png" alt="Logo">
            Trainer Finder
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="Home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Trainers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Login.php"><i class="fas fa-user"></i></a>
                </li>
            </ul>
        </div> 
    </nav>
	
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

		<div class="signup">
			<form>
				<label for="chk" aria-hidden="true">Sign up</label>
				<input type="text" name="txt" placeholder="User name" required="">
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="pswd" placeholder="Password" required="">
				<button>Sign up</button>
			</form>
		</div>

		<div class="login">
			<form>
				<label for="chk" aria-hidden="true">Login</label>
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="pswd" placeholder="Password" required="">
				<button>Login</button>
			</form>
		</div>
	</div>

	<!-- Bootstrap JS and dependencies -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

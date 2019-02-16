<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a class="navbar-brand" href="/">Say Hi</a>
            <a class="btn btn-outline-dark" href="/register">Register</a>
        </nav>
        <div class="jumbotron">
            <h3 class="display-4">Hey there, Wanna say hi to your friend</h3>
        </div>

        <p>
        <h3>Login to continue</h3>
        </p>
        <form>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="button" class="btn btn-primary" onclick="login()">Login</button>
        </form>
        <p>Don't have an account, don't worry we've got you covered <a href="/register">Click here to Register</a></p>
    </div>
    <script>
        function login() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let postData = {
                email,
                password
            };

            fetch('http://localhost:8000/api/login', {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(postData)
            })
            .then(res => res.json())
            .then(res => {
                const token = res.success.token;
                const user = res.success.user;
                localStorage.setItem('token', token);
                localStorage.setItem('user', JSON.stringify(user));
                window.location.href='/dashboard';
            })
            .catch(e => console.log(e));
        }
    </script>
</body>
</html>
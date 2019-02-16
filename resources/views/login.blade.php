<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
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
                localStorage.setItem('token', token);
                window.location.href='/dashboard';
            })
            .catch(e => console.log(e));
        }
    </script>
</body>
</html>
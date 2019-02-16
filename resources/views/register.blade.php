<html>
<head>
    <title>Register | Say Hi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="/">Say Hi</a>
        <a class="btn btn-outline-dark" href="/">Login</a>

    </nav>
    <h3>Create your account</h3>
    <form>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" required class="form-control" id="name" aria-describedby="nameHelp" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" required class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" required class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" required class="form-control" id="c_password" placeholder="Confirm password">
        </div>
        <button type="button" class="btn btn-primary" onclick="register()">Register</button>
    </form>
</div>
<script>
    function register() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const c_password = document.getElementById('c_password').value;
        if (password !== c_password) {
            alert('Password and confirm password should be same.');
            return;
        }
        const postData = {
            name,
            email,
            password,
            c_password
        };

        fetch('http://localhost:8000/api/register', {
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
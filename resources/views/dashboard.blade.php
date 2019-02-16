<html>
<head>
    <title>Dashboard | Say Hi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .content {
            width: 100%;
            height: 5px;
            overflow-x: hidden;
            display: none;
        }

        .loader {
            height: 5px;
            width: 100%;
            background-color: blue;
            animation: loading_anim 1.5s ease-in-out infinite;
        }

        @keyframes loading_anim {
            0%  { transform: translateX(-100%) }
            100% { transform: translateX(100%) }
        }

        .active {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="#">Say Hi</a>
        <button class="btn btn-outline-dark" id="logout" onclick="logout()">Logout</button>
    </nav>



    <div class="jumbotron">
        <h3 class="display-4">Hello, <span id="user"></span>! You've got some Hi</h3>
    </div>

    <p>Why wait pick a friend to say Hi</p>
    <form class="form-inline">
        <div class="form-group">
            <select class="form-control" id="users">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="sayHi()">Say Hi!</button>
    </form>

    <div id="loader" class="content">
        <div class="loader"></div>
    </div>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">From</th>
            <th scope="col">Time</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>

</div>
<script>
    function getMessages() {
        document.getElementById('loader').classList.add('active');
        fetch('http://localhost:8000/api/messages', {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "Authorization": `Bearer ${token}`,
            }
        })
        .then(res => {
            if (res.status === 403 || res.status === 401) {
                alert('Please login first');
                window.location.href='/';
            } else if (res.status === 500) {
                alert('An unexpected error occured, Please try again later')
            } else if (res.status === 200) {
                return res.json()
            }
        })
        .then(res => {
            let row = '';
            for (let i = 0; i < res.messages.length; i++) {
                row += `
                    <tr>
                        <th>${res.messages[i].id}</th>
                        <th>${res.messages[i].from.name}</th>
                        <th>${res.messages[i].created_at}</th>
                    </tr>
                `;
            }
            document.getElementById('loader').classList.remove('active');
            document.getElementById('tableBody').innerHTML = row;
        })
        .catch(e => console.log(e));
    }

    function getUsers() {
        fetch('http://localhost:8000/api/users', {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "Authorization": `Bearer ${token}`,
            }
        })
        .then(res => {
            if (res.status === 403 || res.status === 401) {
                alert('Please login first');
                window.location.href='/';
            } else if (res.status === 500) {
                alert('An unexpected error occured, Please try again later')
            } else if (res.status === 200) {
                return res.json()
            }
        })
        .then(res => {
            let users = '';
            for (let i = 0; i < res.users.length; i++) {
                users += `<option value="${res.users[i].id}" ${res.users[i].id === user.id ? 'disabled' : ''}>${res.users[i].name}</option>`;
            }
            document.getElementById('users').innerHTML = users;
        })
        .catch(e => console.log(e));
    }

    function logout() {
        fetch('http://localhost:8000/api/logout', {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Authorization": `Bearer ${token}`,
            }
        })
        .then(res => {
            if (res.status === 200) {
                localStorage.clear('token');
                localStorage.clear('user');
                window.location.href='/'
            }
        })
        .catch(e => console.log(e));
    }

    function sayHi() {
        let to = document.getElementById('users').value;
        let postData = { to };

        fetch('http://localhost:8000/api/sayhi', {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
            },
            body: JSON.stringify(postData)
        })
        .then(res => {
            if (res.status === 200) {
                alert('Sent');
            } else {
                alert('Some error occured, Please try later!');
            }
        })
        .catch(e => console);
    }

    const user = JSON.parse(localStorage.getItem('user'));
    const token = localStorage.getItem('token');
    document.getElementById('user').innerText = user.name;

    getUsers();
    getMessages();
</script>
</body>
</html>
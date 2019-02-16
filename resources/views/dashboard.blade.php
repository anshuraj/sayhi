<html>
<head>
    <title>Login</title>
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
        const token = localStorage.getItem('token');
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
    getMessages();
</script>
</body>
</html>
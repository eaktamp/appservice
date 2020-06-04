<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <strong>LOGIN</strong>
                </a>
            </div>
        </div>
    </header>

    <main role="main">
        <section class="jumbotron12321 text-center">
            <div class="container">
                <h1>โปรดเลือกหน้าเข้าสู่ระบบ</h1>
                <p>
                    <div class="row ">
                        <div class="col-md-1"></div>

                        <div class="col-md-5">
                            <a href="./admin1/login.php">
                                <div class="card mb-4 shadow-sm">
                                    <img src="./img/Snag_4176071d.png" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        หน้าแอดมิน
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-5">
                            <a href="./checkdata.php">
                                <div class="card mb-4 shadow-sm">
                                    <img src="./img/Snag_4172c2a0.png" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        หน้าผู้ใช้งาน
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                </p>
            </div>
        </section>
    </main>

    <footer class="text-muted">
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

</body>

</html>

<style>
    .jumbotron12321 {
        padding: 2rem 1rem;
        margin-bottom: 2rem;
        border-radius: .3rem;
    }
    a {
        cursor: pointer;
        color: black;
    }
    a:hover {
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        color: green;
    }
</style>
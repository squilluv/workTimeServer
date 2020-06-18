<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.css" />
    <link href="/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/css/mdb.min.css" rel="stylesheet">
    <link href="/template/css/style.min.css" rel="stylesheet">
    <title>Авторизация</title>
    <style>
        html,
        body,
        header,
        .view {
            height: 100vh;

        }

        @media (max-width: 740px) {

            html,
            body,
            header,
            .view {
                height: 100vh;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {

            html,
            body,
            header,
            .view {
                height: 600px;
            }
        }
    </style>
</head>

<body>
    <div id="auth"><br><br><br><br><br><br><br>
        <div class="container py-5 z-depth-1 col-sm-6">
            <section class="px-md-5 mx-md-5 text-center text-lg-left black-text">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <form class="text-center col-sm-12" action="" method="post">

                            <p class="h3 mb-5">Авторизация</p>

                            <input type="text" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Логин" name="login">
                            <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Пароль" name="password">

                            <button class="btn btn-black btn-block my-4" name="submit" type="submit">Войти</button>

                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript" src="/template/js/popper.min.js"></script>
    <script type="text/javascript" src="/template/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/js/mdb.min.js"></script>
</body>

</html>
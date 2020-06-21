<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Рабочее время</title>
    <link src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.css">

    </link>
    <link href="/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/css/mdb.min.css" rel="stylesheet">
    <link href="/template/css/style.min.css" rel="stylesheet">
    <style>
        .bcw {
            width: 30px;
            height: 30px;
            background: #fff;
            border-radius: 50%;
            border: 1px solid black;
        }

        .cw {
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            border: 1px solid black;
        }

        .cg {
            width: 20px;
            height: 20px;
            background: rgb(4, 248, 85);
            border-radius: 50%;
            border: 1px solid black;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
        }
    </style>
</head>

<body class="grey lighten-3">

    <header>
        <div class="sidebar-fixed position-fixed">

            <a class="ml-3 mt-3 black-text" href="/">

                <h3>
                    Рабочее время
                </h3>

            </a>

            <div class="list-group list-group-flush mt-5" id="lgu">
                <?php foreach ($users as $user) : ?>
                    <a class="list-group-item list-group-item-action waves-effect" href="/user/<?php echo $user['id_computer'] ?>">
                        <?php echo $user['owner'] ?> <?php if ($user['online'] == "1") : ?><button class="cg"></button><?php else : ?><button class="cw"></button><?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="fixed-bottom mb-5 ml-2">
                <button class="btn btn-white" data-toggle="modal" data-target="#AddMachine">Добавить
                    компьютер</button><br>
            </div>

        </div>

    </header>
    <main class="pt-1 mx-lg-5">
        <div class="modal fade" id="AddMachine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Добавление машины</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text" id="defaultForm-email" class="form-control validate" name="comp">
                                <label data-error="wrong" data-success="right" for="defaultForm-email">Имя компьютера</label>
                            </div>

                            <div class="md-form mb-4">
                                <i class="fas fa-lock prefix grey-text"></i>
                                <input type="text" id="defaultForm-pass" class="form-control validate" name="owner">
                                <label data-error="wrong" data-success="right" for="defaultForm-pass">Владелец</label>
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-white" type="submit" name="addMachine">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="row wow fadeIn">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="col-sm-12" method="post" action="">
                                <div class="md-form input-group mb-4">
                                    <div class="input-group-append">
                                        <input type="datetime-local" class="form-control" name="date1" value="<?php echo $date1 ?>">
                                    </div>
                                    <div class="input-group-append">
                                        <input type="datetime-local" class="form-control" name="date2" value="<?php echo $date2 ?>">
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-black" type="submit" name="filter">Фильтровать</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-1">
            <div class="row wow fadeIn">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active black-text" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">Скриншоты</a>
                                </li>
                                <li class="nav-item ml-5">
                                    <a class="nav-link  black-text" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">Процессы</a>
                                </li>
                                <li class="nav-item ml-5">
                                    <a class="nav-link  black-text" data-toggle="tab" href="#tab3" role="tab" aria-selected="false">Сайты</a>
                                </li>
                                <li class="nav-item ml-5">
                                    <a class="nav-link  black-text" data-toggle="tab" href="#tab4" role="tab" aria-selected="false">Компьютеры</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">


                                    <div class="row">
                                        <?php foreach ($screens as $screen) : ?>
                                            <div class="col-lg-3 col-md-6 mb-4">
                                                <div class="card collection-card z-depth-1-half">
                                                    <a data-fancybox="gallery" href="<?php echo Main::getScreenPath($screen['id']); ?>">
                                                        <img src="<?php echo Main::getScreenPath($screen['id']); ?>" class="img-fluid" class="img-responsive" alt="">
                                                        <h6 class="black-text text-center"><?php echo $screen['date_time'] ?></h6>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Время
                                                </th>
                                                <th class="th-sm">Процесс
                                                </th>
                                                <th class="th-sm">Активное окно
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($procces as $proc) : ?>
                                                <tr>
                                                    <td><?php echo $proc['date_time']; ?></td>
                                                    <td><?php echo $proc['name_process']; ?></td>
                                                    <td><?php echo $proc['window_title']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                    <table id="dtBasicExample1" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Время
                                                </th>
                                                <th class="th-sm">Сайт
                                                </th>
                                                <th class="th-sm">Процесс
                                                </th>
                                                <th class="th-sm">Активное окно
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($url as $u) : ?>
                                                <tr>
                                                    <td><?php echo $u['date_time']; ?></td>
                                                    <td><?php echo $u['url']; ?></td>
                                                    <td><?php echo $proc['name_process']; ?></td>
                                                    <td><?php echo $proc['window_title']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                    <table id="dtBasicExample2" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Компьютер
                                                </th>
                                                <th class="th-sm">Владелец
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comps as $comp) : ?>
                                                <tr>
                                                    <td><?php echo $comp['name_computer']; ?></td>
                                                    <td><?php echo $comp['owner']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/template/js/popper.min.js"></script>
    <script type="text/javascript" src="/template/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/js/mdb.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dtBasicExample').DataTable();
            $('#dtBasicExample1').DataTable();
            $('#dtBasicExample2').DataTable();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
    <script type="text/javascript" src="/template/js/online.js"></script>
</body>

</html>
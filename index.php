<?php

require_once 'readData.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Test</title>
    <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous"
    >
</head>

<body>
<p></p>
<div class="container">
    <div class="row">
        <a href="/loadData.php" class="btn btn-success">Загрузить данные</a>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                Новости
            </div>

            <div class="row action-wrap" data-table="news">
                <button class="btn btn-info reload" data-dir="asc" style="margin-right: 5px;">^</button>
                <button class="btn btn-info reload" data-dir="desc" style="margin-right: 5px;">v</button>
                <label for="news-search">Поиск</label>
                <input class="input-search" id="news-search">
                <button class="btn btn-info reload" style="margin-right: 5px;">-></button>
            </div>

            <div class="row">
                <table class="table table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Наименование</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($news as $row) { ?>
                        <tr>
                            <td><?= date('d.m.Y H:i:s', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a
                                        href="#"
                                        class="news_link"
                                        data-id="<?= $row['id'] ?>"
                                        data-table="news"
                                >
                                    <?= $row['name'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="row">
                Альбомы
            </div>

            <div class="row action-wrap" data-table="album">
                <button class="btn btn-info reload" data-dir="asc" style="margin-right: 5px;">^</button>
                <button class="btn btn-info reload" data-dir="desc" style="margin-right: 5px;">v</button>
                <label for="album-search">Поиск</label>
                <input class="input-search" id="album-search">
                <button class="btn btn-info reload" style="margin-right: 5px;">-></button>
            </div>

            <div class="row">
                <table class="table table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Наименование</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($album as $row) { ?>
                        <tr>
                            <td><?= date('d.m.Y H:i:s', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a
                                        href="#"
                                        class="news_link"
                                        data-id="<?= $row['id'] ?>"
                                        data-table="photo_album"
                                >
                                    <?= $row['name'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="row">
                Контакты
            </div>
            <div class="row">
                <table class="table table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Наименование</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contact as $row) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <a
                                        href="#"
                                        class="news_link"
                                        data-id="<?= $row['id'] ?>"
                                        data-table="contact"
                                >
                                    <?= $row['name'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="moreInfoModal" tabindex="-1" role="dialog" aria-labelledby="moreInfoModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="movie-name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
</script>
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous">

</script>
<script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous">

</script>

<script>
    window.onload = function () {

        $(".news_link").on("click", function () {
            let id = $(this).data("id");
            let tableName = $(this).data("table");
            $.ajax({
                url: "getOneObject.php",
                data: {id: id, tableName: tableName}
            }).done(function (data) {
                $("#modal-content").html(data);
                $("#moreInfoModal").modal("show");
            }).fail(function () {
                console.log("fail");
            });
            return false;
        })

        $(".reload").on("click", function () {
            let searchParams = {
                table: $(this).closest(".action-wrap").data("table"),
                dir: $(this).data("dir"),
                term: $(this).closest(".action-wrap").find("input").val()
            };
            let href = $(location).attr("hostname");
            let protocol = $(location).attr("protocol");
            let queryString = new URLSearchParams(searchParams).toString();

            window.location.href = protocol + '//' + href + "/?" + queryString;
        })
    }

</script>
</body>
</html>


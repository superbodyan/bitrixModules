<?php

?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">NAME</th>
        <th scope="col">DATE</th>
        <th scope="col">ACTION</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <tr>
            <th scope="row"><?= $arItem['ID'] ?></th>
            <td><?= $arItem['NAME'] ?></td>
            <td><?= $arItem['DATE_INSERT'] ?></td>
            <td>
                <button class="delElement" data-id="<?= $arItem['ID'] ?>">Удалить</button>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>

<form id="addOrmItem" method="post">
    <input class="form-control" name="USER[NAME]" type="text" placeholder="Введите имя">
    <input class="form-control" name="USER[DATE]" type="text" placeholder="Введите дату рождения">
    <input type="hidden" name="ajax_task" value="addElement">
    <button class="form-control" id="submitAddOrmItem" type="submit">Добавить</button>
</form>

<script>
    $(".delElement").on("click", function () {
        let id = $(this).attr("data-id");
        let tr = this.parentElement.parentElement;

        alert("test");

        BX.ready(function () {
            BX.ajax.post(
                '/local/components/superBIT/ormtest.getlist/ajax.php',
                {elementId: id, ajax_task: "delElement"},
                function (data) {
                    $(tr).remove(); // удаляем tr - строка с записью
                    let response = JSON.parse(data);
                    alert(response);
                }
            );
        });
    })
</script>

<script>
    $("#submitAddOrmItem").on("click", function (e) {
        e.preventDefault();

        let formData = $("#addOrmItem").serialize();
        BX.ready(function () {
            BX.ajax.post(
                '/local/components/superBIT/ormtest.getlist/ajax.php',
                formData,
                function (data) {
                    let response = JSON.parse(data);
                    let id = data.replace(/\D+/g, "");
                        $('tbody').append('<tr><th scope="row">' + id + '</th>  <td>' + $('input[name="USER[NAME]"]').val() + '</td> <td>' + $('input[name="USER[DATE]"]').val() + '</td> <td> <button class="delElement" data-id="' + id + '">Удалить</button></td>');
                    alert(response);
                }
            );
        });
    })
</script>
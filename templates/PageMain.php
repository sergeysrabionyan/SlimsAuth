<?php require_once __DIR__ . '/header.php' ?>
    <div style="text-align: center;">
        <h1>Вход</h1>
            <div style="background-color: red;padding: 5px;margin: 15px"></div>
        <h1></h1>
        <form action="/plus" method="post">
            <button type="submit">+1</button>
        </form>
        <form action="logout" method="post">
            <button type="submit">Выход</button>
        </form>
    </div>
<?php require_once __DIR__ . '/footer.php' ?>
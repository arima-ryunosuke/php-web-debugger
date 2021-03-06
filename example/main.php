<head>
    <title>Web Debugger</title>
</head>
<?php

ob_start();

session_start();

echo '<body style="padding:2em;">';

try {
    // Server モジュール用
    (function () {
        // POST リクエストなら PRG する
        if (strpos($_SERVER['REQUEST_URI'], 'webdebugger-action') === false && $_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Location: ?prg');
            echo "POST が一時停止します。そのリクエストの情報が左のアイコンで確認可能です";
            exit;
        }

        // 表示のため適当なセッションを入れる
        if (!$_SESSION) {
            $_SESSION['hoge'] = 'fuga';
            $_SESSION['null'] = null;
            $_SESSION['bool'] = true;
            $_SESSION['float'] = pi();
            $_SESSION['array'] = ['foo' => 'bar', 'nest' => ['a', 'b']];
            $_SESSION['object'] = new \stdClass();
        }

        // POST 確認用のフォーム
        ?>
        <fieldset>
            <legend>SERVER</legend>
            <form action="?hoge=dummy" method="post" enctype="multipart/form-data">
                <input name="hoge" value="HOGE">
                <input name="fuga" value="FUGA">
                <input name="piyo" type="file">
                <input name="piyos[0][subpiyo]" type="file">
                <input type="submit" value="submit">
            </form>
            <p>submit するとそのリクエストの GET, POST, FILES などが確認できます。
                また、セッション情報を書き換えることもできます
            </p>
        </fieldset>
        <?php
    })();

    // Ajax モジュール用
    (function () {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <fieldset>
            <legend>Ajax</legend>
            <input type="button" value="ajax" onclick="$.post('ajax.php', {hoge:'fuga'})">
            <input type="button" value="fetch" onclick="fetch('ajax.php', {method:'PUT', body:'this is body'})">
            <p>ajax/fetch すると左の Ajax アイコンが増えます。切り替えるとその ajax リクエストの内容が確認できます</p>
        </fieldset>
        <?php
    })();

    // Log モジュール用
    (function () {
        // 直接呼んでも良い
        \ryunosuke\WebDebugger\Module\Log::log('piyo');
        // グローバルに定義されているものでも良い
        dlog([1, 2, 3]);
        ?>
        <fieldset>
            <legend>Log</legend>
            <p>随所で dlog(mixed) を呼ぶことで任意の値が確認できます</p>
        </fieldset>
        <?php
    })();

    // Performance モジュール用
    (function () {
        // Timeline 用の区間
        dtime('start');
        usleep(10000);
        dtime('middle1');
        usleep(20000);
        dtime('middle2');
        usleep(30000);
        dtime('end');
        ?>
        <fieldset>
            <legend>Performance</legend>
            <p>随所で dtime(string) を呼ぶことでリクエスト中のタイムラインが確認できます</p>
        </fieldset>
        <?php
    })();

    // Database モジュール用
    (function (\Doctrine\DBAL\Connection $connection) {
        // query/prepare ではないメソッド群
        $connection->beginTransaction();
        $connection->executeStatement('set @hoge=0');
        $connection->rollBack();

        // query/prepare など
        $connection->executeQuery('SELECT * FROM TABLES JOIN COLUMNS USING(TABLE_NAME) WHERE TABLE_NAME="TABLES" LIMIT 1');
        $stmt = $connection->prepare('(Select ?) Union (Select ?)');
        $stmt->executeQuery([1, 2]);
        $stmt->executeQuery([3, 4]);
        ?>
        <fieldset>
            <legend>Database</legend>
            <p>リクエスト中で実行したクエリの実行時間やパラメータなどが確認できます</p>
        </fieldset>
        <?php
    })($connection);

    // Variable モジュール用
    (function () {
        ?>
        <fieldset>
            <legend>Variable</legend>
            <p>汎用モジュールです。変数を表示したいだけならモジュールを作るまでもなくこれだけ十分です</p>
        </fieldset>
        <?php
    })();

    // History モジュール用
    (function () {
        ?>
        <fieldset>
            <legend>History</legend>
            <p>過去の情報を遡って確認することができます</p>
        </fieldset>
        <?php
    })();


    // Error モジュール用
    (function () {
        // Notice
        $a = [];
        $a['t'] = $a['undefined'];
        ?>
        <fieldset>
            <legend>Error</legend>
            <p>リクエスト中に発生したエラーや例外などが確認できます</p>
        </fieldset>
        <?php

        throw new \Exception('dummy exception');
    })();
}
catch (\Throwable $t) {
    throw $t;
}
finally {
    ob_end_flush();
    echo "</body>";
}

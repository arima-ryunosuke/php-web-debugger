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
    (function (\PDO $pdo) {
        // query/prepare ではないメソッド群
        $pdo->beginTransaction();
        $pdo->exec('set @hoge=0');
        $pdo->rollBack();

        // query/prepare など
        $pdo->query('SELECT * FROM TABLES JOIN COLUMNS USING(TABLE_NAME) WHERE TABLE_NAME="TABLES" LIMIT 1');
        $stmt = $pdo->prepare('(Select ?) Union (Select ?)');
        $stmt->bindValue(1, 1);
        $stmt->bindValue(2, 2);
        $stmt->execute();
        $stmt->bindValue(1, 3);
        $stmt->bindValue(2, 4);
        $stmt->execute();
        ?>
        <fieldset>
            <legend>Database</legend>
            <p>リクエスト中で実行したクエリの実行時間やパラメータなどが確認できます</p>
        </fieldset>
        <?php
    })($pdo);

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
    (function (\PDO $pdo) {
        // Notice
        $a = [];
        $a['t'] = $a['undefined'];
        ?>
        <fieldset>
            <legend>Error</legend>
            <p>リクエスト中に発生したエラーや例外などが確認できます</p>
        </fieldset>
        <?php

        // PDO の例外
        $pdo->query('invalid query hoge');
    })($pdo);
}
finally {
    ob_end_flush();
    echo "</body>";
    fastcgi_finish_request();
}

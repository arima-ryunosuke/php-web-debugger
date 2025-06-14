<head>
    <title>Web Debugger</title>
</head>
<?php

ob_start();

session_start();

echo '<body style="padding:2em;">';

try {
    // POST リクエストなら PRG する
    if (strpos($_SERVER['REQUEST_URI'], 'webdebugger-action') === false && $_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Location: ?prg');
        echo "POST が一時停止します。そのリクエストの情報が左下のアイコンで確認可能です";
        exit;
    }

    // レスポンス用
    (function () {
        ?>
        <fieldset>
            <legend>Response</legend>
            <p>左下のアイコンのようにリクエスト中の各種情報が蒐集されます。アイコンをクリックするとそのモジュールの詳細が表示されます。</p>
            <p>原則として text/html なレスポンスが対象ですが、一部の利便性のため、Web アプリでよくある Content-Type も html とみなして書き換えられます</p>
            <p>例えば下記を開くと、本来はそれぞれの Content-Type が返されるはずですが、text/html に書き換えられ、アイコン群が有効になっています</p>
            <ul>
                <li><a href="./rewrite.php?type=plain">text/plain</a></li>
                <li><a href="./rewrite.php?type=json">application/json</a></li>
                <li><a href="./rewrite.php?type=xml">application/xml</a></li>
            </ul>
            <p>この挙動は rewrite オプションで変更可能です。また、元の Content-Type は X-Original-Content-Type として格納されます</p>
        </fieldset>
        <?php
    })();

    // Server モジュール用
    (function () {
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
            <input type="button" value="fetch" onclick="fetch('ajax.php', {method:'PUT', headers: {'x-custom': 'custom'}})">
            <input type="button" value="fetch" onclick="fetch(new Request('ajax.php', {method:'PUT', headers: {'x-custom': 'custom'}}))">
            <input type="button" value="fetch" onclick="fetch(new Request('ajax.php', {method:'PUT', headers: {'x-custom': 'custom'}}), {headers: {'x-custom2': 'custom2'}})">
            <p>ajax/fetch すると左下の Ajax アイコンが増えます。切り替えるとその ajax リクエストの内容が確認できます（fetch ボタンがいくつかあるのは実装の確認用です）</p>
        </fieldset>
        <?php
    })();

    // Log モジュール用
    (function (\Psr\Log\LoggerInterface $monolog, \Psr\Log\LoggerInterface $psr3log) {
        // 直接呼んでも良い
        \ryunosuke\WebDebugger\Module\Log::log('piyo');
        // グローバルに定義されているものでも良い
        dlog([1, 2, 3]);
        // monolog のロガーも送られる
        $monolog->info('monolog');
        // psr3 のロガーも送られる
        $psr3log->info('psr3log');
        ?>
        <fieldset>
            <legend>Log</legend>
            <p>随所で dlog(mixed) を呼ぶことで任意の値が確認できます</p>
            <p>monolog や psr3 のロギングも可能です</p>
        </fieldset>
        <?php
    })($monolog, $psr3log);

    // Performance モジュール用
    (function () {
        // 特に意味はなく CPU 時間のために浪費する（この 999 の値を弄って CPU キーを見てみるとよい）
        for ($i = 0; $i < 999; $i++) {
            // file で syscall, sort で utime が増えるはず
            $file = file(__FILE__);
            sort($file);
        }
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

    // Doctrine モジュール用
    (function (\Doctrine\DBAL\Connection $connection) {
        // query/prepare ではないメソッド群
        $connection->setNestTransactionsWithSavepoints(true);
        $connection->beginTransaction();
        $connection->beginTransaction();
        $connection->executeStatement('set @hoge=0');
        $connection->rollBack();
        $connection->rollBack();

        // query/prepare など
        $connection->executeQuery('SELECT * FROM TABLES JOIN COLUMNS USING(TABLE_NAME) WHERE TABLE_NAME="TABLES" LIMIT 1');
        $stmt = $connection->prepare('(Select ?) Union (Select ?)');
        $stmt->executeQuery([1, 2]);
        $stmt->executeQuery([3, 4]);
        ?>
        <fieldset>
            <legend>Doctrine</legend>
            <p>リクエスト中で実行したクエリの実行時間やパラメータなどが確認できます</p>
        </fieldset>
        <?php
    })($connection);

    // Directory モジュール用
    (function () {
        ?>
        <fieldset>
            <legend>Directory</legend>
            <p>ディレクトリの一覧表示です。主な用途は一時ファイルやキャッシュファイルなどの削除です（Symfony/PhpFileCache など）</p>
        </fieldset>
        <?php
    })();

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

        $ex1 = new \DomainException('critical exception');
        $ex2 = new \RuntimeException('internal exception', 1, $ex1);
        throw new \Exception('dummy exception', 2, $ex2);
    })();
}
catch (\Throwable $t) {
    throw $t;
}
finally {
    ob_end_flush();
    echo "</body>";
}

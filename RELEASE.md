# RELEASE

バージョニングはセマンティックバージョニングでは**ありません**。

| バージョン   | 説明
|:--           |:--
| メジャー     | 大規模な仕様変更の際にアップします（クラス構造・メソッド体系などの根本的な変更）。<br>メジャーバージョンアップ対応は多大なコストを伴います。
| マイナー     | 小規模な仕様変更の際にアップします（中機能追加・メソッドの追加など）。<br>マイナーバージョンアップ対応は1日程度の修正で終わるようにします。
| パッチ       | バグフィックス・小機能追加の際にアップします（基本的には互換性を維持するバグフィックス）。<br>パッチバージョンアップは特殊なことをしてない限り何も行う必要はありません。

なお、下記の一覧のプレフィックスは下記のような意味合いです。

- change: 仕様変更
- feature: 新機能
- fixbug: バグ修正
- refactor: 内部動作の変更
- `*` 付きは互換性破壊

## x.y.z

- 初期化が割と煩雑なのをなんとかしたい

## 1.2.12

- [fixbug] Doctrine で SAVEPOINT でログや合計時間が乱れる不具合を修正

## 1.2.11

- [fixbug] popup のスクロールが追従しない不具合を修正

## 1.2.10

- [feature] アイコン群を左上から左下に変更
- [composer] update

## 1.2.9

- [change] 編集系に spellcheck=false を付与
- [fixbug] クエリの値バインドがズレる不具合を修正

## 1.2.8

- [fixbug] 操作周りの不具合修正
- [feature] table 表示を markdown から ArrayTable に変更
- [refactor] スペースが積もってものすごいサイズになっていたので除去
- [feature] ArrayTable に連番を振る機能
- [fixbug] 使用側で session_write_close を呼んでいるとセッションが保存できない不具合を修正

## 1.2.7

- [fixbug] debugger 側の ajax リクエストが無効になっている不具合を修正

## 1.2.6

- [refactor] 環境次第でテストがコケていたので修正
- [fixbug] fetch に Request オブジェクトが来たときに設定されない上に元を消してしまう不具合を修正
- [fixbug] ajax 検出にデファクトである x-requeted-with を使うべきではない
- [feature] Error プラグインの console 出力機能

## 1.2.5

- [composer] update

## 1.2.4

- [fixbug] markdown 表示が乱れていたので css を変更

## 1.2.3

- [bin] opener_query の対応（クロージャ化）
- [feature] opener_query を新設して opener のクエリとして飛ぶように変更
- [feature] 出力から Psr16 を除外

## 1.2.2

- [fixbug] ビルド漏れ

## 1.2.1

- [feature] Directory モジュールを追加
- [fixbug] log の trace に psr3/monolog が紛れ込む不具合を修正

## 1.2.0

- [example] 変更点を反映
- [*change] ChromeLogger を廃止して Content-Type 由来の書き換えに変更
- [feature] Log モジュールの psr3/monolog 対応
- [feature] Database を Doctrine に改名

## 1.1.0

- [*change][Database] doctrineAdapter で2系の切り捨て
- [*change][AbstractModule] exec を汎用的に変更
- [all] php8.1 対応

## 1.0.15

- [refactor][Database] LoggablePDO がコード中に生き残っていたので除去
- [feature][Debugger] json 返却時に強制的に html にしてデバッグ機能を使用する機能
- [fixbug][Debugger] unlink エラーがでることがあるのを修正

## 1.0.14

- [fixbug][template] 不要なオブジェクトの div まで開いていた不具合を修正
- [fixbug][Module/Ajax] 飛び元で fetch を使用すると死ぬ不具合を修正
- [feature][Module/Performance] preload 対応

## 1.0.13

- [change][template] 軽微な見た目の変更
- [change][Debugger] ログが結構な容量を食べるので 1000 から 100 に変更
- [change][Module/Performance] 見た目の変更
- [feature][Module/Database] doctrineAdapter を使う際に他のオプションを渡す機能
- [fixbug][Module/Server] phpinfo が消えない不具合を修正

## 1.0.12

- [feature] bump version
- [feature] doctrine3 に対応
- [change] LoggablePDO の非推奨化

## 1.0.11

- [change][Module/Smarty] Smarty モジュールを廃止
- [feature][Module/Database] logger の traversable 対応
- [feature][Module/Performance] OPcache 情報を追加
- [fixbug][Html/AbstractHtml] numeric の扱いに不具合があったので修正

## 1.0.9

- [feature] php7.4 に対応

## 1.0.8

- [fixbug][Log] html エスケープされない不具合を修正
- [fixbug][Debugger] gz 圧縮が全く効いていない不具合を修正
- [feature][AbstractHtml] Holding の表示を見やすく変更

## 1.0.7

- [fixbug][Module/Error] 例外がカウントされない不具合を修正

## 1.0.6

- [fixbug][Debugger] php-fpm でコンソールログが出ない不具合を修正
- [feature][Debugger] outer は </head> に埋め込むように修正
- [feature][Module/History] History モジュールを追加
- [change][Module/AbstractModule] gather にリクエスト配列が来るように修正
- [fixbug][Module/Ajax] fetch の第2引数なしが考慮できていない不具合を修正
- [change][Ajax] jQuery.ajax への依存を削除
- [change][Module/Ajax] ラジオボタンの位置を変更
- [change][Debugger] デバッグファイルをフラット構造にしてゴミ削除機能を追加
- [change][all] エラーとアイコン表示の意味合いを変更
- [change][ChromeLogger] ヘッダが長すぎるとエラーになる web サーバーがある

## 1.0.5

- [fixbug][all] 巨大オブジェクトの表示でメモリを食いつぶしていた不具合を修正
- [feature][Error] 例外が改行を含む場合に視認性が悪かったので pre で包むように変更
- [fixbug][Log] 与えた値の型情報が死んでいた不具合を修正
- [fixbug][Database] id がいつの間にかなくなっていた不具合を修正
- [feature][Database] doctrine は非常によく使うのでアダプタを用意した

## 1.0.4

- [fixbug][Debugger] php-fpm で file notfound になっていた不具合を修正

## 1.0.3

- [all] 対応 php バージョンの格上げと composer update
- [feature][Module/Performance] profile 機能を追加

## 1.0.2

- [fixbug][AbstractModule] js console にいらない情報が出ていた不具合を修正
- [fixbug][Debugger] ob してるときにデバッガが出ない不具合を修正

## 1.0.1

- [feature][Variable] モジュールを追加
- [feature][ArrayTable] iterable に対応
- [feature][Debugger] シリアライズできないオブジェクトも表示可能に修正

## 1.0.0

- 公開

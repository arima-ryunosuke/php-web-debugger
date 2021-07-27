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

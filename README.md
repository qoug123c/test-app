# 関数一覧
-関数の意味を一覧にしています。

---
## config.php 
### ini_set();
[php.net](https://www.php.net/manual/ja/function.ini-set.php)

 PHPの **「設定オプション」の値を一時的に書きかえるための関数** です。

 PHPには、あらかじめ php.ini というファイルで決められた「基本ルール（設定）」があります。しかし、特定のプログラムを動かすときだけ、そのルールを変えたい場合があります。

 スクリプトの冒頭で `ini_set()` を使うことで、そのプログラムが実行されている間だけルールを上書きできます。

- **【シチュエーション】**
  - 「このプログラムの間だけ、エラーを画面に表示させたい」
  - 「この処理だけ、特別にメモリをたくさん使わせてほしい」

---
### error_reporting();
[php.net](https://www.php.net/manual/ja/function.error-reporting.php)

PHPが **「どんな種類の間違い（エラー）を報告するか」を設定するための関数**です。

PHPには色々なレベルの「間違い」があります。
- すべてのミスを報告 (**E_ALL**): 

  E_ALL をセットするのは、主に **プログラムを作っている最中（開発中）** です。小さなミスが後で大きなバグ（不具合）になるのを防ぐために、E_ALL にして全ての指摘をしてもらうのが一番です。

- 致命的なエラー (**E_ERROR**): 

  プログラムが止まってしまうほどの大失敗です（たとえば、前回お話しした require でファイルが見つからない時などに発生します）。

- 警告 (**E_WARNING**): 


`error_reporting()` を使うと、「致命的なエラー（大失敗）だけ教えて！」とか「細かい注意（小さなミス）も全部教えて！」という風に、報告してほしいエラーの種類を自由に選ぶことができます。

---
### set_error_handler();
[php.net](https://www.php.net/manual/ja/function.set-error-handler.php)

PHPでエラーが起きたときに　**「あらかじめ決まった動きではなく、自分で作ったオリジナルの動き（関数）をさせる」**　ための関数です。

通常、PHPでエラーが起きると、画面に「エラーですよ！」と文字が出るだけですが、この関数を使うと **「エラーが起きたら、こっそりノートにメモして、画面には可愛いイラストを出してね」** といった自分専用のルールを作ることができます

- **【できること】**
  - エラーを隠す: 恥ずかしいのでエラーを画面には出さない。
  - ログに記録する: どんなエラーが起きたか、後で確認するためにファイルに保存する。
  - 特別なお知らせ: 大事なプログラムなら、エラーが起きた瞬間にメールを送る。 etc...
---
### function errorHandler($errNo, $errStr, $errFile, $errLine)
自作メソッド。

- **【引数】**
  - **$errNo**：エラーの番号（種類）。
  - **$errStr**：エラーのメッセージ（内容）。
  - **$errFile**：エラーが起きたファイルの名前。
  - **$errLine**：エラーが起きた行番号。

- **【していること】**
  1. エラーの種類を厳しくチェック (===):
    - ` if ($errNo === E_NOTICE || $errNo === E_WARNING)` ここでは「ちょっとしたヒント (E_NOTICE)」か「警告 (E_WARNING)」のときだけ動くように設定しています。
  
  2. 名前を決める (三項演算子 ? :):
    - ` $errTitle = $errNo === E_NOTICE ? 'Notice' : 'Warning';` 番号を見て、画面に出すタイトルを「Notice」にするか「Warning」にするか決めています。

  3. きれいに整える (htmlspecialchars): 
    - エラーの内容やファイル名に、変な記号が入って画面が崩れないように安全に加工しています。
    - `htmlspecialchars()`：PHPにおいて **「特殊文字を HTML エンティティに変換する」** ための関数です。
      - 具体的には、HTMLの中で特別な意味を持つ記号（例えば < や & など）を、ブラウザがタグとしてではなく、単なる「文字」として正しく表示できるように `&lt;` や `&amp;` といった形式（HTMLエンティティ）に置き換える役割を担います。[※`htmlspecialchars()`について](https://www.php.net/manual/ja/function.htmlspecialchars.php)

  4. 画面に表示して、即終了！ (echo と exit):
    - `echo '<b>' . $errTitle ... `エラー情報を太字で見やすく表示します。そして、exit; という命令でプログラムをその場で強制終了させます。
    - ※通常「警告」などはプログラムが止まりませんが、この関数を使うと小さなミスでも即座にストップさせる厳しいルールになります。
 
  5. それ以外のエラーのとき (return false): 
    - もし「致命的なエラー」など、上の条件に合わないエラーだった場合は false を返します。これはPHPに「あとは任せた（標準のルールで処理して）」と伝える合図です。
---
### define();
[php.net](https://www.php.net/manual/ja/function.define.php)

PHPで **「定数（ていすう）」を作るための関数**です。

`$name` や `$hp` は「**変数**」といって、中身を自由に入れ替えることができました。 それに対して、define() で作る「**定数**」は、一度決めたら絶対に中身を変えることができません。

- **【書きかたのルール】**
  - 名前は「大文字」で書く: プログラミングの世界では、変数と見分けやすくするために、定数は全部大文字で書くという約束事があります。
  - `$`はつけない: 変数ではないので、頭に`$`は不要です。

- **【使用例】**
  - 消費税: `define("TAX", 1.1);`
  - 最大レベル: `define("MAX_LEVEL", 99);`
  - DBホスト名: `define('DB_USER', 'root');`
---
## connection.php
### require_once();
[php.net](https://www.php.net/manual/ja/function.require-once.php)

PHPで他のファイルに書かれたプログラムを読み込んで、自分のプログラムの中で使えるようにする命令です。

一言でいうと、 **「そのファイルを1回だけ、絶対に読み込んでね！」** という、とても慎重で厳しい命令です。

似ている `require` と比較します。
- **【特別ルール】**
    - `require`: 
      - 命令するたびに、何度でもそのファイルを読み込みます。
    - `require_once`: 
      - 「もう読み込んだかな？」とPHPがチェックします。もしすでに読み込み済みなら、2回目は何もしません。
- **【特徴】**
  - 面白いことに、require_once は厳密には「関数」ではなく、 **「言語構造（げんごこうぞう）」** というPHPの基本ルールの一部です。そのため、通常の関数のように `require_once("file.php"); `とカッコをつける必要はありません。一般的な記述方法として`require_once 'file.php';`と記述します。

---
### function connectPdo()
自作メソッド。 

一言でいうと **「データベースと通信するための『専用の窓口』を準備する」** という仕事をしています。

- **【`try`の中身】**
  - `return new PDO(DSN, DB_USER, DB_PASSWORD);`
    - `new PDO`：「データベースに接続するためのインスタンス」を新しく作れ！という命令です。
      - ※PDOメソッドは**PHP側で公式にすでに用意されているメソッド**になります。
    - `DSN, DB_USER, DB_PASSWORD`：[上記で話した`define() `](#define)で作られた「定数」たちです。ここにはデータベースの住所や、入るためのIDとパスワードが「書きかえられない大切なルール」として保存されています。
    - `return`：準備ができた「接続窓口」を、この関数を呼び出した人に「はい、どうぞ！」と返しています。

- **【`catch`の中身】（もし失敗したら...）**
  - データベースの住所が間違っていたり、パスワードが違ったりすると、プログラムがエラー（例外）を投げます。それを捕まえるのが **catch（キャッチ）** です。
  - `echo $e->getMessage()`：「どうして失敗したのか（パスワードが違うよ、など）」という理由を画面に表示します。
    - `$e`の中身については定義されていませんが、PHPには `Exception` や `PDOException` という名前の「エラー報告書の設計図」が最初から用意されています。それを`$e`にいれたということになります。[※PDOExceptionについて](https://www.php.net/manual/ja/class.pdoexception.php)
  - `exit()`：データベースに繋がらないとこの後のプログラムは動かせないので、**その場で実行を終了させます。**
---
### function createTodoData($todoText)
<!-- (sc12) -->
自作メソッド。

- **【引数】**
  - **$todoText**：ブラウザ上で入力された内容。

- **【していること】**

  1. データベース接続
    - `$dbh = connectPdo();`
    - connectPdo() 関数を呼び出しています。その関数を$dbh という名前の変数（ハンドル）に入れています。
  2. ブラウザ上で入力された文字列をSQLに変換
    - `$sql = 'INSERT INTO todos (content) VALUES ("' . $todoText . '")';`
    - ブラウザ上で入力された内容($todoText)をデータベースに送るための命令文（SQL）を、文字列として作成しています。
  3.  命令を実行（query）する
    - `$dbh->query($sql);`
    - `$dbh`を使用してデータベースにアクセスし、`$sql`のSQLを実行しています。[`query() `](https://www.php.net/manual/ja/pdo.query.php)メソッドはSQL文を準備して実行する機能を持っています。
---
### getAllRecords()
<!-- (sc13) -->
自作メソッド。
- **【引数】**
  - なし

- **【していること】**

  1. データベース接続
    - `$dbh = connectPdo();`
    - [connectPdo()](#function-connectpdo) 関数を呼び出しています。その関数を$dbh という名前の変数（ハンドル）に入れています。
  2. SQLを作成
    - `$sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';`
    - 今回のSQLとして、 `todos`テーブルにある`deleted_at`(削除日時)がNULL(データがない)もの全てを表示させる。という内容になります。
    - getAllRecords()が呼び出された時に実行したいSQLを作成しています。
  3.  命令を実行（query）する
    - `return $dbh->query($sql)->fetchAll();`
    - `query($sql)`：`$dbh`を使用してデータベースにアクセスし、`query($sql)`でSQLを実行しています。  
    - `fetchAll()`： 見つかったデータを、1つずつではなく **「全部まとめてリスト（配列）」の形** にします。[※`fetchAll()`について](https://www.php.net/manual/ja/pdostatement.fetchall.php)
    - `return`：出来上がったリストを、この関数を呼び出した人に「はい、これが最新のリストだよ！」と手渡して終了します。
---
### updateTodoData($post)
<!-- (sc15) -->
自作メソッド
- **【引数】**
  - **$post**：更新したい入力した内容。

- **【していること】**
  1. データベース接続
    - `$dbh = connectPdo();`
    - [connectPdo()](#function-connectpdo) 関数を呼び出しています。その関数を$dbh という名前の変数（ハンドル）に入れています。
  2. SQLを作成
    - `$sql = 'UPDATE todos SET content = "' . $post['content'] . '" WHERE id = ' . $post['id'];`
    - すでにあるレコードの内容(`content`)を上書きする。条件としてレコードのidと一致すること。
  3.  命令を実行（query）する
    - `$dbh->query($sql);`
    - `$dbh`を使用してデータベースにアクセスし、`$sql`のSQLを実行しています。[`query() `](https://www.php.net/manual/ja/pdo.query.php)メソッドはSQL文を準備して実行する機能を持っています。

### function getTodoTextById($id)
<!-- (sc15) -->
自作メソッド

「指定したID（番号）に対応する『やること（Todo）』の本文だけを、データベースからピンポイントで持ってくる」**という仕事をしています。
- **【引数】**
  - **$id**：$_GET['id'] のURLクエリパラメータ（index.phpでURLのパラメータとして渡したid）

- **【していること】**
  1. データベース接続
    - `$dbh = connectPdo();`
    - [connectPdo()](#function-connectpdo) 関数を呼び出しています。その関数を$dbh という名前の変数（ハンドル）に入れています。
  2. SQLを作成
    - `'SELECT * FROM todos WHERE deleted_at IS NULL AND id = $id';`
    - データを取得する上での条件として、`todos`テーブルにある`deleted_at`(削除日時)がNULL(データがない)もので、$_GET['id'] で取得した`id`と同じ`id`であること。
  3.  命令を実行（query）する
    - `$data = $dbh->query($sql)->fetch();`
    - `query($sql)`：`$dbh`を使用してデータベースにアクセスし、`query($sql)`でSQLを実行しています。  
    - `fetch()`： 実行結果の中から、「最初の1行分」だけを取得します。
    [※`fetch()`について](https://www.php.net/manual/ja/pdostatement.fetch.php)
    - `return`：取得した結果の中から、content という列（Todoの本文が入っている場所）のデータだけを、この関数の呼び出し元に返します。

<!-- ## edit.php  -->

## functions.php
### function createData($post)
自作メソッド。
- **【引数】**
  - **$post**：ブラウザの入力フォームに書き込まれたデータが「ひとまとめ」に入っている**連想配列**です。

`createTodoData($post['content']);`について分解して考える
- **【していること】**
  1. $post['content']: $postの中から、「content（内容）」というラベルがついたデータだけを取り出しています。
  2. `createTodoData(...) `へのパス: 取り出したメモの内容を、前回勉強した「データベース保存の専門家」である [`createTodoData()`](#function-createtododatatodotext)に「これをお願い！」と手渡して実行させています。

---
### function getTodoList()
自作メソッド。
- **【引数】**
  - なし

- **【していること】**
  - [`getAllRecords()`](#getallrecords)を呼び出して返してるだけ。
---
### function getRefererPath()
自作メソッド。

**「ユーザーが直前に開いていたページのURLから、『パス（住所の後半部分）』だけを抜き出して特定する」**という仕事をしています。

- **【引数】**
  - なし

- **【していること】**
 1. 直前のページの情報を取得する
  - `$_SERVER['HTTP_REFERER']` ：ブラウザがサーバーに送ってくる情報の一つで、**「ユーザーがどのページからリンクを辿って現在のページに来たか」** という直前のURLが入っています。[※$_SERVERについて](https://www.php.net/manual/ja/reserved.variables.server.php)
2. URLをバラバラに分解する（parse_url）
  - `$urlArray = parse_url($_SERVER['HTTP_REFERER']);`
    - `parse_url()`: この関数は、**URLを解釈して、その構成要素（プロトコル、ホスト名、パスなど）をバラバラに分解して返す**役割を持っています。
    - 実行結果: 例えば直前のURLが `https://example.com/index.php` だった場合、この関数によって「ホスト名は `example.com`」「パスは /index.php」といった具合に整理されたリスト（配列）が作成され、変数 `$urlArray` に保存されます。
3. パスだけを抜き出して返す（return）
  - `return $urlArray['path'];`
    - `$urlArray['path']`：分解されたリストの中から、「path（パス）」 というラベルが付いた情報（例：`/index.php`）だけを取り出しています。
    - `return`：**プログラムの制御を呼び出し元に戻し**、取り出したパスの文字列を関数の結果として「はい、どうぞ！」と返します。
---
### function savePostedData($post) 
自作メソッド

**「送られてきたデータの内容と、そのデータが『どの画面から送られてきたか』をチェックして、実行する作業（保存・更新・削除）を自動で振り分ける司令塔」** の役割をしています。

- **【引数】**
  - **$post**：どこから来たかを確認する。

- **【していること】**
  1. 「どこから来たか」を特定する
  - `$path = getRefererPath();`
  - [getRefererPath()](#function-getrefererpath) 関数を呼び出しています。これにより、ユーザーが「新規作成画面 (/`new.php`)」「編集画面 (`/edit.php`)」「一覧画面 (`/index.php`)」のどこからボタンを押してここに来たのか、そのパスを特定して変数 `$path` に入れています。
  2. switch 文による処理の振り分け
  - 取得した `$path` の値に応じて処理を分岐させています。`switch` 文は、同じ式（ここでは `$path`）を異なる値と比較し、一致した場所のコードを実行するために使われます。
    - `case '/new.php'` (新規登録)：ユーザーが新規作成画面から来た場合、`createTodoData()` 関数を呼び出してデータベースに新しい Todo を登録（INSERT）します。
    - `case '/edit.php'` (更新)：編集画面から来た場合、`updateTodoData()` 関数を呼び出して既存のデータを書き換え（UPDATE）ます。
    - `case '/index.php' `(削除)：一覧画面の削除ボタンから来た場合、`deleteTodoData()` 関数を呼び出して指定された ID のデータを削除します。
  3. break の役割
  - 各 `case` の最後にある `break` は、現在実行中の `switch` 構造を終了させる命令です。もし `break` を書き忘れると、PHP は一致した処理が終わった後も、その下にある別の `case` の命令を続けて実行してしまいます（これをフォールスルーといいます）。そのため、目的の処理だけを行わせるために `break` で「ここで終わり！」と明確に伝えています。
  4. default の役割
  - `default` は、どの `case` にも当てはまらなかった場合に実行される特別なケースです。このコードでは何もせず終了するように書かれています。

---

<!-- ## index.php  -->
<!-- ## new.php  -->

## store.php
### header();
[php.net](https://www.php.net/manual/ja/function.header.php)

**サーバーからブラウザへ「画面を表示する前の指示（HTTPヘッダ）」を送る**ための関数です。

- **【できること】**
  1. 別のページに飛ばす（リダイレクト）
  - 指定したURLへ自動的に画面を切り替えます。処理を終了させる exit; とセットで書くのが鉄則です。 
    ```
    <?php

    header('Location: ./index.php');
    ```
  2. ファイルをダウンロードさせる
  - ブラウザで画面を表示せず、PDFやCSVファイルとしてダウンロードさせたい場合に使います。
    ```
    <?php
    // ダウンロードするファイルの種類（例：PDFファイル）を指定
    header('Content-Type: application/pdf');

    // ダウンロード時のファイル名を「sample.pdf」に指定
    header('Content-Disposition: attachment; filename="sample.pdf"');
    ```
- **【絶対に守るべきルール】**
  - header() は、HTMLや文字（スペースや空行含む）をブラウザに出力する前に実行しなければなりません。
  - ❌ エラーになるNG例
    ```
    <p>こんにちは</p> <!-- 先にHTMLが出力されている -->
    <?php
    header('Location: https://example.com'); // ここでエラー（Cannot modify header information）
    ?>
    ```
  - ⭕ 正しい例
    ```
    <?php
    header('Location: https://example.com'); // 最初に実行する
    exit;
    ?>
    <p>こんにちは</p>
    ```

---
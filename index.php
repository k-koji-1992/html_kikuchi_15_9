<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ブックマーク登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/sample.css" rel="stylesheet">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }
  </style>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Google+Sans:100,300,400,500,700,900,100i,300i,400i,500i,700i,900i" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="js/jquery-3.5.1.min.js"></script>

</head>

<body>


  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="select.php">ブックマーク一覧</a></div>
      </div>
    </nav>
  </header>
  <header>
    <img src="img/Googlebooks.png" alt="">
    <p>
    <div id="searchBar">
      <i class="material-icons md-21" id="searchMark">search</i>
      <input type="text" id="keyword" placeholder="検索ワードを入力">
      <i class="material-icons md-21" id="searchMic">mic</i>
    </div>
    </p>
  </header>





  <main>
    <h2>検索結果</h2>
    <div id="content"></div>
    <div id="none" style="display:none;">検索結果がありません。</div>
  </main>


  <script>
    // axios を使う[開始] エンターキーをプレスするとaxiosを使って情報を取得する関数を発火
    $("#keyword").keypress(function(event) {
      if (event.which === 13) {
        performSearch();
      }
    });
    // axiosを使って情報を取得する関数を定義。
    function fillBookmarkForm(title, url) {
      $('input[name="title"]').val(title);
      $('input[name="url"]').val(url);
    }

    function performSearch() {
      // id=keywordに入力した値を定数として定義
      const keyword = $("#keyword").val();
      // APIとkeywordを組み合わせ定数として定義
      const url = "https://www.googleapis.com/books/v1/volumes?q=" + keyword;

      axios.get(url).then(function(res) {
        const items = res.data.items
        // 前回の検索結果を削除
        $("#content").html("");

        $("#none").hide();

        // 配列の中身を一つずつ取り出してみて表示する
        items.forEach(function(item) {
          const link = item.volumeInfo.infoLink;
          const title = item.volumeInfo.title;
          const authors = item.volumeInfo.authors.join(', ');
          const publisher = item.volumeInfo.publisher;
          const thumbnail = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : "https://via.placeholder.com/128x192?text=No+Image";


          $("#content").append(`
      <div class="result" onclick="fillBookmarkForm('${title}', '${link}')">
        <img src="${thumbnail}" alt="${title}">
        <h3>${title}</h3>
        <p>著者: ${authors}</p>
        <p>出版社: ${publisher}</p>
      </div>
    `);




        });

        if (items.length === 0) {
          $("#none").show();
        }
      });
    };

    // axios を使う[終了]
  </script>


  <form method="post" action="insert.php">
    <div class="jumbotron">
      <fieldset>
        <legend>ブックマーク登録欄</legend>
        <label>書籍名：<input type="text" name="title"></label><br>
        <label>書籍URL：<input type="text" name="url"></label><br>
        <label>コメント：<textArea name="comment" rows="4" cols="40"></textArea></label><br>
        <input type="submit" value="送信">
      </fieldset>
    </div>
  </form>
</body>

</html>
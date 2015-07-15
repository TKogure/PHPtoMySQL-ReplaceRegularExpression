<?php
    #変数宣言
    $username = "MySQLユーザー名";
    $password = "MySQLパスワード";
    $host     = "接続するホスト";
    $database = "データベース名";
    $i = 0;

    #DB接続テスト
    $con = mysqli_connect($host, $username, $password) or die("Connect Error!!");
    #UTF-8に設定
    mysqli_set_charset($con, 'utf8');
    #DB選択
    mysqli_select_db($con, $database) or die("DB SELECT Error!!");

    #置き換え元のテキストを取得
    $sql = "SELECT テーブル名 FROM カラム名 WHERE カラム名 LIKE BINARY '%置き換え元文言%'";
    $result = mysqli_query( $con, $sql) or die( "QUERY ERROR ".$sql );

    #取得情報表示　無くても可
    echo "<pre>";
    print("result");
    print_r($result);
    echo "</pre><br>";

    #行数を取得
    $count = mysqli_num_rows($result);

    #取得した情報の行数を表示　無くても可
    print("count");
    print_r($count);
    echo "<br>";

    #行数分処理します
    while ($i < $count) {
        $out_data = null;
        $out_data_array = null;
        $replace_query = null;
        $item = mysqli_fetch_row($result);
        $in_data = $item[0];
        #念のためエスケープ
        $in_data = mysqli_real_escape_string($con, $in_data);

        preg_match("/正規表現を入力/", $in_data, $out_data_array);
        $out_date = $out_data_array[0];
        #念のためエスケープ
        $out_data = mysqli_real_escape_string($con, $out_data);

        #in_dataをout_dataに置き換えます
        $replace_query = "UPDATE `テーブル名` SET `カラム名` = REPLACE(`カラム名`, \"".$in_data."\", \"".$out_data."\")";

        mysqli_query($con, $replace_query);
        $i++;
    }
    mysqli_close($con);
?>
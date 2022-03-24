<?php

class ClassLoader
{
  // オートロード実行時、クラス検索の対象となるディレクトリを格納する変数
  protected $dirs;

  // sql_autoload_register実行
  public function register()
  {
    // オートロードの登録（この関数に設定したコールバックがオートロード時に呼び出される。自分自身のloadClassメソッドを指定）
    // 未定義のクラスをcallした際、loadClassメソッドを実行する。
    sql_autoload_register(array($this, 'loadClass'));
  }

  // オートロード実行時、クラス検索の対象となるディレクトリを保存する関数
  // 今回は、coreディレクトリとmodelsディレクトリからクラスファイルの読み込みを行うようにする
  // 柔軟に対応できるように探すディレクトリをいくつでも登録できる仕組みにする。
  // 引数には、オートロードの対象とするディレクトリへのフルパスを指定
  public function registerDir($dir)
  {
    $this->dirs[] = $dir;
  }

  // オートロードメソッド。引数には、callしようとしたクラス名が渡ってくる
  // オートロード時にPHPから自動的に呼び出され、クラスのファイル読み込みを行う
  // オートロード時にこのメソッドが呼び出された際、引数にはクラス名が渡されている。これをもとにクラスファイルの読み込みを行う
  public function loadClass($class)
  {
    // 登録済みの検索ディレクトリに、newしようとしたクラスファイルが存在しているか確認
    // $dirsプロパティに設定されたディレクトリから「クラス名.php」を探し、見つかった場合はrequireで読み込みを行う。
    // 読み込んだ場合、それ以外の処理を行う必要はないのでreturnで処理を中断。
    // このクラスをオートロードに設定すれば、クラスファイルの読み込みを毎回せずにプログラムを開発していける。
    foreach ($this->dirs as $dir) {
      $file = $dir . '/' . $class . '.php';
      if (is_readable($file)) {
        require $file;
        return;
      }
    }
  }
}

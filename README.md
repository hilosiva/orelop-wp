# Orelop WP（仮）

![screenshot](https://github.com/hilosiva/orelop-wp/blob/main/src/screenshot.png)

## 概要

Orelop WP は、俺流の WordPress テーマ開発環境です。
WordPress の環境には「[wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)」を利用し、フロントエンドツールには「[vite](https://ja.vitejs.dev/)
」を利用しているため、オールインワンで高速に WordPress のテーマを開発することが可能です。

## 準備

Orelop WP を利用するには、あらかじめ以下のツールをマシンにインストールしておいて下さい。

- [Docker](https://www.docker.com/)
- [Node.js](https://nodejs.org/ja) >=16.4.0
- [git](https://git-scm.com/)

## インストール

1. ターミナルを開き、「Orelop WP」を初期化したいディレクトリに移動します。

```bash
cd /path/to/project-directory
```

2. 以下のコマンドを実行して、「Orelop WP」をダウンロードします。

```bash
npx degit hilosiva/orelop-wp#main <project-name>
```

3. プロジェクトディレクトリに移動します。

```bash
cd <project-name>
```

4. 必要な依存関係をインストールします。

```bash
npm install
```

## 開発用サーバーの起動

以下のコマンドで WordPress の環境と開発用サーバーを起動できます。

■ npm

```

npm run dev

```

■ yarn

```

yarn dev

```

※初回は WordPress の環境を構築するため時間が掛かります。

開発環境は、[http://localhost:3000](http://localhost:3000)で立ち上がります。

WordPress の管理画面は、[http://localhost:3000/wp-admin/](http://localhost:3000/wp-admin/)でアクセスできます。

- ユーザ名：admin
- パスワード：password

### WordPress のサーバーが立ち上がったかを確認する

以下のコマンドで、サーバーが立ち上がっているかを確認できます。

```

docker ps

```

### WordPress の環境を変更する

デフォルトでは、WordPress の日本語の最新版がインストールされます。

ルートディレクトリにある「.wp-env.json」を編集することで、インストールする WordPress のバージョンや、利用する PHP のバージョンなどを変更することができます。

設定方法は、[wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
の Web ページでご確認ください。

WordPress を構築後に「.wp-env.json」を編集をした場合は、WordPress のサーバーを停止後に、以下のコマンドで環境をアップデートする必要があります。

■ npm

```

npm run wp:update

```

■ yarn

```

yarn wp:update

```

### WordPress のサーバーを停止

開発を中断するなど、WordPress の環境を停止するには以下のコマンドを実行します。

■ npm

```

npm run wp:stop

```

■ yarn

```

yarn wp:stop

```

### WordPress のサーバーを破棄する

開発が終了したなどにより、WordPress の環境を破棄する場合は、以下のコマンドを実行することで、Docker イメージごと削除することができます。

■ npm

```

npm run wp:destroy

```

■ yarn

```

yarn wp:destroy

```

## WordPress テーマの作成

WordPress テーマの PHP ファイルは「src」ディレクトリに配置して下さい。

※「functions.php」の冒頭にある、`require_once('lib/ViteHelper.php'); ` と、その読み込み先である「lib」ディレクトリ内の「ViteHelper.php」は削除しないでください。

### Public ディレクトリ内のアセット

「Public」ディレクトリ内に保存したファイルは、ビルド後に納品用テーマディレクトリとして「dist」ディレクトリにコピーされます。従って開発時とディレクトリの構造が変わるため、以下のいずれかの対策を講じて下さい。

- 「Public」ディレクトリ内にある画像ファイルなどを本番サーバーのルートディレクトリにアップロード
- 「Public」ディレクトリ内のファイルを参照するファイルパスの冒頭に`ViteHelper::PUBLIC_URL` 定数を利用してパスを補完する。

```php
 <link rel="icon" href="<?php echo esc_url(ViteHelper::PUBLIC_URL); ?>/favicon.ico">
```

## CSS/SCSS の開発

「Orelop WP」は、CSS、SCSS のどちらの開発にも対応しています。

### CSS で開発

CSS で開発するには「src/assets/css/」ディレクトリ内にある「style.css」を利用して下さい。

なお、ファイル名を変更する場合は、エントリーポイントである、「src/assets/js/main.js」内で読み込んでいる CSS のファイル名も変更してください。

例：css のファイル名を「common.css」に変更

```js
// import "../css/style.css";
import "../css/common.css";
```

「Orelop WP」は、「[CSS Nesting Module](https://www.w3.org/TR/css-nesting-1/)」に対応しているため、スタイルルールのネスト（入れ子）が利用できます。

例

```css
.hero__figure {
  height: 100vh;

  & img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
```

また、`@import` による、CSS ファイルを分割にも対応しています。

例：「object」ディレクトリ内の「hero.css」と「post.css」の読み込み

```css
@import "object/hero.css";
@import "object/post.css";
```

### SCSS で開発

scss を使って CSS を開発する場合は、「src/assets/scss/」ディレクトリ内にある「style.scss」を利用して下さい。

glob パターンによる読み込みにも対応しています。

例：「fondation」ディレクトリと「layout」ディレクトリ内にあるすべての.scss ファイルの読み込み

```scss
@use "foundation/**/*.scss";
@use "layout/**/*.scss";
```

## JavaScript の開発

JavaScript の開発は「src/assets/js/」ディレクトリ内の「main.js」を利用して下さい。

このファイルが「Orelop WP」のエントリーポイントとなっています。

## 納品データの準備

以下のコマンドを実行すると、「dist」ディレクトリが作成され、納品用のテーマファイルが生成されます。

■ npm

```
npm run build
```

■ yarn

```
yarn build
```

ビルドを行うと、「src/assets/img/」ディレクトリ内の画像ファイルを最適化（圧縮や、webp ファイルなどの生成）を行い、ハッシュ値をつけて「dist/assets/img/」内に配置されます。

画像の圧縮率や、生成するフォーマットなどに関しては、[vite-plugin-image-oretimaizer](https://github.com/hilosiva/vite-plugin-image-oretimaizer)を利用しているため、[vite-plugin-image-oretimaizer](https://github.com/hilosiva/vite-plugin-image-oretimaizer)のオプションで設定して下さい。

PHP ファイルや、css ファイル内の画像ファイルのパスは自動でファイルパスが置き換わります。（webp が利用できるブラウザで閲覧した場合、「.jpg」や「.png」ファイルは、webp ファイルがレスポンスされます。）

.scss ファイルや.css ファイルは、「dist/assets/css/」内に「main-[ハッシュ値].css」というファイル名で配置されます。

.js ファイルは「dist/assets/css/」内に「main-[ハッシュ値].js」というファイル名で配置されます。

## 納品データのプレビュー

以下のコマンドを実行すると、「dist」ディレクトリをテーマフォルダとして、サーバーが立ち上がります。

■ npm

```
npm run preview
```

■ yarn

```
yarn preview
```

## データベースのエクスポート

以下のコマンドを実行すると、「sql/」ディレクトリに「wpenv.sql」という SQL ファイルがエクスポートされます。

■ npm

```
npm run wp:export
```

■ yarn

```
yarn wp:export
```

## データベースのインポート

以下のコマンドを実行すると、「sql/」ディレクトリにある「wpenv.sql」という SQL ファイルをインポートします。

■ npm

```
npm run wp:import
```

■ yarn

```
yarn wp:import
```

## ライセンス

[GNU General Public License v3 or later](https://www.gnu.org/licenses/gpl-3.0.html)

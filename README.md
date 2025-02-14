# Orelop WP（仮）

![screenshot](https://github.com/hilosiva/orelop-wp/blob/main/src/screenshot.png)

## 概要

Orelop WP は、俺流の WordPress テーマ開発環境です。
WordPress の環境には「[wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)」を利用し、フロントエンドツールには「[vite](https://ja.vitejs.dev/)
」を利用しているため、オールインワンで高速に WordPress のテーマを開発することが可能です。

## 準備

Orelop WP を利用するには、あらかじめ以下のツールをマシンにインストールしておいて下さい。

- [Docker](https://www.docker.com/)
- [Node.js](https://nodejs.org/ja) >= 20


## インストール

1. ターミナルを開き、「Orelop WP」を初期化したいディレクトリに移動します。

```bash
cd /path/to/project-directory
```

2. 以下のコマンドを実行して、「Orelop WP」をインストールします。


■ npm
```bash
npm create orelop@latest --template=wp
```

■ yarn
```bash
yarn create orelop@latest --template=wp
```

■ pnpm
```bash
pnpm create orelop@latest --template=wp
```


プロジェクト名を聞かれるのでプロジェクト名を入力してエンターしてください。

続いて、利用するCSSのプリプロセッサーやフレームワーク（SassやTailwindCSS）や、
JavaScriptのライブラリ（GSAPやLenis、Rola）などを任意で選択してください。



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

■ pnpm
```
pnpm dev
```


※初回は WordPress の環境を構築するため時間が掛かります。

開発環境は、[http://localhost:8080](http://localhost:8080)で立ち上がります。

WordPress の管理画面は、[http://localhost:8080/wp-admin/](http://localhost:8080/wp-admin/)でアクセスできます。

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

■ pnpm
```
pnpm wp:update
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

■ pnpm
```
pnpm wp:stop
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


■ pnpm
```
pnpm wp:destroy
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
（Sassを利用する場合はインストール時にオプションで「Sass」を選択してください。）

CSS で開発するには「src/assets/styles/」ディレクトリ内にある「global.css」を利用し、
SASS で開発する場合は、「global.css」を「global.scss」に変更してください。

なお、ファイル名を変更する場合は、エントリーポイントである、「src/assets/scripts/main.js」内で読み込んでいる CSS のファイル名も変更してください。

例：cssを「global.scss」に変更

```js
// import "../styles/global.css";
import "../styles/global.scss";
```



### ベースCSS
「global.css」にはデフォルトで以下の記述により俺流のベーススタイルのCSSを読み込んでいます。

```css
@import "vaultcss";
```

これにより、俺流のリセットや便利なカスタムプロパティなどが利用できます。

不必要な場合は削除してください。
また、resetのみ利用したい場合には、以下のように resetスタイルのみ読み込むことも可能です。

```css
@import "vaultcss/reset";
```


### ネスティングルール
「Orelop Static」は、「[CSS Nesting Module](https://www.w3.org/TR/css-nesting-1/)」に対応しているため、スタイルルールのネスト（入れ子）が利用できます。

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

### カスタムメディアクエリ
カスタムメディアクエリを使うことも可能です。

デフォルトでは、以下のカスタムメディアクエリが自動で登録されます。


```css
@custom-media --xxs (width >= 23.4375rem);
@custom-media --xs (width >= 25rem);
@custom-media --sm (width >= 36rem);
@custom-media --md (width >= 48rem);
@custom-media --lg (width >= 64rem);
@custom-media --xl (width >= 80rem);
@custom-media --xxl (width >= 96rem);
```


従って、以下のように少ない記述量でレスポンシブ対応が可能です。


```css
.section {
  display: block grid;
  grid-template-columns: repeat(var(--cols, 1), minmax(0, 1fr));

  @media (--md) {
    --cols: 2;
  }

  @media (--lg) {
    --cols: 3;
  }
}
```


### @import

`@import` による、CSS ファイルの分割にも対応しています。

例：「base」ディレクトリ内の「reset.css」と「components」ディレクトリ内の「hero.css」の読み込み

```css
@layer settings, base, layouts, vendors, components, utilities;

@import "base/reset.css" layer(base);
@import "components/hero.css" layer(components);
```



Sassの場合は、glob パターンによる読み込みにも対応しています。

例：「fondation」ディレクトリと「layout」ディレクトリ内にあるすべての.scss ファイルの読み込み

```scss
@use "foundation/**/*.scss";
@use "layout/**/*.scss";
```

### オリジナル関数
CSSファイル内では、下記のオリジナル関数が利用可能です。

- `fluid()` : 最小値、最大値から `clamp()` を生成

```css
p {
  /*
    fluid(最小値, 最大値, [最小ビューポート(px)], [最大ビューポート(px)])
    最小ビューポートの初期値： 320
    最大ビューポートの初期値： 1920
  */
  font-size: fluid(16px 24px); /* clamp(1rem, 0.8786407766990291rem + 0.517799352750809vw, 1.5rem) */
}
```

最小値と最大値には `px` または `rem` が使えます。


最小ビューポートや、 最大ビューポートの初期値を変更する場合は、`vite.config.ts` で、`vaultcss(),` のオプションを指定します。

```ts
export default defineConfig({
  ...
  plugins: [
    ...
    vaultcss({
      fluid: {
        minViewPort: 375, // 最小ビューポートの初期値を 375 に変更
        maxViewPort: 1440, // 最大ビューポートの初期値を 1440 に変更
        baseFontSize: 16, // ベースのフォントサイズ（規定値: 16）
      }
    }),
  ],
  ...
})
```




## JavaScript の開発

JavaScript の開発は「src/assets/scripts/」ディレクトリ内の「main.js」を利用して下さい。

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

■ pnpm
```
pnpm build
```

ビルドを行うと、「src/assets/images/」ディレクトリ内の画像ファイルを最適化（圧縮や、webp ファイルなどの生成）を行い、ハッシュ値をつけて「dist/assets/images/」内に配置されます。

画像の圧縮率や、生成するフォーマットなどに関しては、[@hilosiva/vite-plugin-image-optimizer](https://github.com/hilosiva/vite-plugins/tree/main/packages/vite-plugin-image-optimizer)を利用しているため、[@hilosiva/vite-plugin-image-optimizer](https://github.com/hilosiva/vite-plugins/tree/main/packages/vite-plugin-image-optimizer)のオプションで設定して下さい。

PHP ファイルや、css ファイル内の画像ファイルのパスは自動でファイルパスが置き換わります。（webp が利用できるブラウザで閲覧した場合、「.jpg」や「.png」ファイルは、webp ファイルがレスポンスされます。）

.scss ファイルや.css ファイルは、「dist/assets/styles/」内に「index-[ハッシュ値].css」というファイル名で配置されます。

.js ファイルは「dist/assets/scripts/」内に「main-[ハッシュ値].js」というファイル名で配置されます。

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

■ pnpm
```
pnpm preview
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

■ pnpm

```
pnpm wp:export
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

■ pnpm

```
pnpm wp:import
```


## ライセンス

[GNU General Public License v3 or later](https://www.gnu.org/licenses/gpl-3.0.html)

# Orelop WP（仮）

## 概要

Orelop WP は、俺流の WordPress テーマ開発環境です。
WordPress の環境には「[wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)」を利用し、フロントエンドツールには「[wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
」を利用しているため、オールインワンで高速に WordPress のテーマを開発することが可能です。

## インストール

Orelop WP を利用するには、あらかじめ以下のツールを用意しておいて下さい。

- [Docker](https://www.docker.com/)
- [Node.js](https://nodejs.org/ja) >=16.0.0
- [git](https://git-scm.com/)

  ターミナルを起動し「orelop-wp」ディレクトリに移動後、以下のコマンドを入力するとインストールが始まります。

■ npm

```
npm install
```

■ yarn

```
yarn install
```

## 使い方

### WordPress の環境を準備とサーバーの立ち上げ

WordPress 環境は以下のコマンドで構築できます。

■ npm

```
npm run wp:start
```

■ yarn

```
yarn wp:start
```

インストールが完了すると、WordPress の環境が立ち上がります。

※初回はインストールを行うため時間が掛かります。

#### WordPress のサーバーが立ち上がったかを確認する

以下のコマンドで、サーバーが立ち上がっているかを確認できます。

```
docker ps
```

### WordPress のサーバーを停止

WordPress の環境を停止するには以下のコマンドを実行します。

■ npm

```
npm run wp:stop
```

■ yarn

```
yarn wp:stop
```

### WordPress の環境を変更する

デフォルトでは、WordPress の日本語の最新版がインストールされます。

ルートディレクトリにある「.wp-env.json」を編集することで、インストールする WordPress のバージョンや、利用する PHP のバージョンなどを変更することができます。

WordPress を構築後に「.wp-env.json」を編集をした場合は、WordPress のサーバーを停止後に、以下のコマンドで環境をアップデートする必要があります。

■ npm

```
npm run wp:update
```

■ yarn

```
yarn wp:update
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

### フロントエンド開発サーバーの起動

■ npm

```
npm run dev
```

■ yarn

```
yarn dev
```

開発は「src」ディレクトリ内で行います。

- js： src/assets/js/main.js
- scss: src/assets/scss/style.scss
- css: src/assets/css/style.css

## 納品データの準備

■ npm

```
npm run build
```

■ yarn

```
yarn build
```

## 納品データのプレビュー

■ npm

```
npm run preview
```

■ yarn

```
yarn preview
```


# アンケート交換サービス Trade-Anke
## 概要
ユーザー同士で、作成したアンケートを答え合うサービスです。作成したアンケートを配布することができますが、自分のアンケートを回答してもらうためには、誰かのアンケートを回答しなければならない仕組みです。

## 作成背景
　私が大学で社会調査について勉強した際、一番に感じたのはアンケート調査のハードルの高さです。特に個人で行うアンケートは、回答者が偏った集団になってしまったり、そもそも十分な人数を確保できなくなくなり、アンケート調査として信頼性の低いものになってしまうでしょう。
　この問題を解決するために、このサービスを作りました。このサービスの特徴は、自分で作成したアンケートを配るためには、まず配られた他人のアンケートに回答してポイントをゲットしなければならないという点です。そうしてポイントをゲットできれば、配る人数・年代・性別を指定して、アンケートを配布することができます。
　こうしてアンケート調査を行い人たちが集まって、その人たち同士でアンケートを交換しあうしくみがあれば、アンケート調査のハードルを下げることが出来るのではないかと考え、このサービスを作ることにしました。
## URL
https://trade-anke-988ccc2cf047.herokuapp.com/
## テストアカウント
- Email:    test@example.com
- Password: password
## 機能一覧
### アンケート管理
- アンケートの取扱い（作成・詳細確認・削除）機能
- アンケート配布機能
- アンケート結果の確認機能
### インタビュー機能
- 回答者へインタビューができる機能
- インタビュー結果の確認機能
### 外部連携
- Google Formsとの連携（Formsで作ったアンケートを配布することができる）
### その他
- 認証機能
- アンケート結果をCSV出力する機能

## 注力した・苦労した点
### Google Forms APIとの連携
　Google Forms APIの取扱いは、まず日本語での情報が少なく、公式ドキュメントやサンプルコードを読みながら自分の求める機能を作っていくことが大変でした。
　それに加えて、Forms APIはOAuthによる認証が必要なので、その仕組みから学習することに苦労しました。
### 複雑なテーブルの取り扱い
　アンケートとその回答を表現するのに、surveys, questions, answersの3つのテーブルを作成したのですが、「あるアンケートの回答を、ユーザーごとにまとめて取得したい」といったようなときに、どのような処理を書けばいいか、戸惑う部分がありました。
### インタビュー機能の実装
　本サービスにおけるインタビュー機能は、アンケート作成者によるインタビュー申請→回答者による承諾という流れになっているので、この流れを実現するためにテーブルを作成したり、フロントエンドでの工夫をすることに注力をしました。
### ユーザ視点での工夫
　　

## 使用技術
### バックエンド
- PHP 8.1.25
- Laravel 9
- Google APIs Client Library for PHP
- MariaDB
### フロントエンド
- JavaScript
- HTML/CSS(TailWind CSS)
### その他
- Cloud9（開発環境）
- Heroku（デプロイ)

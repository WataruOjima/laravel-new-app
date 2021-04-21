
<img width="1322" alt="スクリーンショット 2021-04-16 0 03 07" src="https://user-images.githubusercontent.com/75024186/114891786-25dc6700-9e47-11eb-876d-cff775abdf31.png">

#  Biborokuまとめ x コミュニケーション

みんなが "シェアしたい" 画像を自由にシェアできる

< 画像投稿コミュニケーションサービス >

## 概要
恋人、友人と遠く離れていても、シェアした画像でつながる

いつでも、どこでも、言葉では伝えきれない思いを気軽に画像で伝え、共有することの大切さ

## 本番環境
https://biboroku-matome-communication.com/ (deleted)
https://gyazo.com/422688c3dc3fe576a75e7f614a190cda

### テストアカウント

email: admin@example.com
password: password

email: test0001@example.com
password: password

### DEMO
https://gyazo.com/3fa6614f76a405e954fe3bfe1b7cad42


## 使い方

1. 「新規登録」ページに遷移をしてユーザー登録をします。
2. 右上「投稿」ボタン、もしくは、「投稿の新規作成」ボタンで投稿ページ遷移、投稿フォームが表示され、各欄を記入と画像の添付をして投稿をします。
3. ホーム（メインページ）の検索窓から検索したいワードを入力すると、検索ができます。
4. ホーム（メインページ）の処理、「詳細」「編集」「削除」ボタンがあります。
5. 自分の投稿のみ「編集」「削除」ができます。
6. 気になった投稿の「詳細」ボタンをクリックすることで、投稿詳細ページへ遷移することができます。
7.  投稿詳細ページ、下にコメント欄があります。自由にコメントを残せます。
8. 画面右上のアカウントのプルダウンから「アカウントの変更」を押すことで、名前、アドレス、パスワードが変更可能
9. 画面右上のアカウントのプルダウンから「ログアウト」を押すことで、いつでもログアウトができます。


## 洗い出した要件
* ユーザー登録
* 投稿投稿機能
* 部分検索機能
* コメント機能

## 実装した機能についてのGIFと説明
* ユーザーのログイン機能とメインページの紹介
https://gyazo.com/eaa331192d106671e9b0f4526b87a110

* 画像投稿機能の実装
https://gyazo.com/2441761b4a0189a98e036d2485c6834f

* コメント機能の実装、コメント数の表示
https://gyazo.com/02c9fa89aef41f7bac684d08b8a40451


## 工夫したポイント
* 画像投稿：S3へ格納する前にリサイズを行い、サーバーに負荷をかけない工夫
* 削除ボタンを押すと、onClickを設定し、ワンクッションありYes,Noで選べること
* AWSでは、独自のドメインを取得、オートスケーリング、ElastiCache(Redis)作成、踏み台サーバ構築、ロードバランサーを作成、webサーバー2台/privateサブネット作成した点

## 課題と実装予定の機能
* 動画投稿機能（現在、写真投稿のみ）
* ユーザーページの作成（プロフィールなど）
* AWSへ自動デプロイの設定


## データベース設計
<img width="496" alt="スクリーンショット 2021-04-16 0 00 41" src="https://user-images.githubusercontent.com/75024186/114891517-eada3380-9e46-11eb-9e5c-d6ede02c433e.png">


# テーブル設計

## users テーブル
| Column           | Type      | Options       |
| ---------------- | --------- | ------------- |
| id               | bigint    | null: false   |
| name             | string    | null: false   |
| email            | string    | null: false   |
| password         | string    | null: false   |
| admin_fig        | boolean   | default(false)|
| update_at        | timestamp |               |
| create_at        | timestamp |               |

### Association
- has_many: posts
- has_many: comments

## posts テーブル
| Column    | Type          | Options     |
| --------- | ------------- | ----------- |
| id        | bigint        | null: false |
| user_id   | reference     | null: false |
| name      | string        | null: false |
| message   | text          | null: false |
| update_at | timestamp     |             |
| create_at | timestamp     |             |


### Association
- belongs_to: user
- has_many: comments

## comments テーブル
| Column    | Type      | Options     |
| --------- | --------- | ----------- |
| id        | bigint    | null: false |
| post_id   | integer   | null: false |
| user_id   | foreign   | null: false |
| name      | string    | null: false |
| comment   | text      | null: false |

### Association
- belongs_to: post
- belongs_to: user

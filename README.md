## ログイン系API

GET /token ログイン

POST /register 新規登録処理

GET /profile プロフィールの取得
PATCH /profile プロフィールの更新
DELETE /profile プロフィールの削除

POST /auth/{type} 認証情報追加
PATCH /auth/{type} 認証情報追加
DELETE /auth/{type} 認証情報削除

## メール認証系

POST /sendmail/invite 招待メール送信
POST /sendmail/reset_pass パスワードリセット
POST /sendmail/change_email Emailアドレス変更



## Action 仕様

受け取ったリクエストは 全て シングルトンの Response オブジェクトを
コンテナ操作で処理する➔ 処理は Middleware が行う。


response は全て Response オブジェクトで返す。



# Usage 

ApiAuth::route()
<?php
use Illuminate\Support\Str;

/**
 * 新規登録からログイン・ログアウトまでのテスト
 * User: mkkn
 * Date: 2016/07/02
 * Time: 11:39
 */
class RegisterTest extends TestCase
{

    protected function getResponseJson($key=null){
        $data = json_decode($this->response->content(),true);
        if($key){
            return array_get($data,$key);
        }else{
            return $data;
        }
    }

    public function sampleUserProvider(){
        $user = [
            "name" => "John",
            "password" => "chatbox1234"
        ];
        $hash = Str::random();
        $user["email"] = "t.goto+$hash@chatbox-inc.com";
        return [
            [// #1
                $user
            ]
        ];
    }

    /**
     * @return mixed
     * @dataProvider sampleUserProvider
     */
    public function testRegisterMail($user)
    {
        $this->post("/profile",[
            "user" => $user
        ]);
        $this->assertResponseOk();

        $this->post("/login", [
            "credential" => [
                "email" => $user["email"],
                "password" => $user["password"],
            ]
        ]);
        $this->assertResponseOk();
        $authtoken = $this->getResponseJson("token.key");
        $this->assertEquals(1, preg_match("#^[a-zA-Z0-9]{6,}$#", $authtoken));

        $this->get("/profile",[
            "X-AUTHTOKEN" => $authtoken
        ]);
        $this->assertResponseOk();

        $this->post("/logout",[],[
            "X-AUTHTOKEN" => $authtoken
        ]);
        $this->assertResponseOk();

        $this->get("/profile",[
            "X-AUTHTOKEN" => $authtoken
        ]);
        $this->assertResponseStatus(500);

    }
}
<?php
use Illuminate\Support\Str;

use Chatbox\ApiAuth\ApiAuthService;
/**
 * ログイン・ログアウトからのシナリオ
 */
class LoginTest extends TestCase
{
    protected $authTokens = [];

    /**
     * @return mixed
     */
    public function testRegister()
    {
        $user = [
            "name" => "John",
            "password" => "chatbox1234"
        ];
        $hash = Str::random();
        $user["email"] = "t.goto+$hash@chatbox-inc.com";

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
        $this->assertArrayHasKey("token",$this->response->getOriginalContent());
        $this->assertInstanceOf(Chatbox\Token\Token::class,$this->response->getOriginalContent()["token"]);
        $authtoken = $this->response->getOriginalContent()["token"]->key;
        $this->assertEquals(1, preg_match("#^[a-zA-Z0-9]{6,}$#", $authtoken));

        $this->_testGetProfile($authtoken,$user);
//        $this->_testUpdateProfile($authtoken,$user);
//
//        $this->_testGetProfile($authtoken,$user);
    }

    protected function _testGetProfile($authtoken,$user){
        $this->get("/profile",[
            "X-AUTHTOKEN" => $authtoken
        ]);
        $this->assertResponseOk();
        $this->assertArrayHasKey("user",$this->response->getOriginalContent());
        $actualUser = $this->response->getOriginalContent()["user"];
        $this->assertInstanceOf(Chatbox\ApiAuth\Domains\User::class,$actualUser);
        $this->assertEquals($user["name"],$actualUser->data["name"]);

    }
    protected function _testUpdateProfile($authtoken,$user){
        $newName = Str::random();
        $this->put("/profile",[
            "user" => [
                "name" => $newName
            ]
        ],[
            "X-AUTHTOKEN" => $authtoken
        ]);
        $this->assertResponseOk();
        $this->assertArrayHasKey("user",$this->response->getOriginalContent());
        $actualUser = $this->response->getOriginalContent()["user"];
        $this->assertInstanceOf(Chatbox\ApiAuth\Domains\User::class,$actualUser);
        $this->assertEquals($user["name"],$actualUser->data["name"]);

    }
}
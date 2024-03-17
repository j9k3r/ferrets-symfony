<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMeActionTest extends WebTestCase
{
    use FixtureTools;

    public function test_get_me_action()
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $uzerz = [
            'LogiN'  => $user->getEmail(),
            'PsW' => $user->getPassword()
        ];

//        var_dump($uzerz); die();

        $client->request(
            'POST',
            'api/auth/token/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ])
        );
        $data = json_decode($client->getResponse()->getContent(), true);

//        var_dump($client->request); die();
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));

        //act
        $client->request('GET', '/api/users/me');

        //assert
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($user->getEmail(), $data['email']);

    }
}
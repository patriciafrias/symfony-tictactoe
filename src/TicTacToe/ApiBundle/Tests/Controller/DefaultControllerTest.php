<?php

namespace TicTacToe\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testStartGame()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/start-game');

        $this->assertEquals('{"status":"OK","data":[["","",""],["","",""],["","",""]]}', $client->getResponse()->getContent());
    }

    public function testUserMove()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/user-move/0/0');

        $this->assertEquals('{"status":"OK","data":[["X","",""],["","",""],["","",""]]}', $client->getResponse()->getContent());
    }

    public function testBotMove()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/bot-move');

        $this->assertEquals('{"status":"OK","data":[["O","",""],["","",""],["","",""]]}', $client->getResponse()->getContent());
    }
}

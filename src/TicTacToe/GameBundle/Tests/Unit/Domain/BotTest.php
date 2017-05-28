<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Bot;

class BotTest extends TestCase
{
    /** @var Board */
    private $boardMock = null;

    public function setUp()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->setMethods(['setPosition'])
            ->getMock();
    }

    public function testMoveShouldCallBoardSetPosition()
    {
        $this->boardMock->expects($this->once())
            ->method('setPosition')
            ->with(0, 1, 'O');

        $bot = new Bot('O');

        $board = $bot->move($this->boardMock);

        $this->assertInstanceOf(Board::class, $board);
    }
}

<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Bot;

class BotTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Board */
    private $boardMock = null;

    public function setUp()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatus', 'setPosition'])
            ->getMock();
    }

    public function testMoveShouldCallBoardSetPosition()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['X', '', ''], ['', '', ''], ['', '', '']]);

        $this->boardMock->expects($this->once())
            ->method('setPosition')
            ->with(1, 1, 'O');

        $bot = new Bot('O');

        $board = $bot->move($this->boardMock);

        $this->assertInstanceOf(Board::class, $board);
    }

    public function testMoveForWinningScenarioShouldMakeWinningMove()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['O', 'O', ''], ['', 'X', ''], ['X', 'X', '']]);

        $this->boardMock->expects($this->once())
            ->method('setPosition')
            ->with(0, 2, 'O');

        $bot = new Bot('O');

        $board = $bot->move($this->boardMock);

        $this->assertInstanceOf(Board::class, $board);
    }
}

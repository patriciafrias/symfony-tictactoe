<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\User;

class UserTest extends TestCase
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
            ->with(0, 0, 'X');

        $user = new User('X', 0, 0);

        $board = $user->move($this->boardMock);

        $this->assertInstanceOf(Board::class, $board);
    }
}

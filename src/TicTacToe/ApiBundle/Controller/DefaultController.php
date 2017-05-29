<?php

namespace TicTacToe\ApiBundle\Controller;

use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Bot;
use TicTacToe\GameBundle\Domain\Game;
use TicTacToe\GameBundle\Domain\User;

/**
 * Class DefaultController
 * @package TicTacToe\ApiBundle\Controller
 */
class DefaultController extends FOSRestController
{
    /**
     * Start game
     * @Rest\Get("/start-game")
     */
    public function startGameAction(Request $request)
    {
        $gameGridSize = $this->container->getParameter('grid_size');

        $board = new Board($gameGridSize);
        $game = new Game($board);

        $session = $request->getSession();
        $session->set('board', $board);

        $data = [
            'status' => 'OK',
            'data' => $game->getBoard()->getStatus(),
        ];

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * User move
     * @Rest\Get("/user-move/{coordinateX}/{coordinateY}")
     */
    public function userMoveAction(Request $request)
    {
        $coordinateX = $request->get('coordinateX');
        $coordinateY = $request->get('coordinateY');

        $session = $request->getSession();
        $board = $session->get('board');

        $game = new Game($board);
        $user = new User(Game::USER_TEAM_ID, $coordinateX, $coordinateY);

        try {
            $game->move($user);

            $data = [
                'status' => 'OK',
                'data' => $game->getBoard()->getStatus(),
            ];
        } catch (Exception $e) {
            $data = [
                'status' => 'KO',
                'data' => $e->getMessage(),
            ];
        }

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Bot move
     * @Rest\Get("/bot-move")
     */
    public function botMoveAction(Request $request)
    {
        $session = new Session();
        $board = $session->get('board');

        $game = new Game($board);
        $bot = new Bot(Game::BOT_TEAM_ID);

        try {
            $game->move($bot);

            $data = [
                'status' => 'OK',
                'data' => $game->getBoard()->getStatus(),
            ];
        } catch (Exception $e) {
            $data = [
                'status' => 'KO',
                'data' => $e->getMessage(),
            ];
        }

        return $this->view($data, Response::HTTP_OK);
    }
}

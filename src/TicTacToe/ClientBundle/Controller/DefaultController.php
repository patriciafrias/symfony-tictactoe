<?php

namespace TicTacToe\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var string */
    const COOKIE_FILE = '/tmp/cookie';

    /** @var string */
    private $baseUrl = 'http://local.ticatactoe.com/app_dev.php';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $content = $this->executeCurlRequest($this->baseUrl . '/api/v1/start-game');

        return $this->render('TicTacToeClientBundle:Default:index.html.twig', ['content' => $content]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userMoveAction(Request $request)
    {
        $coordinateX = $request->get('x');
        $coordinateY = $request->get('y');

        $content = $this->executeCurlRequest($this->baseUrl . "/api/v1/user-move/{$coordinateX}/{$coordinateY}");

        if ($content['status'] == 'OK') {
            return $this->forward('TicTacToeClientBundle:Default:botMove');
        }

        return $this->render('TicTacToeClientBundle:Default:index.html.twig', ['content' => $content]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function botMoveAction(Request $request)
    {
        $content = $this->executeCurlRequest($this->baseUrl . '/api/v1/bot-move');

        return $this->render('TicTacToeClientBundle:Default:index.html.twig', ['content' => $content]);
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function executeCurlRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, self::COOKIE_FILE);
        curl_setopt ($ch, CURLOPT_COOKIEFILE, self::COOKIE_FILE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $content = json_decode($response, true);

        return $content;
    }
}

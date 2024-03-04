<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Playeruser;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchhistoryController extends AbstractController
{
    #[Route('/matchhistory', name: 'app_matchhistory')]
    public function index(): Response
    {
        $summonerName = "cataclysm101";
        $apiKey = "RGAPI-a009f594-105d-43fd-81fd-f5943d11072a";
        $baseUrl = "https://euw1.api.riotgames.com";

        // Retrieve summoner data
        $url = $baseUrl . "/lol/summoner/v4/summoners/by-name/" . rawurlencode($summonerName) . "?api_key=" . $apiKey;
        $response = file_get_contents($url);

        if ($response !== false) {
            $summonerData = json_decode($response, true);

            // Extract puuid from summoner data
            $puuid = $summonerData['puuid'];

            $baseUrl2 = "https://europe.api.riotgames.com";
            // Retrieve match history
            $url = $baseUrl2 . "/lol/match/v5/matches/by-puuid/" . rawurlencode($puuid) . "/ids" . "?start=0&count=5&api_key=" . $apiKey;
            $response = file_get_contents($url);

            if ($response !== false) {
                $matchHistory = json_decode($response, true);

                $firstMatchId = $matchHistory[0]; // Get the first match ID from the array
                $url = $baseUrl2 . "/lol/match/v5/matches/" . rawurlencode($firstMatchId) . "?api_key=" . $apiKey;
                $response = file_get_contents($url);

                if ($response !== false) {
                    $matchdata = json_decode($response, true);
                    $participants = [];

                    // Extract participants from match data

                    foreach ($matchHistory as $matchId) {
                        $url = $baseUrl2 . "/lol/match/v5/matches/" . rawurlencode($matchId) . "?api_key=" . $apiKey;
                        $response = file_get_contents($url);

                        if ($response !== false) {
                            $matchdata = json_decode($response, true);

                            // Extract participants from match data
                            foreach ($matchdata['info']['participants'] as $participantData) {
                                if ($participantData['summonerName'] === $summonerName) {
                                    if ($participantData['win'] == 1) {
                                        $win = "win";
                                    } else {
                                        $win = "lose";
                                    }
                                    $participant = [
                                        'summonerName' => $participantData['summonerName'],
                                        'kills' => $participantData['kills'],
                                        'deaths' => $participantData['deaths'],
                                        'assists' => $participantData['assists'],
                                        'role' => $participantData['role'],
                                        'win' => $win,
                                        'championName'=>$participantData['championName']
                                        // ...
                                    ];

                                    $participants[] = $participant;
                                }
                            }
                        } else {
                            throw new \Exception("Failed to retrieve match data.");
                        }
                    } // Move this closing curly brace here

                    $match = $matchdata;
                    $playerSummonerName = $summonerName; // Assign the value to playerSummonerName variable

                    return $this->render('matchhistory/index.html.twig', [
                        'match' => $match,
                        'playerSummonerName' => $playerSummonerName, // Pass the variable to the template
                        'participants' => $participants, // Pass the participants to the template
                    ]);

                } else {
                    throw new \Exception("Failed to retrieve match data.");
                }
            } else {
                throw new \Exception("Failed to retrieve match history.");
            }
        } else {
            throw new \Exception("Failed to retrieve summoner data.");
        }
    }

}
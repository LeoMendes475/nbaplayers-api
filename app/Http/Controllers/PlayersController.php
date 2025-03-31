<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\Player;

class PlayersController extends Controller
{
    public function findAll()
    {
        $players = Player::all();

        if ($players->isEmpty()) {
            return response()->json(['message' => 'Nenhum jogador encontrado.'], 404);
        }

        return response()->json($players, 200);
    }


    public function saveAllPlayers($players)
    {
        if (empty($players)) {
            return response()->json(['message' => 'Nenhum jogador para salvar. O array está vazio.'], 400);
        }

        try {
            $playerDataArray = [];

            foreach ($players as $playerData) {
                $playerDataArray[] = [
                    'id' => $playerData['id'],
                    'first_name' => $playerData['first_name'],
                    'last_name' => $playerData['last_name'],
                    'team' => $playerData['team']['name'] ?? null,
                    'position' => $playerData['position'] ?? null,
                    'jersey_number' => $playerData['jersey_number'] ?? null,
                    'height' => $playerData['height'] ?? null,
                    'country' => $playerData['country'] ?? null,
                    'created_at' => now(),
                    'updated_at' => null,
                    'deleted_at' => null,
                ];
            }

            foreach ($playerDataArray as $player) {
                Player::create($player);
            }

            return response()->json(['message' => 'Jogadores salvos com sucesso.'], 201);
        } catch (\Exception $e) {
            \Log::error('Erro ao salvar jogadores: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erro ao salvar jogadores.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function fetchAndSavePlayers()
    {
        $apiKey = env('BALLDONTLIE_API_KEY');
        $url = "https://api.balldontlie.io/v1/players";

        $headers = [
            "Authorization: $apiKey",
            "Content-Type: application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Erro ao buscar dados: " . curl_error($ch);
            return null;
        }

        curl_close($ch);

        $data = json_decode($response, true);
        $this->saveAllPlayers($data["data"]);

        return response()->json(['message' => 'Jogadores salvos com sucesso.'], 201);
    }



    public function updatePlayer(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'team' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'jersey_number' => 'nullable|integer|min:0',
            'height' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:255',
        ]);

        $player = Player::findOrFail($id);

        if (!$player) {
            return response()->json(['message' => 'Jogador não encontrado.'], 404);
        }

        $player->fill($validated);

        $player->updated_at = now();

        $player->save();

        return response()->json($player, 200);
    }


    public function deletePlayer($id)
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json(['message' => 'Jogador não encontrado.'], 404);
        }

        $player->delete();

        return response()->json(['message' => 'Jogador deletado com sucesso.'], 200);
    }

    public function teste()
    {
        return 'ok';
    }

}

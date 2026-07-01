<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected $accessToken;
    protected $igUserId;
    protected $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token');
        $this->igUserId = config('services.instagram.user_id');
        $this->baseUrl = 'https://graph.facebook.com/v19.0/';
    }

    /**
     * Mempublikasikan gambar ke feed Instagram
     */
    public function publishPost($imageUrl, $caption)
    {
        if (!$this->accessToken || !$this->igUserId) {
            Log::error('Instagram API: Access Token atau User ID belum diatur di .env');
            return false;
        }

        try {
            // TAHAP 1: Membuat Media Container
            $containerResponse = Http::post($this->baseUrl . $this->igUserId . '/media', [
                'image_url' => $imageUrl,
                'caption' => $caption,
                'access_token' => $this->accessToken,
            ]);

            if (!$containerResponse->successful()) {
                Log::error('IG Container Error: ' . $containerResponse->body());
                return false;
            }

            $creationId = $containerResponse->json('id');

            // TAHAP 2: Mempublikasikan Container tersebut
            $publishResponse = Http::post($this->baseUrl . $this->igUserId . '/media_publish', [
                'creation_id' => $creationId,
                'access_token' => $this->accessToken,
            ]);

            if (!$publishResponse->successful()) {
                Log::error('IG Publish Error: ' . $publishResponse->body());
                return false;
            }

            // Berhasil, kembalikan ID Postingan dari Instagram
            return $publishResponse->json('id');

        } catch (\Exception $e) {
            Log::error('IG Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}
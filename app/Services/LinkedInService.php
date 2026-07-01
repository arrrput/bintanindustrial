<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInService
{
    protected $accessToken;
    protected $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.linkedin.access_token');
        $this->baseUrl = 'https://api.linkedin.com/v2/';
    }

    /**
     * DEBUG ONLY: Mendaftarkan organisasi yang bisa diakses oleh token ini
     */
    public function listMyOrganizations()
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->get($this->baseUrl . 'organizationalEntityAcls?q=roleAssignee');
            
            if ($response->successful()) {
                Log::debug('LinkedIn: Accessible Organizations:', $response->json());
            } else {
                Log::error('LinkedIn: Could not list organizations. Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('LinkedIn listMyOrganizations Exception: ' . $e->getMessage());
        }
    }

    /**
     * Mendapatkan URN Author (Organization atau Person)
     */
    public function getAuthorUrn()
    {
        // Default ke Profile Person sesuai permintaan user karena kendala izin Organization
        try {
            $response = Http::withToken($this->accessToken)
                ->get($this->baseUrl . 'userinfo');

            if ($response->successful()) {
                $sub = $response->json('sub');
                $urn = "urn:li:person:" . $sub;
                Log::debug('LinkedIn: Using Person URN: ' . $urn);
                return $urn;
            }

            Log::error('LinkedIn getAuthorUrn Error: ' . $response->body());
            
            // Fallback ke Organization jika ada di config dan Person gagal
            $orgId = config('services.linkedin.organization_id');
            if ($orgId) {
                return "urn:li:organization:" . trim($orgId);
            }

            return false;
        } catch (\Exception $e) {
            Log::error('LinkedIn getAuthorUrn Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Meregistrasikan aset media (gambar/video) di LinkedIn
     */
    public function registerMediaAsset($mediaType, $authorUrn)
    {
        $recipe = ($mediaType === 'image') ? 'urn:li:digitalmediaRecipe:feedshare-image' : 'urn:li:digitalmediaRecipe:feedshare-video';

        try {
            $payload = [
                'registerUploadRequest' => [
                    'recipes' => [$recipe],
                    'owner' => $authorUrn,
                    'serviceRelationships' => [
                        [
                            'relationshipType' => 'OWNER',
                            'identifier' => 'urn:li:userGeneratedContent'
                        ]
                    ]
                ]
            ];
            
            Log::debug('LinkedIn registerMediaAsset Payload:', $payload);

            $response = Http::withToken($this->accessToken)
                ->withHeaders(['X-Restli-Protocol-Version' => '2.0.0'])
                ->post($this->baseUrl . 'assets?action=registerUpload', $payload);

            if ($response->successful()) {
                $data = $response->json();
                Log::debug('LinkedIn registerMediaAsset Success:', $data);
                
                $uploadUrl = $data['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'] 
                           ?? $data['value']['uploadMechanism']['com.linkedin.ads.common.networks.ajs.TightRPCUploadMechanism']['uploadUrl'] 
                           ?? null;
                
                $asset = $data['value']['asset'] ?? null;
                
                if ($uploadUrl && $asset) {
                    return ['uploadUrl' => $uploadUrl, 'asset' => $asset];
                }
                
                Log::error('LinkedIn registerMediaAsset: URL or Asset missing in success response.', ['response' => $data]);
            } else {
                Log::error('LinkedIn registerMediaAsset Error: ' . $response->body() . ' | Author: ' . $authorUrn);
            }

            return false;
        } catch (\Exception $e) {
            Log::error('LinkedIn registerMediaAsset Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengunggah file fisik ke LinkedIn
     */
    public function uploadMediaFile($uploadUrl, $filePath)
    {
        if (!$uploadUrl) return false;

        try {
            $fileContent = file_get_contents($filePath);
            $response = Http::withToken($this->accessToken)
                ->withHeaders(['X-Restli-Protocol-Version' => '2.0.0'])
                ->withBody($fileContent, 'application/octet-stream')
                ->put($uploadUrl);

            if (!$response->successful()) {
                Log::error('LinkedIn uploadMediaFile Error: ' . $response->body());
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('LinkedIn uploadMediaFile Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Membuat postingan (dengan media jika ada) di LinkedIn
     */
    public function publishPost($text, $mediaPath = null)
    {
        if (!$this->accessToken) {
            Log::error('LinkedIn API: Access Token belum diatur di .env');
            return false;
        }

        $authorUrn = $this->getAuthorUrn();
        if (!$authorUrn) return false;

        $mediaAsset = null;
        $mediaType = 'NONE';

        if ($mediaPath && file_exists($mediaPath)) {
            $mimeType = mime_content_type($mediaPath);
            $mediaType = str_contains($mimeType, 'video') ? 'video' : 'image';

            $registration = $this->registerMediaAsset($mediaType, $authorUrn);
            if ($registration) {
                if ($this->uploadMediaFile($registration['uploadUrl'], $mediaPath)) {
                    $mediaAsset = $registration['asset'];
                }
            }
        }

        try {
            $shareMediaCategory = ($mediaType === 'image') ? 'IMAGE' : (($mediaType === 'video') ? 'VIDEO' : 'NONE');

            $shareContent = [
                'shareCommentary' => [
                    'text' => $text
                ],
                'shareMediaCategory' => $shareMediaCategory
            ];

            if ($mediaAsset) {
                $shareContent['media'] = [
                    [
                        'status' => 'READY',
                        'media' => $mediaAsset
                    ]
                ];
            }

            $publishPayload = [
                'author' => $authorUrn,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => $shareContent
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ];

            Log::debug('LinkedIn publishPost Payload:', $publishPayload);

            $response = Http::withToken($this->accessToken)
                ->withHeaders([
                    'X-Restli-Protocol-Version' => '2.0.0',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . 'ugcPosts', $publishPayload);

            if (!$response->successful()) {
                Log::error('LinkedIn Publish Error: ' . $response->body() . ' | Payload: ' . json_encode($publishPayload));
                return false;
            }

            return $response->json('id');

        } catch (\Exception $e) {
            Log::error('LinkedIn Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}

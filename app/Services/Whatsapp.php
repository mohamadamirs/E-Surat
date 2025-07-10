<?php

namespace App\Services;

class Whatsapp
{
    protected $to;
    protected $lines = [];
    protected $apikey;
    protected $url;
    protected $sender;
    protected $media = null;
    protected $mediaType;
    protected $conn;

    public function __construct($lines = [])
      {
        $this->apikey = config('whatsapp.api_key');
        $this->sender = config('whatsapp.sender');
        $this->url    = config('whatsapp.base_url');
        
        $this->lines = $lines;
    }


    public function media($media): self
    {
        $this->media = $media;
        return $this;
    }

    public function mediaType($mediaType): self
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;
        return $this;
    }

    public function formatText($text, $format): self
    {
        $formattedText = " {$format}{$text}{$format}";
        if (!empty($this->lines)) {
            $this->lines[count($this->lines) - 1] .= $formattedText;
        } else {
            $this->lines[] = $formattedText;
        }
        return $this;
    }

    public function bold($text): self
    {
        return $this->formatText($text, '*');
    }

    public function italic($text): self
    {
        return $this->formatText($text, '_');
    }

    public function code($text): self
    {
        return $this->formatText($text, '`');
    }

    public function separator(): self
    {
        $this->lines[] = str_repeat('-', 35);
        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;
        return $this;
    }

    public function send()
    {
        // return $this->lines;
        if (!$this->to && !count($this->lines)) {
            return false;
        }

        $route = $this->media ? '/send-media' : '/send-message';
        if ($route == '/send-media') {
            $postData = 'sender=' . $this->sender . '&api_key=' . $this->apikey . '&number=' . $this->to . '&media_type=' . $this->mediaType . '&caption=' . join("\n", $this->lines) . '&url=' . $this->media;
        } else {
            $postData = 'sender=' . $this->sender . '&api_key=' . $this->apikey . '&number=' . $this->to . '&message=' . join("\n", $this->lines);
        }


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        try {
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

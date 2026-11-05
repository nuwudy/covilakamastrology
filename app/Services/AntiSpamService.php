<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AntiSpamService
{
    /**
     * Known spam patterns for gambling, bot affiliate links, and automated scanners
     */
    protected const SPAM_KEYWORDS = [
        '[url=', '[/url]', '<a href=', 'href=',
        '1win', 'mostbet', 'pinco', 'chicken-road', 'chicken_road', 'chickenroad',
        'скачать', 'казино', 'ставки', 'онлайн', 'без вирусов',
        'мостбет', 'пинко', 'vulcan', 'vulkan', 'casino', 'betting', 'gambling',
        '.shop]', '.top]', '.xyz]', '.ru]', '.click]',
        'click mostbet', 'descargar desde sitio oficial', 'error de conexion',
        'stumbled upon your blog', 'enjoyed surfing around your blog',
    ];

    /**
     * Known bot username prefixes / regex
     */
    protected const BOT_NAME_REGEX = '/^(1win|mostbet|pinco|chicken[_-]?road|GeorgeHex)/i';

    /**
     * Check if an incoming HTTP request matches spam bot signatures.
     */
    public static function isSpam(Request $request): bool
    {
        // 1. Honeypot check - if hidden bot field is filled, it's 100% an automated bot
        if (
            $request->filled('website_url') ||
            $request->filled('lead_fax_code') ||
            $request->filled('company_tax_id')
        ) {
            return true;
        }

        // 2. Combine text inputs for deep inspection
        $textToInspect = implode(' ', [
            (string)$request->input('name', ''),
            (string)$request->input('message', ''),
            (string)$request->input('service_requested', ''),
            (string)$request->input('email', ''),
            (string)$request->input('phone', ''),
            (string)$request->input('whatsapp_number', ''),
            (string)$request->input('birth_place', ''),
        ]);

        $lowerText = mb_strtolower($textToInspect, 'UTF-8');

        // Check for BBCode [url=...] or HTML <a href in inquiries
        if (str_contains($lowerText, '[url=') || str_contains($lowerText, '[/url]') || str_contains($lowerText, '<a href')) {
            return true;
        }

        // Check for spam keywords
        foreach (self::SPAM_KEYWORDS as $keyword) {
            if (str_contains($lowerText, $keyword)) {
                return true;
            }
        }

        // Check bot usernames like 1win_xxxx, chicken-road_xxxx, mostbet_xxxx, GeorgeHex
        $name = trim((string)$request->input('name', ''));
        if (preg_match(self::BOT_NAME_REGEX, $name)) {
            return true;
        }

        // Bot names ending in random alphanumeric suffix like _kjea, _rnmi, _wzMt, _lymt, _ilpa
        if (preg_match('/^[a-z0-9_-]+_[a-z0-9]{4}$/i', $name) && (str_contains($lowerText, 'http') || str_contains($lowerText, '.shop'))) {
            return true;
        }

        // Moscow birthplace + links or shopping/betting domains
        $place = (string)$request->input('birth_place', '');
        if (strcasecmp(trim($place), 'Moscow') === 0 && (str_contains($lowerText, 'http') || str_contains($lowerText, '.shop'))) {
            return true;
        }

        // External URLs in the message or name
        $msg = (string)$request->input('message', '');
        if (preg_match('/https?:\/\//i', $name) || (preg_match('/https?:\/\//i', $msg) && !str_contains($msg, 'covilakamastrology.com'))) {
            return true;
        }

        return false;
    }

    /**
     * Apply spam query filter to Eloquent Builder.
     */
    public static function applySpamQuery(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('name', 'like', '1win%')
              ->orWhere('name', 'like', 'mostbet%')
              ->orWhere('name', 'like', 'pinco%')
              ->orWhere('name', 'like', 'chicken-road%')
              ->orWhere('name', 'like', 'chicken_road%')
              ->orWhere('name', 'like', '%GeorgeHex%')
              ->orWhere('name', 'like', '%Robyn%')
              ->orWhere('message', 'like', '%[url=%')
              ->orWhere('message', 'like', '%[/url]%')
              ->orWhere('message', 'like', '%.shop%')
              ->orWhere('message', 'like', '%.top%')
              ->orWhere('message', 'like', '%скачать%')
              ->orWhere('message', 'like', '%мостбет%')
              ->orWhere('message', 'like', '%пинко%')
              ->orWhere('message', 'like', '%stumbled upon your blog%')
              ->orWhere('message', 'like', '%enjoyed surfing around your blog%')
              ->orWhere('message', 'like', '%http://%')
              ->orWhere('message', 'like', '%https://%');
        });
    }
}

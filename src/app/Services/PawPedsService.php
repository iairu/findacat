<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PawPedsService
{
    protected $baseUrl = 'https://pawpeds.com';

    /**
     * Fetch cat data from PawPeds database
     *
     * @param string $regNumber Registration number to search
     * @param string $breed Breed code (e.g., 'nfo' for Norwegian Forest Cat)
     * @return array|null
     */
    public function fetchCatData(string $regNumber, string $breed = 'nfo')
    {
        try {
            // PawPeds URL pattern: https://pawpeds.com/db/?a=p&id=REGNO&g=4&p=breed&date=newest
            $url = "{$this->baseUrl}/db/";

            $response = Http::timeout(10)->get($url, [
                'a' => 'p',
                'id' => $regNumber,
                'g' => '4', // 4 generations
                'p' => $breed,
                'date' => 'newest'
            ]);

            if ($response->successful()) {
                return $this->parsePawPedsHtml($response->body());
            }

            Log::warning('PawPeds fetch failed', [
                'status' => $response->status(),
                'regNumber' => $regNumber
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PawPeds fetch error', [
                'error' => $e->getMessage(),
                'regNumber' => $regNumber
            ]);
            return null;
        }
    }

    /**
     * Parse PawPeds HTML response to extract cat data
     *
     * @param string $html
     * @return array
     */
    protected function parsePawPedsHtml(string $html)
    {
        $data = [
            'full_name' => null,
            'ems_color' => null,
            'breed' => null,
            'dob' => null,
            'gender' => null,
            'sire_name' => null,
            'sire_reg' => null,
            'dam_name' => null,
            'dam_reg' => null,
            'titles_before_name' => null,
            'titles_after_name' => null,
            'breeder' => null,
            'owner' => null,
        ];

        // Create DOMDocument to parse HTML
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);

        // Extract cat name (usually in a header or prominent div)
        $nameNodes = $xpath->query("//div[@class='cat-name']|//h1|//h2");
        if ($nameNodes->length > 0) {
            $fullText = trim($nameNodes->item(0)->textContent);
            $data['full_name'] = $this->extractCatName($fullText);
        }

        // Extract EMS color code (usually after name)
        $emsPattern = '/\[([A-Z]{3}\s*\d*[a-z]*)\]/';
        if (preg_match($emsPattern, $html, $matches)) {
            $data['ems_color'] = trim($matches[1]);
        }

        // Extract date of birth (look for date patterns)
        $dobPattern = '/(?:born|dob|birth)[:\s]*(\d{4}[-\/]\d{2}[-\/]\d{2}|\d{2}[-\/]\d{2}[-\/]\d{4})/i';
        if (preg_match($dobPattern, $html, $matches)) {
            $data['dob'] = $this->normalizeDate($matches[1]);
        }

        // Extract gender from context
        if (preg_match('/\b(male|female|M|F)\b/i', $html, $matches)) {
            $gender = strtolower($matches[1]);
            $data['gender'] = (in_array($gender, ['male', 'm'])) ? 1 : 2;
        }

        // Extract sire (father) information
        $sirePattern = '/(?:sire|father)[:\s]*([^\n<]+?)(?:\[([^\]]+)\])?/i';
        if (preg_match($sirePattern, $html, $matches)) {
            $data['sire_name'] = trim($matches[1]);
            if (isset($matches[2])) {
                $data['sire_reg'] = trim($matches[2]);
            }
        }

        // Extract dam (mother) information
        $damPattern = '/(?:dam|mother)[:\s]*([^\n<]+?)(?:\[([^\]]+)\])?/i';
        if (preg_match($damPattern, $html, $matches)) {
            $data['dam_name'] = trim($matches[1]);
            if (isset($matches[2])) {
                $data['dam_reg'] = trim($matches[2]);
            }
        }

        // Extract breeder information
        $breederPattern = '/(?:breeder)[:\s]*([^\n<]+)/i';
        if (preg_match($breederPattern, $html, $matches)) {
            $data['breeder'] = trim($matches[1]);
        }

        // Extract owner information
        $ownerPattern = '/(?:owner)[:\s]*([^\n<]+)/i';
        if (preg_match($ownerPattern, $html, $matches)) {
            $data['owner'] = trim($matches[1]);
        }

        // Extract titles
        $titlePattern = '/^(CH|GC|IC|EC|INT|DK|SE|NO|FI|DM|DSM|GIP|GIC|GP|SGC|RW|BW|NW|CW)\s+/';
        if (preg_match($titlePattern, $data['full_name'] ?? '', $matches)) {
            $data['titles_before_name'] = trim($matches[1]);
            $data['full_name'] = trim(preg_replace($titlePattern, '', $data['full_name']));
        }

        return array_filter($data); // Remove null values
    }

    /**
     * Extract clean cat name from text
     */
    protected function extractCatName(string $text)
    {
        // Remove common prefixes/suffixes
        $text = preg_replace('/\s*\[.*?\]\s*/', '', $text);
        $text = preg_replace('/\s*\(.*?\)\s*/', '', $text);
        return trim($text);
    }

    /**
     * Normalize date to Y-m-d format
     */
    protected function normalizeDate(string $date)
    {
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Search for cats by name
     *
     * @param string $name
     * @param string $breed
     * @return array
     */
    public function searchByName(string $name, string $breed = 'nfo')
    {
        try {
            $url = "{$this->baseUrl}/db/";

            $response = Http::timeout(10)->get($url, [
                'a' => 's',
                'f' => $name,
                'p' => $breed,
            ]);

            if ($response->successful()) {
                return $this->parseSearchResults($response->body());
            }

            return [];
        } catch (\Exception $e) {
            Log::error('PawPeds search error', [
                'error' => $e->getMessage(),
                'name' => $name
            ]);
            return [];
        }
    }

    /**
     * Parse search results
     */
    protected function parseSearchResults(string $html)
    {
        $results = [];
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);

        // Extract search result links
        $links = $xpath->query("//a[contains(@href, '?a=p&id=')]");

        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('/id=([^&]+)/', $href, $matches)) {
                $results[] = [
                    'reg_number' => $matches[1],
                    'name' => trim($link->textContent)
                ];
            }
        }

        return $results;
    }
}

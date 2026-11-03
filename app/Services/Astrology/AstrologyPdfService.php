<?php

namespace App\Services\Astrology;

use App\Models\AstrologyReading;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class AstrologyPdfService
{
    /**
     * Create and configure an mPDF instance with Indic font support.
     */
    protected function createMpdfInstance(string $title = 'Covilakam Vedic Astrology Jathakam'): Mpdf
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $customFontDir = resource_path('fonts');
        $extraFonts = [];
        $extraDirs = [];
        if (is_dir($customFontDir) && file_exists($customFontDir . '/Nirmala.ttf')) {
            $extraDirs[] = $customFontDir;
            $extraFonts['nirmala'] = [
                'R' => 'Nirmala.ttf',
                'B' => 'NirmalaB.ttf',
            ];
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 18,
            'margin_bottom' => 18,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_header' => 8,
            'margin_footer' => 8,
            'fontDir' => array_merge($fontDirs, $extraDirs),
            'fontdata' => $fontData + $extraFonts,
            'default_font' => !empty($extraFonts) ? 'nirmala' : 'dejavusans',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'tempDir' => storage_path('app/temp-mpdf'),
        ]);

        $mpdf->SetTitle($title);
        $mpdf->SetAuthor('Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)');
        $mpdf->SetCreator('Covilakam Astrology (www.covilakamastrology.com)');

        return $mpdf;
    }

    /**
     * Generate Tier 2: ₹100 Certified Vedic DOB Profile PDF (6–8 Pages).
     */
    public function generateTier100Pdf(AstrologyReading $reading, ?string $lang = null): string
    {
        $chartData = is_array($reading->chart_data) ? $reading->chart_data : json_decode($reading->chart_data, true);
        $lang = $lang ?: ($reading->language ?: 'en');

        $mpdf = $this->createMpdfInstance("Covilakam Certified DOB Profile - {$reading->full_name}");

        $html = view('pdf.tier-100', [
            'reading' => $reading,
            'chartData' => $chartData,
            'lang' => $lang,
        ])->render();

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp-mpdf'))) {
            @mkdir(storage_path('app/temp-mpdf'), 0777, true);
        }

        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S'); // Return as string
    }

    /**
     * Generate Tier 3: ₹500 Deluxe Vedic Jathakam PDF (20–25+ Pages).
     */
    public function generateTier500Pdf(AstrologyReading $reading, ?string $lang = null): string
    {
        $chartData = is_array($reading->chart_data) ? $reading->chart_data : json_decode($reading->chart_data, true);
        $lang = $lang ?: ($reading->language ?: 'en');

        $mpdf = $this->createMpdfInstance("Covilakam Deluxe Vedic Jathakam - {$reading->full_name}");

        $html = view('pdf.tier-500', [
            'reading' => $reading,
            'chartData' => $chartData,
            'lang' => $lang,
        ])->render();

        if (!file_exists(storage_path('app/temp-mpdf'))) {
            @mkdir(storage_path('app/temp-mpdf'), 0777, true);
        }

        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }
}


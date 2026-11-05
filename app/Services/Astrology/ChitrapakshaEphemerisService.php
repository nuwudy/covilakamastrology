<?php

namespace App\Services\Astrology;

use Carbon\Carbon;

class ChitrapakshaEphemerisService
{
    /**
     * Built-in city coordinates directory for Kerala, India & Global Malayali hubs
     */
    public const CITY_COORDINATES = [
        'ernakulam' => ['name' => 'Ernakulam / Kochi, Kerala', 'lat' => 9.9312, 'lng' => 76.2673, 'tz' => 'Asia/Kolkata'],
        'kochi' => ['name' => 'Kochi / Ernakulam, Kerala', 'lat' => 9.9312, 'lng' => 76.2673, 'tz' => 'Asia/Kolkata'],
        'thrissur' => ['name' => 'Thrissur, Kerala', 'lat' => 10.5276, 'lng' => 76.2144, 'tz' => 'Asia/Kolkata'],
        'mathilakam' => ['name' => 'Mathilakam / Kodungallur, Kerala', 'lat' => 10.2815, 'lng' => 76.1653, 'tz' => 'Asia/Kolkata'],
        'kodungallur' => ['name' => 'Kodungallur, Kerala', 'lat' => 10.2218, 'lng' => 76.1973, 'tz' => 'Asia/Kolkata'],
        'guruvayur' => ['name' => 'Guruvayur, Kerala', 'lat' => 10.5940, 'lng' => 76.0410, 'tz' => 'Asia/Kolkata'],
        'thiruvananthapuram' => ['name' => 'Thiruvananthapuram (Trivandrum), Kerala', 'lat' => 8.5241, 'lng' => 76.9366, 'tz' => 'Asia/Kolkata'],
        'trivandrum' => ['name' => 'Thiruvananthapuram (Trivandrum), Kerala', 'lat' => 8.5241, 'lng' => 76.9366, 'tz' => 'Asia/Kolkata'],
        'kozhikode' => ['name' => 'Kozhikode (Calicut), Kerala', 'lat' => 11.2588, 'lng' => 75.7804, 'tz' => 'Asia/Kolkata'],
        'calicut' => ['name' => 'Kozhikode (Calicut), Kerala', 'lat' => 11.2588, 'lng' => 75.7804, 'tz' => 'Asia/Kolkata'],
        'kottayam' => ['name' => 'Kottayam, Kerala', 'lat' => 9.5916, 'lng' => 76.5222, 'tz' => 'Asia/Kolkata'],
        'alappuzha' => ['name' => 'Alappuzha (Alleppey), Kerala', 'lat' => 9.4981, 'lng' => 76.3388, 'tz' => 'Asia/Kolkata'],
        'kollam' => ['name' => 'Kollam (Quilon), Kerala', 'lat' => 8.8932, 'lng' => 76.6141, 'tz' => 'Asia/Kolkata'],
        'palakkad' => ['name' => 'Palakkad, Kerala', 'lat' => 10.7867, 'lng' => 76.6548, 'tz' => 'Asia/Kolkata'],
        'malappuram' => ['name' => 'Malappuram, Kerala', 'lat' => 11.0510, 'lng' => 76.0711, 'tz' => 'Asia/Kolkata'],
        'kannur' => ['name' => 'Kannur, Kerala', 'lat' => 11.8745, 'lng' => 75.3704, 'tz' => 'Asia/Kolkata'],
        'kasaragod' => ['name' => 'Kasaragod, Kerala', 'lat' => 12.4996, 'lng' => 74.9869, 'tz' => 'Asia/Kolkata'],
        'pathanamthitta' => ['name' => 'Pathanamthitta, Kerala', 'lat' => 9.2648, 'lng' => 76.7870, 'tz' => 'Asia/Kolkata'],
        'idukki' => ['name' => 'Idukki, Kerala', 'lat' => 9.8494, 'lng' => 76.9685, 'tz' => 'Asia/Kolkata'],
        'wayanad' => ['name' => 'Wayanad (Kalpetta), Kerala', 'lat' => 11.6085, 'lng' => 76.0832, 'tz' => 'Asia/Kolkata'],
        'chennai' => ['name' => 'Chennai, Tamil Nadu', 'lat' => 13.0827, 'lng' => 80.2707, 'tz' => 'Asia/Kolkata'],
        'coimbatore' => ['name' => 'Coimbatore, Tamil Nadu', 'lat' => 11.0168, 'lng' => 76.9558, 'tz' => 'Asia/Kolkata'],
        'madurai' => ['name' => 'Madurai, Tamil Nadu', 'lat' => 9.9252, 'lng' => 78.1198, 'tz' => 'Asia/Kolkata'],
        'bengaluru' => ['name' => 'Bengaluru (Bangalore), Karnataka', 'lat' => 12.9716, 'lng' => 77.5946, 'tz' => 'Asia/Kolkata'],
        'bangalore' => ['name' => 'Bengaluru (Bangalore), Karnataka', 'lat' => 12.9716, 'lng' => 77.5946, 'tz' => 'Asia/Kolkata'],
        'mangalore' => ['name' => 'Mangaluru, Karnataka', 'lat' => 12.9141, 'lng' => 74.8560, 'tz' => 'Asia/Kolkata'],
        'mumbai' => ['name' => 'Mumbai, Maharashtra', 'lat' => 19.0760, 'lng' => 72.8777, 'tz' => 'Asia/Kolkata'],
        'delhi' => ['name' => 'New Delhi, India', 'lat' => 28.6139, 'lng' => 77.2090, 'tz' => 'Asia/Kolkata'],
        'hyderabad' => ['name' => 'Hyderabad, Telangana', 'lat' => 17.3850, 'lng' => 78.4867, 'tz' => 'Asia/Kolkata'],
        'kolkata' => ['name' => 'Kolkata, West Bengal', 'lat' => 22.5726, 'lng' => 88.3639, 'tz' => 'Asia/Kolkata'],
        'dubai' => ['name' => 'Dubai, UAE', 'lat' => 25.2048, 'lng' => 55.2708, 'tz' => 'Asia/Dubai'],
        'abudhabi' => ['name' => 'Abu Dhabi, UAE', 'lat' => 24.4539, 'lng' => 54.3773, 'tz' => 'Asia/Dubai'],
        'sharjah' => ['name' => 'Sharjah, UAE', 'lat' => 25.3463, 'lng' => 55.4209, 'tz' => 'Asia/Dubai'],
        'doha' => ['name' => 'Doha, Qatar', 'lat' => 25.2854, 'lng' => 51.5310, 'tz' => 'Asia/Qatar'],
        'muscat' => ['name' => 'Muscat, Oman', 'lat' => 23.5880, 'lng' => 58.3829, 'tz' => 'Asia/Muscat'],
        'riyadh' => ['name' => 'Riyadh, Saudi Arabia', 'lat' => 24.7136, 'lng' => 46.6753, 'tz' => 'Asia/Riyadh'],
        'kuwait' => ['name' => 'Kuwait City, Kuwait', 'lat' => 29.3759, 'lng' => 47.9774, 'tz' => 'Asia/Kuwait'],
        'bahrain' => ['name' => 'Manama, Bahrain', 'lat' => 26.2285, 'lng' => 50.5860, 'tz' => 'Asia/Bahrain'],
        'london' => ['name' => 'London, United Kingdom', 'lat' => 51.5074, 'lng' => -0.1278, 'tz' => 'Europe/London'],
        'newyork' => ['name' => 'New York, USA', 'lat' => 40.7128, 'lng' => -74.0060, 'tz' => 'America/New_York'],
        'singapore' => ['name' => 'Singapore', 'lat' => 1.3521, 'lng' => 103.8198, 'tz' => 'Asia/Singapore'],
    ];

    /**
     * Combustion (Maudhya) orb thresholds in degrees from the Sun (Vedanga Jyothisham Ch. 4, Page 29)
     */
    public const COMBUSTION_ORBS = [
        'Mo' => 12.0,
        'Ma' => 17.0,
        'Me' => 13.0,
        'Ju' => 11.0,
        'Ve' => 9.0,
        'Sa' => 15.0,
    ];

    /**
     * Daytime & Nighttime Gulika Udaya Ghatikas out of 30 (Vedanga Jyothisham Ch. 5, Page 33)
     * Index: 0 = Sunday, 1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday, 5 = Friday, 6 = Saturday
     */
    public const DAY_GULIKA_GHATIKAS = [
        0 => 26, // Sunday
        1 => 22, // Monday
        2 => 18, // Tuesday
        3 => 14, // Wednesday
        4 => 10, // Thursday
        5 => 6,  // Friday
        6 => 2,  // Saturday
    ];

    public const NIGHT_GULIKA_GHATIKAS = [
        0 => 10, // Sunday night
        1 => 6,  // Monday night
        2 => 2,  // Tuesday night
        3 => 26, // Wednesday night
        4 => 22, // Thursday night
        5 => 18, // Friday night
        6 => 14, // Saturday night
    ];

    /**
     * Resolve birth place coordinates from city string or explicit lat/lng
     */
    public function resolveCoordinates(?string $birthPlace, ?float $lat = null, ?float $lng = null, ?string $tz = null): array
    {
        $default = self::CITY_COORDINATES['ernakulam'];

        if ($lat !== null && $lng !== null && ($lat != 0 || $lng != 0)) {
            return [
                'name' => trim($birthPlace ?: $default['name']),
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
                'timezone' => $tz ?: 'Asia/Kolkata',
            ];
        }

        if ($birthPlace) {
            $normalized = strtolower(preg_replace('/[^a-zA-Z]/', '', explode(',', $birthPlace)[0]));
            if (isset(self::CITY_COORDINATES[$normalized])) {
                $found = self::CITY_COORDINATES[$normalized];
                return [
                    'name' => trim($birthPlace),
                    'latitude' => $found['lat'],
                    'longitude' => $found['lng'],
                    'timezone' => $tz ?: $found['tz'],
                ];
            }

            foreach (self::CITY_COORDINATES as $key => $info) {
                if (str_contains(strtolower($birthPlace), $key)) {
                    return [
                        'name' => trim($birthPlace),
                        'latitude' => $info['lat'],
                        'longitude' => $info['lng'],
                        'timezone' => $tz ?: $info['tz'],
                    ];
                }
            }
        }

        return [
            'name' => trim($birthPlace ?: $default['name']),
            'latitude' => $default['lat'],
            'longitude' => $default['lng'],
            'timezone' => $tz ?: $default['tz'],
        ];
    }

    /**
     * Main calculation entry point for Nirayana Planetary Positions, Lagna Sphuta, and Gulika (Maandhi)
     */
    public function calculateEphemeris(
        string $dob,
        ?string $birthTime = '12:00',
        float $latitude = 9.9312,
        float $longitude = 76.2673,
        string $timezone = 'Asia/Kolkata'
    ): array {
        $cleanTime = $this->normalizeTimeString($birthTime ?: '12:00');
        $localDt = Carbon::createFromFormat('Y-m-d H:i:s', "{$dob} {$cleanTime}", $timezone);
        $utcDt = $localDt->copy()->setTimezone('UTC');

        $jd = $this->carbonToJulianDay($utcDt);
        $T = ($jd - 2451545.0) / 36525.0;

        // 1. Chitrapaksha (Lahiri) Ayanamsa
        $ayanamsa = $this->calculateChitrapakshaAyanamsa($jd);

        // 2. Nirayana Planetary Positions & Speeds
        $planetsAtBirth = $this->computeAllPlanetsAtJd($jd, $ayanamsa);
        $planetsBefore = $this->computeAllPlanetsAtJd($jd - 0.25, $ayanamsa);
        $planetsAfter = $this->computeAllPlanetsAtJd($jd + 0.25, $ayanamsa);

        $sunLng = $planetsAtBirth['Su'];
        $planetaryData = [];

        foreach ($planetsAtBirth as $code => $lng) {
            $diff = $this->signedAngleDiff($planetsBefore[$code], $planetsAfter[$code]);
            $dailySpeed = $diff * 2.0; // over 0.5 day interval
            $isRetrograde = in_array($code, ['Ra', 'Ke'], true) ? true : (in_array($code, ['Su', 'Mo'], true) ? false : ($dailySpeed < 0));

            $isCombust = false;
            if (isset(self::COMBUSTION_ORBS[$code])) {
                $angDistFromSun = abs($this->signedAngleDiff($sunLng, $lng));
                $isCombust = $angDistFromSun < self::COMBUSTION_ORBS[$code];
            }

            $planetaryData[$code] = $this->formatLongitudeEntry($code, $lng, $dailySpeed, $isRetrograde, $isCombust);
        }

        // 3. Nirayana Lagna Sphuta (Ascendant)
        $lagnaLng = $this->calculateNirayanaLagna($jd, $latitude, $longitude, $ayanamsa);
        $lagnaEntry = $this->formatLongitudeEntry('As', $lagnaLng, 360.0, false, false);

        // 4. Local Sunrise, Sunset & Gulika (Maandhi - Md) per Vedanga Jyothisham Page 33
        $gulikaInfo = $this->calculateGulikaAndSunTimes($localDt, $latitude, $longitude, $timezone);
        $gulikaEntry = $this->formatLongitudeEntry('Md', $gulikaInfo['gulika_longitude'], 0.0, false, false);

        return [
            'local_datetime' => $localDt->format('Y-m-d H:i:s'),
            'utc_datetime' => $utcDt->format('Y-m-d H:i:s'),
            'julian_day' => round($jd, 6),
            'julian_centuries' => round($T, 8),
            'ayanamsa_deg' => round($ayanamsa, 6),
            'ayanamsa_dms' => $this->decimalToDms($ayanamsa),
            'ayanamsa_type' => 'Chitrapaksha (Lahiri)',
            'lagna' => $lagnaEntry,
            'gulika' => array_merge($gulikaEntry, [
                'sunrise' => $gulikaInfo['sunrise'],
                'sunset' => $gulikaInfo['sunset'],
                'is_day_birth' => $gulikaInfo['is_day_birth'],
                'vedic_weekday_index' => $gulikaInfo['vedic_weekday_index'],
                'vedic_weekday_name' => $gulikaInfo['vedic_weekday_name'],
                'udaya_ghatika' => $gulikaInfo['udaya_ghatika'],
                'gulika_time' => $gulikaInfo['gulika_time'],
            ]),
            'planets' => $planetaryData,
        ];
    }

    /**
     * Normalize 12h/24h time string to HH:MM:SS
     */
    public function normalizeTimeString(?string $timeStr): string
    {
        $timeStr = trim($timeStr ?: '12:00');
        try {
            return Carbon::parse($timeStr)->format('H:i:s');
        } catch (\Throwable $e) {
            return '12:00:00';
        }
    }

    /**
     * Convert UTC Carbon instance to exact Julian Day
     */
    public function carbonToJulianDay(Carbon $utc): float
    {
        $Y = (int) $utc->year;
        $M = (int) $utc->month;
        $D = (int) $utc->day + ($utc->hour + ($utc->minute / 60.0) + ($utc->second / 3600.0)) / 24.0;

        if ($M <= 2) {
            $Y -= 1;
            $M += 12;
        }

        $A = floor($Y / 100);
        $B = 2 - $A + floor($A / 4);

        return floor(365.25 * ($Y + 4716)) + floor(30.6001 * ($M + 1)) + $D + $B - 1524.5;
    }

    /**
     * Exact Chitrapaksha (Lahiri) Ayanamsa in degrees for Julian Day
     */
    public function calculateChitrapakshaAyanamsa(float $jd): float
    {
        $T = ($jd - 2451545.0) / 36525.0;
        $omega = deg2rad($this->mod360(125.04452 - 1934.136261 * $T));
        $L0 = deg2rad($this->mod360(280.4665 + 36000.7698 * $T));

        // Nutation in longitude (degrees)
        $nutationDeg = (-17.20 * sin($omega) - 1.32 * sin(2 * $L0)) / 3600.0;

        // Lahiri base at J2000.0 = 23° 51' 25.53" (23.857092°) + precession
        $meanAyanamsa = 23.857092 + (50.2879695 * $T * 100.0) / 3600.0 + 0.000308 * $T * $T;

        return $this->mod360($meanAyanamsa + $nutationDeg);
    }

    /**
     * Compute Nirayana Lagna Sphuta (Sidereal Ascendant) in degrees (0..360)
     */
    public function calculateNirayanaLagna(float $jd, float $latitude, float $longitude, float $ayanamsa): float
    {
        $T = ($jd - 2451545.0) / 36525.0;

        // Greenwich Mean Sidereal Time in degrees
        $gmst = 280.46061837 + 360.98564736629 * ($jd - 2451545.0) + 0.000387933 * $T * $T - ($T * $T * $T) / 38710000.0;
        $lstDeg = $this->mod360($gmst + $longitude);
        $lstRad = deg2rad($lstDeg);

        // Mean obliquity of ecliptic
        $epsDeg = 23.4392911 - 0.0130042 * $T;
        $epsRad = deg2rad($epsDeg);
        $latRad = deg2rad($latitude);

        // Eastern horizon ecliptic intersection (Tropical Ascendant)
        $y = cos($lstRad);
        $x = -sin($lstRad) * cos($epsRad) - tan($latRad) * sin($epsRad);
        $tropAsc = $this->mod360(rad2deg(atan2($y, $x)));

        return $this->mod360($tropAsc - $ayanamsa);
    }

    /**
     * Calculate Local Sunrise, Sunset & Gulika (Maandhi) per Vedanga Jyothisham Chapter 5, Page 33
     */
    public function calculateGulikaAndSunTimes(Carbon $localDt, float $latitude, float $longitude, string $timezone): array
    {
        $weekdayNames = [
            0 => 'Sunday (ഞായർ)',
            1 => 'Monday (തിങ്കൾ)',
            2 => 'Tuesday (ചൊവ്വ)',
            3 => 'Wednesday (ബുധൻ)',
            4 => 'Thursday (വ്യാഴം)',
            5 => 'Friday (ശുക്രൻ)',
            6 => 'Saturday (ശനി)',
        ];

        $dateStr = $localDt->format('Y-m-d');
        [$sunriseToday, $sunsetToday] = $this->computeSunriseSunsetForDate($dateStr, $latitude, $longitude, $timezone);

        if ($localDt->lt($sunriseToday)) {
            // Birth before sunrise belongs to the previous Vedic day's nighttime
            $prevDateStr = $localDt->copy()->subDay()->format('Y-m-d');
            [$sunrisePrev, $sunsetPrev] = $this->computeSunriseSunsetForDate($prevDateStr, $latitude, $longitude, $timezone);

            $isDayBirth = false;
            $vedicWeekday = $sunrisePrev->dayOfWeek; // 0 (Sun) .. 6 (Sat)
            $ghatika = self::NIGHT_GULIKA_GHATIKAS[$vedicWeekday];
            $nightSeconds = max(3600, $sunsetPrev->diffInSeconds($sunriseToday));
            $gulikaTime = $sunsetPrev->copy()->addSeconds((int) round($nightSeconds * ($ghatika / 30.0)));
            $refSunrise = $sunrisePrev;
            $refSunset = $sunsetPrev;
        } elseif ($localDt->lte($sunsetToday)) {
            // Daytime birth (Sunrise to Sunset)
            $isDayBirth = true;
            $vedicWeekday = $localDt->dayOfWeek;
            $ghatika = self::DAY_GULIKA_GHATIKAS[$vedicWeekday];
            $daySeconds = max(3600, $sunriseToday->diffInSeconds($sunsetToday));
            $gulikaTime = $sunriseToday->copy()->addSeconds((int) round($daySeconds * ($ghatika / 30.0)));
            $refSunrise = $sunriseToday;
            $refSunset = $sunsetToday;
        } else {
            // Nighttime birth (After Sunset)
            $nextDateStr = $localDt->copy()->addDay()->format('Y-m-d');
            [$sunriseNext, $sunsetNext] = $this->computeSunriseSunsetForDate($nextDateStr, $latitude, $longitude, $timezone);

            $isDayBirth = false;
            $vedicWeekday = $localDt->dayOfWeek;
            $ghatika = self::NIGHT_GULIKA_GHATIKAS[$vedicWeekday];
            $nightSeconds = max(3600, $sunsetToday->diffInSeconds($sunriseNext));
            $gulikaTime = $sunsetToday->copy()->addSeconds((int) round($nightSeconds * ($ghatika / 30.0)));
            $refSunrise = $sunriseToday;
            $refSunset = $sunsetToday;
        }

        $gulikaUtc = $gulikaTime->copy()->setTimezone('UTC');
        $gulikaJd = $this->carbonToJulianDay($gulikaUtc);
        $gulikaAyanamsa = $this->calculateChitrapakshaAyanamsa($gulikaJd);
        $gulikaLng = $this->calculateNirayanaLagna($gulikaJd, $latitude, $longitude, $gulikaAyanamsa);

        return [
            'sunrise' => $refSunrise->format('h:i A'),
            'sunset' => $refSunset->format('h:i A'),
            'is_day_birth' => $isDayBirth,
            'vedic_weekday_index' => $vedicWeekday,
            'vedic_weekday_name' => $weekdayNames[$vedicWeekday] ?? 'Sunday',
            'udaya_ghatika' => $ghatika,
            'gulika_time' => $gulikaTime->format('h:i A'),
            'gulika_longitude' => $gulikaLng,
        ];
    }

    /**
     * Compute local Sunrise and Sunset Carbon instances for a YYYY-MM-DD date
     */
    protected function computeSunriseSunsetForDate(string $dateStr, float $latitude, float $longitude, string $timezone): array
    {
        $noonLocal = Carbon::createFromFormat('Y-m-d H:i:s', "{$dateStr} 12:00:00", $timezone);
        $tzOffsetHours = $noonLocal->offsetHours;

        $dayOfYear = $noonLocal->dayOfYear;
        $gamma = (2.0 * M_PI / 365.0) * ($dayOfYear - 1);

        // Equation of time (minutes)
        $eqTime = 229.18 * (0.000075 + 0.001868 * cos($gamma) - 0.032077 * sin($gamma)
            - 0.014615 * cos(2 * $gamma) - 0.040849 * sin(2 * $gamma));

        // Solar declination (radians)
        $decl = 0.006918 - 0.399912 * cos($gamma) + 0.070257 * sin($gamma)
            - 0.006758 * cos(2 * $gamma) + 0.000907 * sin(2 * $gamma)
            - 0.002697 * cos(3 * $gamma) + 0.00148 * sin(3 * $gamma);

        $latRad = deg2rad($latitude);
        $zenithRad = deg2rad(90.8333);
        $cosH = (cos($zenithRad) / (cos($latRad) * cos($decl))) - tan($latRad) * tan($decl);
        $cosH = max(-0.999, min(0.999, $cosH));
        $haDeg = rad2deg(acos($cosH));

        $sunriseMinutesUtc = 720.0 - 4.0 * ($longitude + $haDeg) - $eqTime;
        $sunsetMinutesUtc = 720.0 - 4.0 * ($longitude - $haDeg) - $eqTime;

        $sunriseMinutesLocal = (int) round($sunriseMinutesUtc + $tzOffsetHours * 60.0);
        $sunsetMinutesLocal = (int) round($sunsetMinutesUtc + $tzOffsetHours * 60.0);

        $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "{$dateStr} 00:00:00", $timezone);
        $sunrise = $startOfDay->copy()->addMinutes(max(240, min(540, $sunriseMinutesLocal)));
        $sunset = $startOfDay->copy()->addMinutes(max(960, min(1260, $sunsetMinutesLocal)));

        return [$sunrise, $sunset];
    }

    /**
     * Compute Nirayana Longitudes (0..360) for all 9 Navagrahas at Julian Day
     */
    public function computeAllPlanetsAtJd(float $jd, float $ayanamsa): array
    {
        $T = ($jd - 2451545.0) / 36525.0;

        // 1. Sun (Su)
        $tropSun = $this->calculateTropicalSun($T);

        // 2. Moon (Mo)
        $tropMoon = $this->calculateTropicalMoon($T);

        // 3. Heliocentric Earth for Geocentric transformation
        $earthHelio = $this->calculateHeliocentricPlanet('Earth', $T);

        // 4. 5 Starry Planets (Me, Ve, Ma, Ju, Sa)
        $tropMe = $this->calculateGeocentricPlanet('Me', $T, $earthHelio);
        $tropVe = $this->calculateGeocentricPlanet('Ve', $T, $earthHelio);
        $tropMa = $this->calculateGeocentricPlanet('Ma', $T, $earthHelio);
        $tropJu = $this->calculateGeocentricPlanet('Ju', $T, $earthHelio);
        $tropSa = $this->calculateGeocentricPlanet('Sa', $T, $earthHelio);

        // 5. Rahu (Mean Ascending Lunar Node) & Ketu
        $tropRahu = $this->mod360(125.0445550 - 1934.1361849 * $T + 0.0020762 * $T * $T + ($T * $T * $T) / 467410.0);

        $nirayanaRahu = $this->mod360($tropRahu - $ayanamsa);
        $nirayanaKetu = $this->mod360($nirayanaRahu + 180.0);

        return [
            'Su' => $this->mod360($tropSun - $ayanamsa),
            'Mo' => $this->mod360($tropMoon - $ayanamsa),
            'Ma' => $this->mod360($tropMa - $ayanamsa),
            'Me' => $this->mod360($tropMe - $ayanamsa),
            'Ju' => $this->mod360($tropJu - $ayanamsa),
            'Ve' => $this->mod360($tropVe - $ayanamsa),
            'Sa' => $this->mod360($tropSa - $ayanamsa),
            'Ra' => $nirayanaRahu,
            'Ke' => $nirayanaKetu,
        ];
    }

    /**
     * High-precision Apparent Tropical Sun Longitude (Meeus Ch. 25)
     */
    protected function calculateTropicalSun(float $T): float
    {
        $L0 = $this->mod360(280.46646 + 36000.76983 * $T + 0.0003032 * $T * $T);
        $M = $this->mod360(357.52911 + 35999.05029 * $T - 0.0001537 * $T * $T);
        $Mrad = deg2rad($M);

        $C = (1.914602 - 0.004817 * $T - 0.000014 * $T * $T) * sin($Mrad)
           + (0.019993 - 0.000101 * $T) * sin(2 * $Mrad)
           + 0.000289 * sin(3 * $Mrad);

        $trueLong = $L0 + $C;
        $omega = deg2rad(125.04 - 1934.136 * $T);
        $apparent = $trueLong - 0.00569 - 0.00478 * sin($omega);

        return $this->mod360($apparent);
    }

    /**
     * High-precision Apparent Tropical Moon Longitude (Meeus Ch. 47 / ELP2000 periodic series)
     */
    protected function calculateTropicalMoon(float $T): float
    {
        // Mean longitude L'
        $Lp = $this->mod360(218.3164477 + 481267.88123421 * $T - 0.0015786 * $T * $T + ($T * $T * $T) / 538841.0);
        // Mean elongation D
        $D = $this->mod360(297.8501921 + 445267.1114034 * $T - 0.0018819 * $T * $T + ($T * $T * $T) / 545868.0);
        // Sun mean anomaly M
        $M = $this->mod360(357.5291092 + 35999.0502909 * $T - 0.0001536 * $T * $T);
        // Moon mean anomaly M'
        $Mp = $this->mod360(134.9633964 + 477198.8675055 * $T + 0.0087414 * $T * $T + ($T * $T * $T) / 69699.0);
        // Moon argument of latitude F
        $F = $this->mod360(93.2720950 + 483202.0175233 * $T - 0.0036539 * $T * $T);

        $E = 1.0 - 0.002516 * $T - 0.0000074 * $T * $T;
        $E2 = $E * $E;

        $Dr = deg2rad($D);
        $Mr = deg2rad($M);
        $Mpr = deg2rad($Mp);
        $Fr = deg2rad($F);

        // Principal periodic terms in longitude (units of 0.000001 degree)
        $sumL = 0.0;
        $sumL += 6288774 * sin($Mpr);
        $sumL += 1274027 * sin(2 * $Dr - $Mpr);
        $sumL += 658314 * sin(2 * $Dr);
        $sumL += 213618 * sin(2 * $Mpr);
        $sumL += -185116 * $E * sin($Mr);
        $sumL += -114332 * sin(2 * $Fr);
        $sumL += 58793 * sin(2 * $Dr - 2 * $Mpr);
        $sumL += 57066 * $E * sin(2 * $Dr - $Mr - $Mpr);
        $sumL += 53322 * sin(2 * $Dr + $Mpr);
        $sumL += 45758 * $E * sin(2 * $Dr - $Mr);
        $sumL += -40923 * $E * sin($Mr - $Mpr);
        $sumL += -34720 * sin($Dr);
        $sumL += -30383 * $E * sin($Mr + $Mpr);
        $sumL += 15327 * sin(2 * $Dr - 2 * $Fr);
        $sumL += -12528 * sin($Mpr + 2 * $Fr);
        $sumL += 10980 * sin($Mpr - 2 * $Fr);
        $sumL += 10675 * sin(4 * $Dr - $Mpr);
        $sumL += 10034 * sin(3 * $Mpr);
        $sumL += 8548 * sin(4 * $Dr - 2 * $Mpr);
        $sumL += -7888 * $E * sin(2 * $Dr + $Mr - $Mpr);
        $sumL += -6766 * $E * sin(2 * $Dr + $Mr);
        $sumL += -5163 * sin($Dr - $Mpr);
        $sumL += 4987 * $E * sin($Dr + $Mr);
        $sumL += 4036 * $E * sin(2 * $Dr - $Mr + $Mpr);
        $sumL += 3994 * sin(2 * $Dr + 2 * $Mpr);
        $sumL += 3861 * sin(4 * $Dr);
        $sumL += 3665 * sin(2 * $Dr - 3 * $Mpr);
        $sumL += -2689 * $E * sin($Mr - 2 * $Mpr);
        $sumL += -2602 * sin(2 * $Dr - $Mpr + 2 * $Fr);
        $sumL += 2390 * $E * sin(2 * $Dr - $Mr - 2 * $Mpr);
        $sumL += -2348 * sin($Dr + $Mpr);
        $sumL += 2236 * $E2 * sin(2 * $Dr - 2 * $Mr);
        $sumL += -2120 * $E * sin($Mr + 2 * $Mpr);
        $sumL += -2069 * $E2 * sin(2 * $Mr);
        $sumL += 2048 * $E2 * sin(2 * $Dr - 2 * $Mr - $Mpr);
        $sumL += -1773 * sin(2 * $Dr + $Mpr - 2 * $Fr);
        $sumL += -1595 * sin(2 * $Dr + 2 * $Fr);
        $sumL += 1215 * $E * sin(4 * $Dr - $Mr - $Mpr);
        $sumL += -1110 * sin(2 * $Mpr + 2 * $Fr);

        // Additive Venus & Jupiter terms
        $A1 = deg2rad($this->mod360(119.75 + 131.849 * $T));
        $A2 = deg2rad($this->mod360(53.09 + 479264.290 * $T));
        $sumL += 3958 * sin($A1) + 1962 * sin($Mpr - $Fr) + 318 * sin($A2);

        $moonLong = $Lp + ($sumL / 1000000.0);
        return $this->mod360($moonLong);
    }

    /**
     * Orbital elements (J2000.0 + century rates) for heliocentric coordinates (Standish / Meeus Ch. 31)
     */
    protected function getOrbitalElements(string $body, float $T): array
    {
        return match ($body) {
            'Earth' => [
                'L' => 100.466457 + 35999.3728565 * $T,
                'a' => 1.000001018,
                'e' => 0.01670863 - 0.000042037 * $T,
                'i' => 0.0,
                'omega' => 0.0,
                'pi' => 102.937348 + 0.3225654 * $T,
            ],
            'Me' => [
                'L' => 252.250906 + 149472.6746358 * $T - 1.98,
                'a' => 0.38709893,
                'e' => 0.20563069 + 0.00002527 * $T,
                'i' => 7.00487 - 0.00595 * $T,
                'omega' => 48.33167 - 0.12542 * $T,
                'pi' => 77.45645 + 0.15886 * $T,
            ],
            'Ve' => [
                'L' => 181.979801 + 58517.8156760 * $T,
                'a' => 0.72333199,
                'e' => 0.00677323 - 0.00004938 * $T,
                'i' => 3.39471 - 0.00078 * $T,
                'omega' => 76.68069 - 0.27800 * $T,
                'pi' => 131.53298 - 0.00268 * $T,
            ],
            'Ma' => [
                'L' => 355.433000 + 19140.2993039 * $T,
                'a' => 1.52366231,
                'e' => 0.09341233 + 0.00011902 * $T,
                'i' => 1.85061 - 0.00707 * $T,
                'omega' => 49.57854 - 0.29498 * $T,
                'pi' => 336.04084 + 0.44388 * $T,
            ],
            'Ju' => [
                'L' => 34.351519 + 3034.9056606 * $T,
                'a' => 5.20336301,
                'e' => 0.04839266 - 0.00012880 * $T,
                'i' => 1.30530 - 0.00115 * $T,
                'omega' => 100.55615 + 0.17668 * $T,
                'pi' => 14.75385 + 0.21252 * $T,
            ],
            'Sa' => [
                'L' => 50.077444 + 1222.1138488 * $T - 0.485,
                'a' => 9.53707032,
                'e' => 0.05415060 - 0.00036762 * $T,
                'i' => 2.48446 + 0.00171 * $T,
                'omega' => 113.71504 - 0.25667 * $T,
                'pi' => 92.43194 - 0.41897 * $T,
            ],
        };
    }

    /**
     * Compute heliocentric ecliptic rectangular coordinates (x, y, z)
     */
    protected function calculateHeliocentricPlanet(string $body, float $T): array
    {
        $el = $this->getOrbitalElements($body, $T);
        $L = $this->mod360($el['L']);
        $pi = $this->mod360($el['pi']);
        $omega = $this->mod360($el['omega']);
        $a = $el['a'];
        $e = $el['e'];
        $iRad = deg2rad($el['i']);

        $Mdeg = $this->mod360($L - $pi);

        // Great Jupiter-Saturn inequality perturbations in Mean Anomaly / Longitude
        $pertLng = 0.0;
        if ($body === 'Ju' || $body === 'Sa') {
            $Mj = deg2rad($this->mod360(20.020 + 3034.906 * $T));
            $Ms = deg2rad($this->mod360(317.020 + 1222.114 * $T));
            if ($body === 'Ju') {
                $pertLng = -0.332 * sin(2 * $Mj - 5 * $Ms - deg2rad(67.6))
                         - 0.056 * sin(2 * $Mj - 2 * $Ms + deg2rad(21.0))
                         + 0.042 * sin(3 * $Mj - 5 * $Ms + deg2rad(21.0));
            } else {
                $pertLng = 0.812 * sin(2 * $Mj - 5 * $Ms - deg2rad(67.6))
                         - 0.229 * cos(2 * $Mj - 4 * $Ms - deg2rad(2.0))
                         + 0.119 * sin($Mj - 2 * $Ms - deg2rad(3.0));
            }
        }

        $Mrad = deg2rad($this->mod360($Mdeg + $pertLng));

        // Solve Kepler's equation E - e*sin(E) = M
        $E = $Mrad;
        for ($iter = 0; $iter < 7; $iter++) {
            $dE = ($E - $e * sin($E) - $Mrad) / (1.0 - $e * cos($E));
            $E -= $dE;
            if (abs($dE) < 1e-10) {
                break;
            }
        }

        $xv = $a * (cos($E) - $e);
        $yv = $a * sqrt(1.0 - $e * $e) * sin($E);

        $v = atan2($yv, $xv);
        $r = hypot($xv, $yv);

        $wRad = deg2rad($pi - $omega);
        $omegaRad = deg2rad($omega);
        $u = $v + $wRad;

        $x = $r * (cos($omegaRad) * cos($u) - sin($omegaRad) * sin($u) * cos($iRad));
        $y = $r * (sin($omegaRad) * cos($u) + cos($omegaRad) * sin($u) * cos($iRad));
        $z = $r * (sin($u) * sin($iRad));

        return ['x' => $x, 'y' => $y, 'z' => $z, 'r' => $r];
    }

    /**
     * Compute Geocentric Tropical Ecliptic Longitude (degrees 0..360)
     */
    protected function calculateGeocentricPlanet(string $body, float $T, array $earthHelio): float
    {
        $helio = $this->calculateHeliocentricPlanet($body, $T);
        $dx = $helio['x'] - $earthHelio['x'];
        $dy = $helio['y'] - $earthHelio['y'];
        $dz = $helio['z'] - $earthHelio['z'];

        // Light-time iteration
        $dist = sqrt($dx * $dx + $dy * $dy + $dz * $dz);
        $tauCenturies = (0.0057755183 * $dist) / 36525.0;
        $helioRetarded = $this->calculateHeliocentricPlanet($body, $T - $tauCenturies);

        $dx = $helioRetarded['x'] - $earthHelio['x'];
        $dy = $helioRetarded['y'] - $earthHelio['y'];

        return $this->mod360(rad2deg(atan2($dy, $dx)));
    }

    /**
     * Format a planet/point longitude entry with Rasi index, degree in sign, DMS, Nakshatra & Pada
     */
    protected function formatLongitudeEntry(
        string $code,
        float $longitude,
        float $dailySpeed,
        bool $isRetrograde,
        bool $isCombust
    ): array {
        $lng = $this->mod360($longitude);
        $rasiIndex = (int) floor($lng / 30.0) + 1; // 1..12
        $degInRasi = fmod($lng, 30.0);

        $nakSpan = 360.0 / 27.0; // 13.3333333333°
        $nakIndex = (int) floor($lng / $nakSpan) + 1; // 1..27
        $degInNak = fmod($lng, $nakSpan);
        $pada = (int) floor($degInNak / ($nakSpan / 4.0)) + 1; // 1..4
        $pada = max(1, min(4, $pada));

        return [
            'code' => $code,
            'longitude' => round($lng, 6),
            'rasi_index' => $rasiIndex,
            'degree_in_rasi' => round($degInRasi, 4),
            'dms_in_rasi' => $this->decimalToDms($degInRasi),
            'full_dms' => $this->decimalToDms($lng),
            'nakshatra_index' => $nakIndex,
            'pada' => $pada,
            'daily_speed' => round($dailySpeed, 4),
            'is_retrograde' => $isRetrograde,
            'is_combust' => $isCombust,
        ];
    }

    /**
     * Convert decimal degrees to DD° MM' SS"
     */
    public function decimalToDms(float $deg): string
    {
        $deg = abs($deg);
        $d = (int) floor($deg);
        $mFloat = ($deg - $d) * 60.0;
        $m = (int) floor($mFloat);
        $s = (int) round(($mFloat - $m) * 60.0);
        if ($s >= 60) {
            $s -= 60;
            $m += 1;
        }
        if ($m >= 60) {
            $m -= 60;
            $d += 1;
        }
        return sprintf('%02d° %02d\' %02d"', $d, $m, $s);
    }

    /**
     * Modulo 360 in [0, 360)
     */
    public function mod360(float $angle): float
    {
        $res = fmod($angle, 360.0);
        return $res < 0 ? $res + 360.0 : $res;
    }

    /**
     * Signed shortest angular difference from angle1 to angle2 in (-180, 180]
     */
    public function signedAngleDiff(float $angle1, float $angle2): float
    {
        $diff = fmod($angle2 - $angle1 + 540.0, 360.0) - 180.0;
        return $diff;
    }
}


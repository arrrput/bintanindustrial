<?php

namespace App\Support;

/**
 * Upload limits of the PHP server this app runs on (php.ini), so forms and validation
 * follow the server instead of hard-coded numbers:
 * - upload_max_filesize : largest single file
 * - post_max_size       : largest whole request (all files + fields together)
 * - max_file_uploads    : most files in one request
 */
class UploadLimits
{
    /** Largest single file in bytes (0 = unlimited). */
    public static function perFileBytes(): int
    {
        return self::toBytes(ini_get('upload_max_filesize'));
    }

    /** Largest request in bytes (0 = unlimited). */
    public static function totalBytes(): int
    {
        return self::toBytes(ini_get('post_max_size'));
    }

    /** Most files in one request. */
    public static function maxFiles(): int
    {
        return max(1, (int) ini_get('max_file_uploads') ?: 20);
    }

    /** Per-file limit for Laravel's "max" rule (kilobytes). The request limit also caps a single file. */
    public static function perFileKilobytes(): int
    {
        $limits = array_filter([self::perFileBytes(), self::totalBytes()]);
        $bytes = $limits ? min($limits) : 2 * 1024 * 1024 * 1024;

        return (int) floor($bytes / 1024);
    }

    /** e.g. "8 MB", "2 GB". */
    public static function human(int $bytes): string
    {
        if ($bytes <= 0) {
            return 'unlimited';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);
        $value = $bytes / (1024 ** $power);

        return rtrim(rtrim(number_format($value, 1), '0'), '.') . ' ' . $units[$power];
    }

    /** Converts php.ini shorthand ("8M", "2G", "512K", "1024") to bytes. */
    public static function toBytes(string|false|null $value): int
    {
        $value = trim((string) $value);
        if ($value === '' || $value === '-1') {
            return 0;
        }

        $number = (float) $value;

        return (int) match (strtolower(substr($value, -1))) {
            'g' => $number * 1024 ** 3,
            'm' => $number * 1024 ** 2,
            'k' => $number * 1024,
            default => $number,
        };
    }
}

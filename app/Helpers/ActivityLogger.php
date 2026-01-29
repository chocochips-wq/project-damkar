<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    /**
     * Log file creation
     */
    public static function logFileCreate($filename, $module)
    {
        return ActivityLog::log('create', $module, "File '$filename' berhasil dibuat");
    }

    /**
     * Log file update
     */
    public static function logFileUpdate($filename, $module)
    {
        return ActivityLog::log('update', $module, "File '$filename' berhasil diperbarui");
    }

    /**
     * Log file delete
     */
    public static function logFileDelete($filename, $module)
    {
        return ActivityLog::log('delete', $module, "File '$filename' berhasil dihapus");
    }

    /**
     * Log file upload
     */
    public static function logFileUpload($filename, $module)
    {
        return ActivityLog::log('upload', $module, "File '$filename' berhasil diupload");
    }

    /**
     * Log file download
     */
    public static function logFileDownload($filename, $module)
    {
        return ActivityLog::log('download', $module, "File '$filename' diunduh");
    }

    /**
     * Log folder creation
     */
    public static function logFolderCreate($foldername, $module)
    {
        return ActivityLog::log('create', $module, "Folder '$foldername' berhasil dibuat");
    }

    /**
     * Log folder delete
     */
    public static function logFolderDelete($foldername, $module)
    {
        return ActivityLog::log('delete', $module, "Folder '$foldername' berhasil dihapus");
    }

    /**
     * Generic log
     */
    public static function log($action, $module, $description)
    {
        return ActivityLog::log($action, $module, $description);
    }
}

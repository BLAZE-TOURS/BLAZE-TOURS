<?php

class BlazeLogger
{
	private static $logFile = __DIR__ . '/booking_flow.log';

	public static function info(string $message, array $context = []): void
	{
		self::write('INFO', $message, $context);
	}

	public static function error(string $message, array $context = []): void
	{
		self::write('ERROR', $message, $context);
	}

	private static function write(string $level, string $message, array $context = []): void
	{
		try {
			$line = date('Y-m-d H:i:s') . " [$level] " . $message;
			if (!empty($context)) {
				$line .= ' | ' . json_encode(self::sanitize($context), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
			$line .= PHP_EOL;
			@file_put_contents(self::$logFile, $line, FILE_APPEND);
		} catch (\Throwable $e) {
			// As a fallback, attempt PHP error_log
			@error_log("[$level] $message :: " . $e->getMessage());
		}
	}

	private static function sanitize(array $data): array
	{
		// Avoid logging secrets; trim long values
		$hiddenKeys = ['password', 'merchant_secret', 'md5sig', 'hash'];
		$sanitized = [];
		foreach ($data as $k => $v) {
			if (in_array($k, $hiddenKeys, true)) {
				$sanitized[$k] = '***';
				continue;
			}
			if (is_string($v) && strlen($v) > 500) {
				$sanitized[$k] = substr($v, 0, 500) . '…';
			} else {
				$sanitized[$k] = $v;
			}
		}
		return $sanitized;
	}
}

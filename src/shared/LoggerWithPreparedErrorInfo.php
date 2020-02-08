<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\shared;


use Carbon\Carbon;
use Throwable;

class LoggerWithPreparedErrorInfo implements Logger
{
    public const ENV_LOGS_DIRECTORY = 'ENV_LOGS_DIRECTORY';

    protected string $logDirectory;

    public function __construct(string $logDirectory = '')
    {
        $this->logDirectory = $logDirectory ?? getenv(self::ENV_LOGS_DIRECTORY);
    }

    public function logThrowable(Throwable $throwable): void
    {
        $this->saveErrorInfo(
            'ERROR -> ' . $throwable->getMessage() . ' in -> ' . $throwable->getFile() . ' at line -> '
            . $throwable->getLine() . ' stack trace -> ' . $throwable->getTraceAsString()
        );
    }

    protected function saveErrorInfo(string $errorInfo): void
    {
        $writableLogFile = $this->getWritableLogFile();
        fwrite($writableLogFile, $errorInfo);
        fclose($writableLogFile);
    }

    /**
     * @return resource
     */
    protected function getWritableLogFile()
    {
        return fopen($this->generateActualLogFileName(), 'ab+');
    }

    protected function generateActualLogFileName(): string
    {
        return $this->logDirectory . DIRECTORY_SEPARATOR . Carbon::now()->toDateString() . '-log.txt';
    }

}
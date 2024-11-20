<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     */
    public string $defaultGroup = 'users';

    /**
     * The default database connection.
     *
     * @var array<string, mixed>
     */
    public array $users = [
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => 'dfa1123455',
        'database'     => 'ci4users',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8',
        'DBCollat'     => 'utf8_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $maklon = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => 'root',
        'password'    => 'dfa1123455',
        'database'    => 'ci4maklon',
        'DBDriver'    => 'MySQLi',
        'DBPrefix'    => '',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];


    public array $ci4hr = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => 'root',
        'password'    => 'dfa1123455',
        'database'    => 'ci4hr',
        'DBDriver'    => 'MySQLi',
        'DBPrefix'    => '',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public array $db_log_book = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => 'root',
        'password'    => 'dfa1123455',
        'database'    => 'db_log_book',
        'DBDriver'    => 'MySQLi',
        'DBPrefix'    => '',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public $hr = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => 'dfa1123455',
        'database' => 'hr', // Database untuk surat cuti
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'returnType' => 'array',
        'pgSQLSchema' => 'public',
        'cacheOn'  => false,
        'cacheDir' => '',
        'cacheTTL' => 60,
        'useAutoConnect' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'saveQueries' => true,
    ];


    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'users';
        }
    }
}

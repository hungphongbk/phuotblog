<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/12/16
 * Time: 6:07 PM
 */

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;

class Database
{
    private static $instance;

    private $tableName = "plugin_wpps";

    /**
     * @return string
     */
    public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . $this->tableName;
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();

            /** @var DB $db */
            $db = new DB();
            $db->addConnection([
                'driver' => 'mysql',
                'host' => DB_HOST,
                'database' => DB_NAME,
                'username' => DB_USER,
                'password' => DB_PASSWORD,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]);
            $db->setEventDispatcher(new Dispatcher(new Container()));
            $db->setAsGlobal();
            $db->bootEloquent();
        }
        return self::$instance;
    }

    function dropTable()
    {
        $schema = $this->getSchema();
        $schema->dropIfExists($this->getTableName());
        echo "DELETED TABLE";
    }

    /**
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchema()
    {
        return DB::schema();
    }


    public function initTable()
    {
        $schema = $this->getSchema();
        if (!$schema->hasTable($this->getTableName())) {
            $schema->create($this->getTableName(), function (Blueprint $table) {
                $table->bigInteger('post_id');
                $table->timestamps();
            });
        }
    }
}
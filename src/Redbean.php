<?php
namespace plinker\Redbean;

use RedBeanPHP\R;

class RedBean {

    public function __construct(array $config = array(
            'dsn' => 'sqlite:./database.db', // mysql:host=127.0.0.1;dbname=mydatabase
            'username' => '',
            'password' => '',
            'database' => '',
            'freeze' => false,
            'debug' => false,
    )) {
        $this->config = $config['RedBean'];

        if (empty($this->config['dsn'])) {
            exit('no datasource');
        }

        require_once('vendor/wightphone/Components/src/RedBean/rb-p533.php');

        R::setup(
            $this->config['dsn'],
            $this->config['username'],
            $this->config['password']
        );

        R::freeze(($this->config['freeze'] === true));
        R::debug(($this->config['debug'] === true));
    }

    public function inspect($params = array()) {
        if (!empty($params[0])) {
            return R::inspect($params[0]);
        } else {
            return R::inspect();
        }
    }

    public function create($params = array())
    {
        $result = R::dispense($params[0]);
        $result->import($params[1]);
        R::store($result);

        return R::exportAll($result);
    }

    public function findAll($params = array())
    {
        $result = R::findAll($params[0], $params[1], $params[2]);
        return R::exportAll($result);
    }

    public function mostRecentRow($params = array())
    {
        $result = R::findOne($params[0], ' ORDER BY id DESC LIMIT 1 ');
        return R::exportAll($result);
    }

    public function save($params = array())
    {
        $result = R::load($params[0], $params[1]);
        $result->import($params[2]);
        R::store($result);
        return R::exportAll($result);
    }

    public function delete($params = array())
    {
        $result = R::load($params[0], $params[1]);
        return R::trash($result);
    }

    public function helloWorld($params = array()) {
        return 'Hello World!';
    }
}
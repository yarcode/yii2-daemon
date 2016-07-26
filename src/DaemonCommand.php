<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
namespace YarCode\Yii2\Daemon;

use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use yii\console\Controller;

abstract class DaemonCommand extends Controller
{
    /** @var LoopInterface */
    protected $loop;

    public function init()
    {
        parent::init();
        $this->loop = Factory::create();
    }

    public function actionDaemon()
    {
        $this->prepare();
        $this->loop->run();
    }

    abstract public function prepare();
}
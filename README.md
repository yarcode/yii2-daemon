# yii2-daemon-yarcode
Yii2 daemon based on ReactPHP

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yarcode/yii2-daemon-yarcode
```

or add

```json
"yarcode/yii2-daemon-yarcode": "*"
```

## Usage

Extend the `YarCode\Yii2\Daemon\DaemonCommand` class and add your own `prepare()` implementation.

```
<?php
namespace console\controllers;

use YarCode\Yii2\Daemon\DaemonCommand;

class AsyncController extends DaemonCommand
{
    public function prepare()
    {
        $this->loop->addPeriodicTimer(1, function() {
            \Yii::$app->db->createCommand('SELECT 1')->execute();
        });
        $this->loop->addPeriodicTimer(0.1, function() {
            while ($task = \Yii::$app->async->receiveTask('search')) {
                if ($task->execute()) {
                    \Yii::$app->async->acknowledgeTask($task);
                }
            }
        });
    }
}
```

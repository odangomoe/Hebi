<?php


namespace Odango\Hebi;


abstract class Scheduler
{
    protected $simultaneous = 5;
    protected $running = 0;

    public function afterSchedule() {}
    abstract public function beforeSchedule(callable $callback);
    abstract public function getNextItem();
    abstract public function hasItems();
    abstract public function process($item, callable $callback);
    abstract public function tick();
    abstract public function onDepletion(callable $callback);

    public function start() {
        $this->beforeSchedule(function () {
            $this->push();
        });
        $this->startTicking();
    }

    public function push($final = false) {
        while ($this->running < $this->simultaneous && $this->hasItems()) {
            $this->running++;
            $this->process($this->getNextItem(), function() {
                $this->running--;
                $this->push();
            });
        }

        if (!$final && !$this->hasItems()) {
            $this->onDepletion(function () {
                $this->push(true);
            });
        }

        if (!$this->hasItems() && $final) {
            $this->afterSchedule();
        }
    }

    public function startTicking() {
        while(!$this->hasItems() || $this->running > 0) {
            $this->tick();
        }
    }
}
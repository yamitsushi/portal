<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivateInternet
{
    //"sudo iptables -t mangle -I internet -m mac --mac-source MAC-ADDRESS-HERE -j RETURN"
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $rule;


    public function __construct($rule, $condition)
    {
        $first= "sudo iptables -t mangle ";
        $second = $condition ? "-I " : "-D ";
        $third = "internet -m " . $condition;
        $fourth = " -j RETURN";

        $this->rule($first . $second . $third . $fourth);
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        dd($this->rule);
    }
}

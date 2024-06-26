<?php

namespace App\Models\Bot;

/**
 * Interface Command.
 */
interface Command
{
    /**
     * Command constructor.
     */
    public function __construct($request);

    /**
     * Handle execution of command and return response method.
     *
     * @return mixed
     */
    public function handle();
}

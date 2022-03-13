<?php

namespace DidntPot\player\session;

interface SessionIdentifier
{
    /** @var int */
    const BASIC_SESSION = 0;
    /** @var int */
    const PLAYER_SESSION = 1;
}
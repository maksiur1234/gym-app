<?php

namespace App\Enums;

enum Role: int
{
    case Normal = 1;
    case Trainer = 2;
    case Admin = 3;
}
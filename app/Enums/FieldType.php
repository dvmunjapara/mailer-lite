<?php

namespace App\Enums;

enum FieldType: string
{
    case Date = 'date';
    case Number = 'number';
    case String = 'string';
    case Boolean = 'boolean';
}

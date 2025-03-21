<?php

namespace App\Enums;

enum BusinessType: string
{
    case ECOMMERCE = 'e-commerce';
    case BUSINESS = 'business';
    case BOTH = 'both';
}

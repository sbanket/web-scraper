<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Data
 *
 * @package App\Entity
 */
class Data extends Model
{
    protected $table = 'data';

    protected $fillable = [
        'run_id',
        'project_tag',
        'run_tag',
        'name',
        'name_url',
        'dealer',
        'dealer_url',
        'price',
        'car_image',
        'car_image_url',
        'mileage',
        'gearbox',
        'handdrive',
        'details',
        'details_url',
        'phone',
        'year',
        'refcode',
        'phone',
        'phone_url',
        'description',
        'location',
        'vin',
        'brand',
        'model',
        'dealer_website',
        'dealer_website_url',
        'field1',
        'field2',
        'field3',
        'field4',
        'field5',
        'field6',
        'field7',
        'field8',
        'field9',
        'field10',
        'field11',
        'field12',
    ];
}

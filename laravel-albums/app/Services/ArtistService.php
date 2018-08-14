<?php

namespace App\Services;

use App\Models\Artist;

class ArtistService extends BaseService
{
    protected $model = Artist::class;

    public $validationRules = [
        'name' => 'required|unique:artists|max:255',
        'image' => 'present|unique:artists|image',
        'genre' => 'present|nullable|max:255',
        'description' => 'present|nullable',
    ];

    public $validationMessages = null;
    public $validationMessages__ = [
        'required' => '',
        'unique' => '',
        'max' => '',
        'present' => '',
        'image' => '',
        'nullable' => '',
    ];
}

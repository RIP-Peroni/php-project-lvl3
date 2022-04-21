<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_id',
        'status_code',
        'h1',
        'title',
        'description',
    ];

    public function url(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'attachments', 'attachment_file_names'];

    protected $casts = [
        'attachments' => 'array',
        'attachment_file_names' => 'array',
    ];

    /**
     * A document may be given various categories.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            DocumentCategory::class,
            'document_has_categories'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterBook extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chapter_books'; // Explicitly define table name if it deviates from convention

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chapter_name',
        'book_id',
        'description',
        'is_active',
        'ai_added',
        'image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'ai_added' => 'boolean',
    ];

    /**
     * Get the class book that the chapter belongs to.
     */
    public function book()
    {
        return $this->belongsTo(ClassBook::class, 'book_id');
    }
}
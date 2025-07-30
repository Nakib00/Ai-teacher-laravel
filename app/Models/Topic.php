<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import for relationships

class Topic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic_title',
        'description',
        'is_active',
        'type',
        'note',
        'points',
        'chapter_id',
        'subject_id',
        'class_id',
    ];

    /**
     * Get the chapter that owns the Topic.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(ChapterBook::class);
    }

    /**
     * Get the subject that owns the Topic.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(ClassBook::class);
    }

    /**
     * Get the class that owns the Topic.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id'); // Assuming 'SchoolClass' is your class model name
    }
}
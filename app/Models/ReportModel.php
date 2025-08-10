<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    use HasFactory;

    protected $table = 'report_models';

    protected $fillable = [
        'user_id',
        'topic_id',
        'teacher_id',
        'note',
        'interaction_points',
        'answer_points',
        'time_points',
        'discussion_points',
        'total_points',
        'is_active',
        'session_started_at',
        'session_ended_at',
        'feedback',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'session_started_at' => 'datetime',
        'session_ended_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function teacher()
    {
        return $this->belongsTo(AiTeacher::class);
    }
}

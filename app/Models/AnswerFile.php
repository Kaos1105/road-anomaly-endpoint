<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperAnswerFile
 */
class AnswerFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'question_id',
        'width_size',
        'display_order',
    ];

    public static $selectProps = [
        'snet_answer_files.id',
        'snet_answer_files.question_id',
        'snet_answer_files.width_size',
        'snet_answer_files.display_order',
    ];

    protected $table = 'snet_answer_files';

    public $timestamps = false;

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'display_id');
    }

    public function attachmentFile(): MorphOne
    {
        return $this->morphOne(AttachmentFile::class, 'attachable');
    }

}

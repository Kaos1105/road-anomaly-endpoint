<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperAttachmentFile
 */
class AttachmentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'file_name',
        'file_path',
        'created_by',
        'created_at',
    ];

    public $timestamps = false;

    public static $selectProps = [
        'common_attachment_files.id',
        'common_attachment_files.attachable_type',
        'common_attachment_files.attachable_id',
        'common_attachment_files.file_name',
        'common_attachment_files.file_path',
        'common_attachment_files.created_by',
        'common_attachment_files.created_at',
    ];

    protected $table = 'common_attachment_files';

    public static function boot(): void
    {
        parent::boot();
//        static::creating(function ($model) {
//            $model->created_at = $model->freshTimestamp();
//            $model->created_by = Auth::id();
//        });
    }

    /**
     * Get the parent attachable model (company or employee).
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}

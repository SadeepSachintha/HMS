<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Boot the trait and register Eloquent event listeners.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->id ?? $model->number ?? $model->name ?? 'N/A';
            ActivityLog::log(
                'created',
                "Created {$modelName} #{$identifier}",
                $model
            );
        });

        static::updated(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->id ?? $model->number ?? $model->name ?? 'N/A';
            
            // Get modified fields, excluding timestamps
            $dirty = $model->getDirty();
            $changedFields = array_filter(
                array_keys($dirty),
                fn($field) => !in_array($field, ['updated_at', 'created_at'])
            );
            
            if (empty($changedFields)) {
                return;
            }
            
            $fieldsList = implode(', ', $changedFields);
            ActivityLog::log(
                'updated',
                "Updated {$modelName} #{$identifier} (Fields changed: {$fieldsList})",
                $model
            );
        });

        static::deleted(function ($model) {
            $modelName = class_basename($model);
            $identifier = $model->id ?? $model->number ?? $model->name ?? 'N/A';
            ActivityLog::log(
                'deleted',
                "Deleted {$modelName} #{$identifier}",
                $model
            );
        });
    }
}

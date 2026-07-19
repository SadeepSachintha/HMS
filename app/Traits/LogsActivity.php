<?php



namespace App\Traits;



use App\Models\ActivityLog;



/**
 * AUTOMATIC ELOQUENT MODEL ACTIVITY AUDITING:
 * - bootLogsActivity() trait hook is called by Eloquent during model boot lifecycle initialization.
 * - Automatically registers listeners for 'created', 'updated', and 'deleted' events.
 * - Excludes timestamps (created_at, updated_at) from tracking.
 * - Trait integration:
 *   1. Import App\Traits\LogsActivity namespace at the top of the model file.
 *   2. Call 'use LogsActivity;' trait registration inside the model class body.
 */

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


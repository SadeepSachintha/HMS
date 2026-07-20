<?php



namespace App\Http\Controllers;



use App\Models\ActivityLog;

use Illuminate\Http\Request;



/**
 * SYSTEM ACTIVITY LOG MANAGEMENT AND FILTER CONTROLLER:
 * - Resolves system audit logs index queries.
 * - Eager loads the associated user model to optimize DB queries (prevents N+1 database connection overhead).
 * - Implements dynamic filtering by keyword search (resolving email, name, description), action type, and date.
 */

class ActivityLogController extends Controller

{

    /**

     * Display a listing of system activity logs.

     * Only accessible by admin.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\View\View

     */

    public function index(Request $request)

    {

        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');



        // Search filter (User Name, Email, Description)

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('description', 'like', "%{$search}%")

                  ->orWhere('action', 'like', "%{$search}%")

                  ->orWhereHas('user', function ($uq) use ($search) {

                      $uq->where('name', 'like', "%{$search}%")

                        ->orWhere('email', 'like', "%{$search}%");

                  });

            });

        }



        // Action filter

        if ($request->filled('action')) {

            $query->where('action', $request->action);

        }



        // Date filter

        if ($request->filled('date')) {

            $query->whereDate('created_at', $request->date);

        }



        $logs = $query->paginate(25)->withQueryString();



        // Get unique action types for filter dropdown

        $actions = ActivityLog::select('action')->distinct()->pluck('action');



        return view('activity-logs.index', compact('logs', 'actions'));

    }


    /**
     * Export system activity logs to Excel.
     * Only accessible by admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        // Search filter (User Name, Email, Description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->get();

        $exportData = $logs->map(function ($log) {
            return [
                'timestamp' => $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '',
                'user' => $log->user ? $log->user->name . ' (' . $log->user->email . ')' : 'System / Guest',
                'action' => strtoupper($log->action),
                'description' => $log->description,
                'ip_address' => $log->ip_address,
                'user_agent' => $log->user_agent,
            ];
        })->toArray();

        $export = new \App\Exports\ActivityLogExport($exportData);
        $fileName = 'Activity_Logs_' . now()->format('Ymd_His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download($export, $fileName);
    }
}


<?php
namespace App\DataTables;
use App\Http\Start\Helpers;
use App\Model\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Services\DataTable;
use Carbon;


class CustomerTaskListDataTable extends DataTable{
    public function ajax()
    {
        $tasks = $this->query();
        return datatables()
            ->of($tasks)
            ->addColumn('action', function ($tasks) {
                $project_id = $tasks->related_to_type == 1 ? $tasks->related_to_id : null;
                $edit=$delete='';

                    $edit = (Helpers::has_permission(Auth::user()->id, 'edit_task')) ? '<a href="' . url("task/edit/$tasks->id") . '" class="btn btn-xs btn-primary"><i class="feather icon-edit"></i></a>&nbsp;' : '';

                    $delete = (Helpers::has_permission(Auth::user()->id, 'delete_task')) ? '
                        <form method="post" action="'.url("task/delete").'" class="display_inline_block" id="delete-task-'.$tasks->id.'">
                        ' . csrf_field() . '
                        <input type="hidden" name="task_id" value="'.$tasks->id.'">
                        <input type="hidden" name="project_id" value="'.$project_id.'">
                        <button title="' . __('Delete') . '" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-id="'. $tasks->id .'" data-target="#confirmDelete" data-label = "Delete" data-title="' . __('Delete task') . '" data-message="' . __('Are you sure to delete this task?') . '">
                                        <i class="feather icon-trash-2"></i> 
                                    </button>
                        </form>
                        ' : '';
                return $edit.$delete;
            })
            ->addColumn('name', function ($tasks) {
               
                    $id = '<a href="" class="task_class customer-task"  data-id="'.$tasks->id.'" data-priority-id= "'.$tasks->priorityId.'"  project_id = "'.$tasks->related_to_id.'" data-status-id= "'.$tasks->task_status_id.'"  type="button"  data-toggle="modal" data-target="#task-modal">'.$tasks->name.'</a><br/><a class="f-12" href="'.url("customer/edit/$tasks->related_to_id").'">'. $tasks->customer_name .'</a>'; 
                

                if(isset($tasks->not_end) && ($tasks->not_end != null) ){
                   $timer = '<i class="feather icon-clock color_red"></i>&nbsp&nbsp';
                }else{
                   $timer = ''; 
                }

                return $timer.$id;
            })
            ->addColumn('assigne', function ($tasks) {
                $assigne = (new Task())->taskAssignsList($tasks->id);
                $full_name = '';
                $assign = '';
                foreach($assigne as $assigne){
                    if (mb_strlen($assigne->user_name) > 10) {
                        $user_name = mb_substr($assigne->user_name, 0, 10). "..";
                    } else {
                        $user_name = $assigne->user_name;
                    }
                    $full_name = $assigne->user_name;
                    if(Helpers::has_permission(Auth::user()->id, 'edit_team_member')) {
                        $assign .= mb_strlen($full_name) > 10 ? '<a href="'. url('user/team-member-profile/'. $assigne->user_id) .'"><span data-toggle="tooltip" data-placement="right" data-original-title="'.$full_name.'">'.$user_name.'</span></a><br>' : '<a href="'. url('user/team-member-profile/'. $assigne->user_id) .'">'. $user_name .'</a><br>';
                    } else {
                        $assign .= mb_strlen($full_name) > 10 ? '<span data-toggle="tooltip" data-placement="right" data-original-title="'.$full_name.'">'.$user_name.'</span>' : $user_name; 
                    }
                }
                return  $assign;
            })            
            ->addColumn('priority', function ($tasks) {
                $allpriorities='';
                 $priorities = DB::table('priorities')->where('id','!=',$tasks->priorityId)->get();
                foreach ($priorities as $key => $value) {
                    $allpriorities .= '<li class="properties"><a class="priority_change f-14 color_black"  project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'"  task_id="'.$tasks->id.'">'.$value->name.'</a></li>'; 
                }
                 $top='<div class="btn-group">
                <button type="button" style="color:'.(($tasks->priority_name=='High')?'#099909':'#367fa9').' !important"  class="badge text-white f-12 dropdown-toggle task-priority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tasks->priority_name.'&nbsp;<span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu scrollable-menu status_change task-priority-name w-100p" role="menu">';
                $last='</ul></div>&nbsp';
                return $top.$allpriorities.$last;
            })
            ->addColumn('status_name', function ($tasks) {
                $allstatus = $status = '';
                $taskStatus = DB::table('task_statuses')->where('id','!=', $tasks->status_id)->where('id','!=', 6)->orderBy('status_order')->get();
                $statusReopen = DB::table('task_statuses')->whereNotIn('id', [$tasks->status_id, 1, 2])->orderBy('status_order')->get();
                foreach ($taskStatus as $key => $value) {
                    $allstatus .= '<li class="status-styles"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'" task_id="'.$tasks->id.'" >'.$value->name.'</a></li>';
                }
                if ($tasks->status_name == "Complete") {
                    $allstatus .= '<li class="status-styles"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="6" data-value="Re-open" task_id="'.$tasks->id.'">' . __('Re-open') . '</a></li>';
                } else if ($tasks->status_name == "Re-open") {
                    foreach ($statusReopen as $key => $value) {
                    $status .= '<li class="status-styles"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'" task_id="'.$tasks->id.'" >'.$value->name.'</a></li>';
                    }
                }
                $top='<div class="btn-group">
                <button style="color:'.$tasks->color.' !important" type="button" class="badge text-white f-12 dropdown-toggle task-status-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tasks->status_name.'&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-menu status_change task-priority-name w-150p" role="menu">';
                $last='</ul></div>&nbsp';

                
                return $tasks->status_name == "Re-open" ? $top.$status.$last : $top.$allstatus.$last;
            })
            ->addColumn('start_date', function ($tasks) {
                $start_date = isset($tasks->start_date) ? timeZoneformatDate($tasks->start_date) : '';
                return $start_date;
            })
            ->addColumn('due_date', function ($tasks) {
                $due_date = $tasks->due_date ? timeZoneformatDate($tasks->due_date) : '-';
                return $due_date;
            })
            ->rawColumns(['action','start_date','name','assigne','due_date','priority','status_name'])

            ->make(true);
    }


    public function query()
    {
        $from      = isset($_GET['from'])     ? $_GET['from']      : null;
        $to        = isset($_GET['to'])       ? $_GET['to']        : null;
        $status    = isset($_GET['status'])   ? $_GET['status']    : null;
        $assignee  = isset($_GET['assignee']) ? $_GET['assignee']  : Auth::user()->id;
        $priority  = isset($_GET['priority'])? $_GET['priority'] : null;
        $tasks     = (new Task())->getAllTaskForDT($from, $to, $status, null,  $assignee, $priority, request()->segment(3), 2);

        return $this->applyScopes($tasks);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'tasks.name', 'title' => __('Name')])
            
            ->addColumn(['data' => 'assigne', 'name' => 'task_assigns.user_id', 'title' => __('Assignee')])

            ->addColumn(['data' => 'start_date', 'name' => 'start_date', 'title' => __('Start Date')])

            ->addColumn(['data' => 'due_date', 'name' => 'due_date', 'title' => __('Due Date')])

            ->addColumn(['data' => 'priority', 'name' => 'priorities.name', 'title' => __('Priority')])

            ->addColumn(['data' => 'status_name', 'name' => 'task_statuses.name', 'title' => __('Status')])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'orderable' => false, 'searchable' => false])

            ->parameters([
                'pageLength' => $this->row_per_page,
                'language' => [
                        'url' => url('/resources/lang/'.config('app.locale').'.json'),
                    ],
                'order' => [0, 'desc']
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'created_at',
            'updated_at',
        ];
    }
}
<?php
namespace App\DataTables;
use App\Http\Start\Helpers;
use App\Model\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Services\DataTable;

use Carbon;


class UserTaskDataTable extends DataTable{
    public function ajax()
    {
        $tasks = $this->query();

        return datatables()
            ->of($tasks)
           ->addColumn('action', function ($tasks) {
                $edit=$delete='';

                    $edit = (Helpers::has_permission(Auth::user()->id, 'edit_task')) ? '<a href="' . url("task/edit/$tasks->id") . '" class="btn btn-xs btn-primary"><i class="feather icon-edit"></i></a>&nbsp;' : '';

                    $delete = (Helpers::has_permission(Auth::user()->id, 'delete_task')) ? '
                        <form method="post" action="'.url("task/delete").'" id="delete-task-'.$tasks->id.'" class="display_inline">
                        ' . csrf_field() . '
                            <input type="hidden" name="task_id" value="'.$tasks->id.'">
                            <button title="' . __('Delete') . '" class="btn btn-xs btn-danger" type="button" data-id='.$tasks->id.' data-label="Delete" data-toggle="modal" data-target="#confirmDelete" data-title="' . __('Delete task') . '" data-message="' . __('Are you sure to delete this task?') . '">
                                <i class="feather icon-trash-2"></i> 
                            </button>
                        </form>
                        ' : '';
                return $edit.$delete;
            })

            ->addColumn('start_date', function ($tasks) {
                $start_date = timeZoneformatDate($tasks->start_date);
                return $start_date;
            })

            ->addColumn('name', function ($tasks) {
                if($tasks->related_to_type == 1) {
                    $project = DB::table('projects')->where('id', $tasks->related_to_id)->first();
                    $id = '<a href="" class="task_class"  data-id="'.$tasks->id.'" data-priority-id= "'.$tasks->priority_id.'"  project_id = "'.$tasks->related_to_id.'" data-status-id= "'.$tasks->status_id.'"  type="button"  data-toggle="modal" data-target="#task-modal">'.$tasks->name.'</a><br/><a href="'.url("project/details/$tasks->related_to_id").'" class="customer-task f-12">'.$project->name.'</a>'; 
                } else if ($tasks->related_to_type == 2) {
                    $customer = (new Task())->taskCustomerName($tasks->related_to_id);
                    $customer_name= @$customer->first_name.' '.@$customer->last_name;
                    $id = '<a href="" class="task_class"  data-id="'.$tasks->id.'" data-priority-id= "'.$tasks->priority_id.'"  project_id = "'.$tasks->related_to_id.'" data-status-id= "'.$tasks->status_id.'"  type="button"  data-toggle="modal" data-target="#task-modal">'.$tasks->name.'</a><br/><a href="'.url("customer/edit/$tasks->related_to_id").'" class="customer-task f-12">'.$customer_name.'</a>'; 
                } else if ($tasks->related_to_type == 3) {
                    $ticket = (new Task())->taskTicketSubject($tasks->related_to_id);
                    $pieces = mb_substr(@$ticket->subject, 0, 30);
                    $id = '<a href="" class="task_class"  data-id="'.$tasks->id.'" data-priority-id= "'.$tasks->priority_id.'"  project_id = "'.$tasks->related_to_id.'" data-status-id= "'.$tasks->status_id.'"  type="button"  data-toggle="modal" data-target="#task-modal">'.$tasks->name.'</a><br/><a href="'.url("ticket/reply/".base64_encode($tasks->related_to_id)).'" class="customer-task f-12">'.@$ticket->subject.'</a>'; 
                } else {
                     $id = '<a href="" class="task_class"  data-id="'.$tasks->id.'" data-priority-id= "'.$tasks->priority_id.'"  project_id = "'.$tasks->related_to_id.'" data-status-id= "'.$tasks->status_id.'"  type="button"  data-toggle="modal" data-target="#task-modal">'.$tasks->name.'</a>'; 
                }

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

             ->addColumn('due_date', function ($tasks) {
                $due_date = $tasks->due_date ? timeZoneformatDate($tasks->due_date) : '-';
                return $due_date;
            })

             ->addColumn('priority_name', function ($tasks) {
                $allpriorities='';
                 $priorities = DB::table('priorities')->where('id','!=',$tasks->priority_id)->get();
                foreach ($priorities as $key => $value) {
                    $allpriorities .= '<li class="priority_change f-14 properties"  project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'"  task_id="'.$tasks->id.'">'.$value->name.'</a></li>'; 
                }
                 $top='<div class="btn-group">
                <button type="button" style="color:'.(($tasks->priorityName=='High')?'#099909':'#367fa9').' !important"  class="badge text-white f-12 dropdown-toggle task-priority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tasks->priorityName.'&nbsp;<span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu scrollable-menu status_change task-priority-name" role="menu">';
                $last='</ul></div>&nbsp';
                return $top.$allpriorities.$last;
            })
            ->addColumn('status_name', function ($tasks) {
                $allstatus = $status = '';
                $taskStatus = DB::table('task_statuses')->where('id','!=', $tasks->status_id)->where('id','!=', 6)->orderBy('status_order')->get();
                $statusReopen = DB::table('task_statuses')->whereNotIn('id', [$tasks->status_id, 1, 2])->orderBy('status_order')->get();
                foreach ($taskStatus as $key => $value) {
                    $allstatus .= '<li class="properties"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'" task_id="'.$tasks->id.'" >'.$value->name.'</a></li>';
                }
                if ($tasks->status_name == "Complete") {
                    $allstatus .= '<li class="properties"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="6" data-value="Re-open" task_id="'.$tasks->id.'">'. __('Re-open') .'</a></li>';
                } else if ($tasks->status_name == "Re-open") {
                    foreach ($statusReopen as $key => $value) {
                    $status .= '<li class="properties"><a class="status_change f-14 color_black" project_id="'.$tasks->related_to_id.'" data-id="'. $value->id .'" data-value="'. $value->name .'" task_id="'.$tasks->id.'" >'.$value->name.'</a></li>';
                    }
                }
                $top='<div class="btn-group">
                <button style="color:'.$tasks->color.' !important" type="button" class="badge text-white f-12 dropdown-toggle task-status-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tasks->status_name.'&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-menu status_change" role="menu task-priority-name">';
                $last='</ul></div>&nbsp';

                return $tasks->status_name == "Re-open" ? $top.$status.$last : $top.$allstatus.$last;
            })
            ->rawColumns(['action','start_date','name','assigne','due_date','priority_name','status_name'])

            ->make(true);
    }


    public function query()
    {
        $id = $this->user_id;
        $status     = isset($_GET['status']) ? $_GET['status'] : null ;
        $from     = isset($_GET['from']) ? $_GET['from'] : null ;
        $to     = isset($_GET['to']) ? $_GET['to'] : null ;
        $priority = isset($_GET['priority'])? $_GET['priority'] : null;
        $tasks = (new Task())->getUserTaskForDT($from, $to, $status, $id,  $priority)->get();
        
        return $this->applyScopes($tasks);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name') ])
            
            ->addColumn(['data' => 'assigne', 'name' => 'assigne', 'title' => __('Assignee') ])

            ->addColumn(['data' => 'start_date', 'name' => 'start_date', 'title' => __('Start date')])

            ->addColumn(['data' => 'due_date', 'name' => 'due_date', 'title' => __('Due date') ])

            ->addColumn(['data' => 'priority_name', 'name' => 'priority_name', 'title' => __('Priority') ])

            ->addColumn(['data' => 'status_name', 'name' => 'status_name', 'title' => __('Status')])

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


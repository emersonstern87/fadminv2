<?php
namespace App\DataTables;
use App\Http\Start\Helpers;
use App\Model\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Services\DataTable;

use Carbon;


class TicketDataTable extends DataTable{
    public function ajax()
    {
        $tickets = $this->query();

        return datatables()
            ->of($tickets)
            ->addColumn('action', function ($tickets) {
                $edit=$delete='';

                    $edit = (Helpers::has_permission(Auth::user()->id, 'edit_ticket')) ? '<a href="' . url("ticket/edit/$tickets->id") . '" class="btn btn-xs btn-primary"><i class="feather icon-edit"></i></a>&nbsp;' : '';

                    $delete = (Helpers::has_permission(Auth::user()->id, 'delete_ticket')) ? '
                <form method="post" action="' . url("ticket/delete") . '" class="display_inline" id="delete-item-'.$tickets->id.'">
                ' . csrf_field() . '
                <input type="hidden" name="ticket_id" value="'.$tickets->id.'">
                <button title="' . __('Delete') . '" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-id="'.$tickets->id.'" data-target="#theModal" data-label="Delete" data-title="' . __('Delete ticket') . '" data-message="' . __('Are you sure to delete this ticket?') . '">
                                <i class="feather icon-trash-2"></i>
                            </button>
                </form>
                ' : '';
                return $edit.$delete;
            })

            ->addColumn('subject', function ($tickets) {
                if ($tickets->project_name) {
                    $id = "<a href='".url("ticket/reply/".base64_encode($tickets->id))."'>". $tickets->subject ."</a><br/><a href='" . url("project/details/$tickets->project_table_id") . "' class='f-12 color_709A52'>". $tickets->project_name ."</a>";
                } else {
                    $id = "<a href='".url("ticket/reply/".base64_encode($tickets->id))."'>". $tickets->subject ."</a>";
                }
                return $id;
            })

            ->addColumn('status', function ($tickets) {
                $allstatus='';
                $ticketStatus = DB::table('ticket_statuses')->where('id','!=', $tickets->ticket_status_id)->orderBy('name')->get();
                foreach ($ticketStatus as $key => $value) {
                    $allstatus .= '<li class="properties"><a class="ticket_status_change f-14 class_black" ticket_id="'.$tickets->id.'" data-id="'. $value->id .'" data-value="'. $value->name .'">'.$value->name.'</a></li>';
                }
                $top='<div class="btn-group">
                <button style="color:'.$tickets->color.' !important" type="button" class="badge text-white f-12 dropdown-toggle task-status-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tickets->status.'&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-menu task-priority-name w-150p" role="menu">';
                $last='</ul></div>&nbsp';
                
                return $top.$allstatus.$last;

            })

            ->addColumn('priority_name', function ($tickets) {
                $allpriorities='';
                 $priorities = DB::table('priorities')->where('id','!=', $tickets->priority_id)->get();
                foreach ($priorities as $key => $value) {
                    $allpriorities .= '<li class="properties"><a class="ticket_priority_change f-14 color_black"  ticket_id="'.$tickets->id.'" data-id="'. $value->id .'" data-value="'. $value->name .'">'.$value->name.'</a></li>'; 
                }
                 $top='<div class="btn-group">
                <button type="button" style="color:'.(($tickets->priority == 'High')?'#099909':'#367fa9').' !important"  class="badge text-white f-12 dropdown-toggle task-priority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$tickets->priority.'&nbsp;<span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu scrollable-menu status_change task-priority-name w-100p" role="menu">';
                $last='</ul></div>&nbsp';
                return $top.$allpriorities.$last;
            })

            ->addColumn('department', function ($tickets) {
                return $tickets->department_name;

            })

            ->addColumn('id', function ($tickets) {
                "<a href='".url("ticket/reply/".base64_encode($tickets->id))."'>". $tickets->subject ."</a><br/><a href='" . url("project/details/$tickets->project_table_id") . "' class='f-12 color_709A52'>". $tickets->project_name ."</a>";
                return "<a href='".url("ticket/reply/".base64_encode($tickets->id))."'>".$tickets->id."</a>";
            })


             ->addColumn('last_reply', function ($tickets) {
                $last_reply = $tickets->last_reply && $tickets->last_reply != $tickets->date ?  timeZoneformatDate($tickets->last_reply)."<br />".timeZonegetTime($tickets->last_reply)  :  __('Not Replied Yet') ;
                return $last_reply;
            })
             ->addColumn('date', function ($tickets) {
                $date = $tickets->date ?  timeZoneformatDate($tickets->date)."<br />".timeZonegetTime($tickets->date)  :  __('Created At') ;
                return $date;
            })

             ->addColumn('first_name', function ($tickets) {
                return '<a href="' . url("customer/edit/".$tickets->customer_id) . '">'. $tickets->first_name. " " .$tickets->last_name .'</a>';
            })
            ->rawColumns(['action','id','subject','status','last_reply','date','first_name', 'department', 'priority_name'])

            ->make(true);
    }

    public function query() {

        $from     = isset($_GET['from'])     ? $_GET['from']     : null;
        $to       = isset($_GET['to'])       ? $_GET['to']       : null;
        $status   = isset($_GET['status'])   ? $_GET['status']   : null; 
        $project  = isset($_GET['project'])  ? $_GET['project']  : null; 
        $departmentId = isset($_GET['department_id']) ? $_GET['department_id'] : null;
        $assigneeId = isset($_GET['assignee']) ? $_GET['assignee'] : null;

        $tickets = (new Ticket())->getAllTicketDT($from, $to, $status, $project, $departmentId, $assigneeId);
        return $this->applyScopes($tickets);
    }

    public function html()
    {
        return $this->builder()


            ->addColumn(['data' => 'last_reply', 'name' => 'tickets.last_reply', 'visible' => false])
            
            ->addColumn(['data' => 'id', 'name' => 'tickets.id', 'title' => __('#')])

            ->addColumn(['data' => 'subject', 'name' => 'tickets.subject', 'title' => __('Subject')])

            ->addColumn(['data' => 'department', 'name' => 'departments.name', 'title' => __('Department') ])
            
            ->addColumn(['data' => 'project_name', 'name' => 'projects.name', 'visible' => false])

            ->addColumn(['data' => 'first_name', 'name' => 'customers.name', 'title' => __('Customer') ])

            ->addColumn(['data' => 'last_reply', 'name' => 'tickets.last_reply', 'title' => __('Last reply')])

            ->addColumn(['data' => 'date', 'name' => 'tickets.date', 'title' => __('Created at')])

            ->addColumn(['data' => 'status', 'name' => 'ticket_statuses.name', 'title' => __('Status')])

            ->addColumn(['data' => 'priority_name', 'name' => 'priorities.name', 'title' => __('Priority')])

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
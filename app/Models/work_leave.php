<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class work_leave extends Model
{
    use HasFactory;
    protected $table = 'work_leaves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'work_leave_describe',
        'work_leave_date',
        'work_leave_time',
        'work_leave_status',
        'work_leave_approve_type',
        'work_leave_approve_time'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getStutusWorkLeaveAttribute(){
        switch ( $this->work_leave_status) {
            case 1:
                return "<span>รอดำเนินการ</span>";
            case 2:
                return "<span>ดำเนินการเสร็จสิ้น</span>";
            default:
                return '';
        }
    }
    public function getStatusWorkLeaveApproveAttribute(){
        switch ( $this->work_leave_approve_type) {
            case 1:
                return "<span>อนุมัติ</span>";
            case 2:
                return "<span>ไม่อนุมัติ</span>";
            default:
                return '';
        }
    }

    public function user_work_leave()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

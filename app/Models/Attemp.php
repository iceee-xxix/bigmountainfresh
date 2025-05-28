<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Attemp extends Model
{
    use HasFactory;
    protected $table = 'attemp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'attemp_date',
        'users_id',
        'attemp_in_out',
        'attemp_type',
        'attemp_image',
        'attemp_time',
        'attemp_late_time',
        'latitude',
        'longitude',
        'attemp_describe',
    ];

    public function getLateStatusAttribute(){
        switch ($this->attemp_status) {
            case 0:
                return "<span class='text-danger'>สาย</span>";
            case 1:
                return "<span class='text-success'>ปกติ</span>";
            case 3:
                return "<span>ยังไม่ได้ลงเวลา</span>";
            default:
                return '';
        }
    }

    public function getInOutStatusAttribute(){
        switch ( $this->attemp_in_out) {
            case 1:
                return "<span>เข้า</span>";
            case 2:
                return "<span>ออก</span>";
            case 0:
                return "<span>ลา</span>";
            default:
                return '';
        }
    }
    public function getAttempTypeNameAttribute(){
        switch ( $this->attemp_type) {
            case 1:
                return "<span>ปกติ</span>";
            case 2:
                return "<span>ทำงานนอกสถานที่</span>";
            case 3:
                return "<span>ไปราชการ</span>";
            case 4:
                return "<span>ลา</span>";
            default:
                return '';
        }
    }
    public function User(){
        return $this->belongsTo(User::class ,'users_id');
    }


}

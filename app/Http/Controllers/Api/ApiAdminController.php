<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentDetail;
use App\Events\SendApproval;
use App\Models\TeacherDetail;

class ApiAdminController extends Controller
{
    /**
     * Get student lists
    */
    public function studentList(){
        $students = DB::table('users')
                    ->Join('student_details','student_details.student_id','=','users.id')
                    ->select('student_details.*','users.id as uid', 'users.email', 'users.name')
                    ->where('users.role', 'Student')
                    ->get();

        return response()->json(['student' => $students, 'status' => 200]);
    }



    public function teacherList(){
        $teachers = DB::table('users')
            ->join('teacher_details','teacher_details.teacher_id','=','users.id')
            ->select('teacher_details.*', 'users.id as uid', 'users.email', 'users.name')
            ->where('users.role', 'Teacher')->get();
        return response()->json(['teachers' => $teachers, 'status' => 200]);
    }


    public function approveStudent(Request $request){
        try {
            $id = $request->id;
            $approval = StudentDetail::where('student_id', $id)->update(['status' => 1]);
            if($approval)
                event(new SendApproval($id)); // TO send email through event
            else
                return response()->json(['error' => 'Id is not correct', 'status' => 401]);  
            
            return response()->json(['success' => true, 'status' => 200]);  
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 401]);
        }
        
    }



    public function approveTeacher(Request $request)
    {
        try {
            $id = $request->id;

            $approval = TeacherDetail::where('teacher_id',$id)->update(['status' => 1]); // To update teacher status as approved
            if($approval)
                event(new SendApproval($id)); // TO send email through event
            else
                return response()->json(['error' => 'Id is not correct', 'status' => 401]);
            
            return response()->json(['success' => true, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        
    }
}

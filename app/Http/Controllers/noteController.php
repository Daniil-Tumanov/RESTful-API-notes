<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use Validator;

class noteController extends Controller
{
    public function notes(){
        return response()->json(['status code' => 200,'status text' => 'List notes','Notes' => Notes::get()], 200);
    }

    public function noteById($id){
        $notes = Notes::find($id);
        if(is_null($notes)){
            return response()->json(['status code' => 404, 'status text' => 'Note not found', 'message' => 'Note not found'], 404);
        }
        if($notes->title == null){
            $content = Notes::where('content')->get();
            $short_context = substr($content, 0, 10);
            $notes -> title = $short_context;
            return response()->json(['status code'=> 200, 'status text'=>'View note', 'Note' => $notes], 200);
        }
        return response()->json(['status code'=> 200, 'status text'=>'View note', 'Note' => $notes], 200);
    }

    public function addNote(Request $req){
        $notes = Notes::create($req->all());
        return response()->json($notes, 201);
    }

    public function editNote(Request $req, $id){
    $notes = Notes::find($id);
        if(is_null($notes)){
            return response()->json(['status code' => 400, 'status text' => 'Editing error', 'body'=>'status: false, Note not found'], 404);
        }
        $notes->where('id', $id)->update($req->all());
        return response()->json(['status code'=>201, 'status text:'=>'View note', 'Note'=>$notes], 200);
    }

    public function deleteNote($id){
        $notes = Notes::find($id);
        if(is_null($notes)){
            return response()->json(['status code' => 404, 'status text' => 'Note not found', 'body'=>'message: Note not found'], 404);
        }
        $notes->where('id', $id)->delete();
        return response()->json(['status code' => 201,'status text' => "Successful delete", 'body'=>'message: Note not found'], 201);
    }
    
    public function searchByNote(Request $req){
        $data = $req->get('query');
        $search = Notes::where('title', 'like', "%$data%")
                    ->orWhere('content', 'like', "%$data%")
                    ->get();
        if($search->isEmpty()){
            return response()->json(['status code' => 404,'status text' => 'Notes not found'], 404);
            }
            return response()->json(['status code' => 200,'status text' => 'Found notes', 'Notes' => $search], 200);
    }

}
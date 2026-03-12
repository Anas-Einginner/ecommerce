<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MessageController extends Controller
{
    public function view()
    {
        return view('dashboard.info-messages.contact.index');
    }
    public function getdata(Request $request)
    {
        $messages = ContactMessage::query();

        return DataTables::of($messages)
            ->filter(function ($query) use ($request) {

                if ($request->get('full_name')) {
                    $query->where('full_name', 'like', '%' . $request->get('full_name') . '%');
                }

                if ($request->get('email')) {
                    $query->where('email', 'like', '%' . $request->get('email') . '%');
                }

                if ($request->get('status')) {
                    $query->where('status', 'like', '%' . $request->get('status') . '%');
                }
            })
            ->addIndexColumn()



            // العمليات
            ->addColumn('action', function ($messages) {

                $btns = [];

                $data_attr  = 'data-id="' . $messages->id . '" ';
                $data_attr .= 'data-full_name="' . e($messages->full_name) . '" ';
                $data_attr .= 'data-email="' . e($messages->email) . '" ';
                $data_attr .= 'data-subject="' . e($messages->subject) . '" ';
                $data_attr .= 'data-message="' . e($messages->message) . '" ';
                $data_attr .= 'data-status="' . e($messages->status) . '" ';



                // ✏️ تعديل
                $btns[] = '<a ' . $data_attr . '
        data-bs-toggle="modal"
        data-bs-target="#update-modal"
        class="text-warning update_btn"
        title="تعديل">
        <i class="bi bi-pencil-fill"></i>
    </a>';



                // 🗑 حذف
                $btns[] = '<a href="javascript:;"
        data-id="' . $messages->id . '"
        data-url="' . route('dash.messages.delete') . '"
        class="text-danger btn-delete"
        title="حذف">
        <i class="bi bi-trash-fill"></i>
    </a>';

                return '<div class="d-flex align-items-center gap-3 fs-6 justify-content-start">'
                    . implode('', $btns) .
                    '</div>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        // رفع الصورة أولاً
      

        ContactMessage::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
        ]);

       return back()->with('success', 'Message sent successfully!');
    }

    public function update(Request $request)
    {
        $messages = ContactMessage::findOrFail($request->id);

        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'status' => ['required', 'in:new,read,replied'],
        ]);

        

        $messages->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => 'تم تعديل التصنيف بنجاح'
        ]);
    }


 




    public function delete(Request $request)
    {
        $messages = ContactMessage::findOrFail($request->id);

      

        $messages->delete();

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
}

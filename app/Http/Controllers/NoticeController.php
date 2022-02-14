<?php

namespace App\Http\Controllers;

use App\User;
use App\Notice;
use Notification;
use App\Enums\NoticeStatus;
use Illuminate\Http\Request;
use App\Notifications\NewNotice;
use App\DataTables\NoticeDataTable;
use Brian2694\Toastr\Facades\Toastr;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NoticeDataTable $dataTable)
    {
        return $dataTable->render('noticeboard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noticeStatus = NoticeStatus::toArray();
        return view('noticeboard.form', compact('noticeStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'notice_title' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);
        $notice = new Notice();
        $notice->title = $request->notice_title;
        $notice->description = $request->description;
        $notice->status = $request->status;
        $notice->save();

        // send notification to all user
        if ($notice->status == NoticeStatus::Published) {
            $users = User::all();
            Notification::send($users, new NewNotice($notice));
        }

        Toastr::success('Notice Successfully Send.', 'Success');
        return redirect()->route('noticeboard.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        return view('noticeboard.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        $noticeStatus = NoticeStatus::toArray();
        return view('noticeboard.form', compact('notice', 'noticeStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'notice_title' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);
        $notice = Notice::findOrFail($id);
        $notice->title = $request->notice_title;
        $notice->description = $request->description;
        $notice->status = $request->status;
        $notice->save();
        // send notification to all user
        if ($notice->status == NoticeStatus::Published) {
            $users = User::all();
            Notification::send($users, new NewNotice($notice));
        }
        Toastr::success('Notice Successfully Updated.', 'Success');
        return redirect()->route('noticeboard.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();
        Toastr::success('Notice Successfully Deleted.', 'Success');
        return redirect()->back();
    }
}

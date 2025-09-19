<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index() {
        return view('workshop');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'time_start'  => 'required',
            'time_end'    => 'required',
            'location'    => 'required|string|max:255',
            'benefit'     => 'required|string',
            'quota'       => 'required|integer',
            'status'      => 'required|string|in:,inactive,registered,finished',
        ]);

        if ($request->status === 'registered') {
            $exists = Workshop::where('status', 'registered')->exists();
            if ($exists) {
                return redirect()->back()->with(AlertHelper::error('Sudah ada workshop dengan status registered', 'Error'));
            }
        }

        Workshop::create($request->all());

        return redirect()->back()->with(AlertHelper::success('User berhasil ditambahkan', 'Success'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'time_start'  => 'required',
            'time_end'    => 'required',
            'location'    => 'required|string|max:255',
            'benefit'     => 'required|string',
            'quota'       => 'required|integer',
            'status'      => 'required|string|in:,inactive,registered,finished',
        ]);

        $workshop = Workshop::findOrFail($id);

        if ($request->status === 'registered') {
            $exists = Workshop::where('status', 'registered')
                ->where('id', '!=', $id)
                ->exists();
            if ($exists) {
                return redirect()->back()->with(AlertHelper::error('Sudah ada workshop dengan status registered', 'Error'));
            }
        }

        $workshop->update($request->all());

        return redirect()->back()->with(AlertHelper::success('User berhasil diupdate', 'Success'));
    }

    public function destroy($id)
    {
        $workshop = Workshop::find($id);

        if (!$workshop) {
            return redirect()->back()->with(AlertHelper::error('User tidak ditemukan', 'Error'));
        }

        try {
            $workshop->delete();
            return redirect()->back()->with(AlertHelper::success('User berhasil dihapus', 'Success'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertHelper::error('Gagal menghapus user', 'Error'));
        }
    }

}

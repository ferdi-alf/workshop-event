<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::with('workshop')->orderBy('position', 'asc')->get();
        return view('banner', compact('banners'));
    }

   public function show($id)
    {
        try {
            $banner = Banner::with('workshop')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $banner->id,
                    'caption' => $banner->caption,
                    'image' => $banner->image_url,
                    'workshop_id' => $banner->workshop_id,
                    'workshop' => $banner->workshop ? [
                        'id' => $banner->workshop->id,
                        'title' => $banner->workshop->title
                    ] : null,
                    'position' => $banner->position
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Banner tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'workshop_id' => 'nullable|exists:workshops,id',
        ]);

        $nextPosition = Banner::max('position') + 1;

        $banner = new Banner();
        $banner->caption = $request->caption;
        $banner->workshop_id = $request->workshop_id;
        $banner->position = $nextPosition;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            if (!file_exists(public_path('img/banners'))) {
                mkdir(public_path('img/banners'), 0755, true);
            }
            
            $image->move(public_path('img/banners'), $imageName);
            $banner->image_url = $imageName;
        }

        $banner->save();

        return back()->with(AlertHelper::success('Banner berhasil ditambahkan!', 'Success'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
            'workshop_id' => 'nullable|exists:workshops,id',
        ]);

        $banner->caption = $request->caption;
        $banner->workshop_id = $request->workshop_id;

        if ($request->hasFile('image')) {
            if ($banner->image && file_exists(public_path('img/banners/' . $banner->image))) {
                unlink(public_path('img/banners/' . $banner->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            if (!file_exists(public_path('img/banners'))) {
                mkdir(public_path('img/banners'), 0755, true);
            }
            
            $image->move(public_path('img/banners'), $imageName);
            $banner->image_url = $imageName;
        }

        $banner->save();

        return back()->with(AlertHelper::success('Banner berhasil diupdate!', 'Success'));
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->image && file_exists(public_path('img/banners/' . $banner->image))) {
            unlink(public_path('img/banners/' . $banner->image));
        }

        $banner->delete();

        return back()->with(AlertHelper::success('Banner berhasil dihapus!', 'Success'));
    }

    public function updatePositions(Request $request)
    {
        $positions = $request->input('positions');

        foreach ($positions as $position) {
            Banner::where('id', $position['id'])->update(['position' => $position['position']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Posisi banner berhasil diupdate!'
        ]);
    }
}
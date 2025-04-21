<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpFileImageController extends Controller
{
    public function uploadFolder(Request $request)
    {
        try {
            $urls = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $originalPath = $image->getClientOriginalName();
                    $path = $image->storeAs('uploads/images', $originalPath, 'public');
                    $urls[] = asset('storage/' . $path);
                }
            }
            return response()->json([
                'image_urls' => $urls,
                'status' => true,
                'message' => 'Tải Lên Thành Công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra'
            ]);
        }
    }

}

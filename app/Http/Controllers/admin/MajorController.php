<?php

namespace App\Http\Controllers\admin;

use App\Models\Major;
use App\Http\Traits\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMajorRequest;
use App\Http\Requests\UpdateMajorRequest;
use Illuminate\Http\Request;
class MajorController extends Controller
{

    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
$query = Major::query();

    // تطبيق البحث إذا وجد نص في حقل البحث
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // جلب البيانات مع الترتيب والترقيم مع الحفاظ على معاملات البحث في الروابط
    $majors = $query->latest()->paginate(10)->withQueryString();

    return view('admin.majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.majors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMajorRequest $request)
    {
        if($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->file('image'), Major::IMAGE_PATH);
        }

        Major::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName ?? null
        ]);

        return redirect()
        ->route('admin.major.index')
        ->with('success','Major saved successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        return view('admin.majors.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMajorRequest $request, Major $major)
    {       

            if($request->hasFile('image')) {
                $imageName = $this->uploadImage($request->image, Major::IMAGE_PATH, $major->image);
            }            

            $major->update(
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $imageName?? $major->image
                ]
            );

            return redirect()
            ->route('admin.major.index')
            ->with('success','Major is updated successfully');
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()
        ->back()
        ->with('success','Major is deleted successfully');
    }

    public function trashed(Request $request)
    {
        $query = Major::onlyTrashed()->withCount('doctors');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $majors = $query->latest('deleted_at')->paginate(15);

        return view('admin.majors.trashed', compact('majors'));
    }

    public function restore($id)
    {
        $major = Major::onlyTrashed()->findOrFail($id);
        $major->restore();

        return redirect()
        ->route('admin.major.index')
        ->with('success','Major restored successfully');
    }
}


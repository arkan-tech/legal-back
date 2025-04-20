<?php

namespace App\Http\Controllers\Admin\Library\RulesAndRegulations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RulesAndRegulations\StoreRulesAndRegulationsRequest;
use App\Models\Library\LibraryCat;
use App\Models\Library\RulesAndRegulations;
use App\Models\Library\RulesAndRegulationsReleaseTools;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class RulesAndRegulationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = RulesAndRegulations::orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->editColumn('category_id', function ($row) {
                    $cat = $row->MainCategory->title;
                    return $cat;
                })
                ->editColumn('sub_category_id', function ($row) {
                    $cat = $row->SubCategory->title;
                    return $cat;
                })
                ->addColumn('action', function ($row) {
                    $actions = '   <a class="m-1"    href="' . route('admin.library.rules_regulations.edit', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-user-pen"></i>
                                  </a>
                    <a class="btn-delete-rules_regulations m-1"  id="btn_delete_rules_regulations_' . $row->id . '"  href="' . route('admin.library.rules_regulations.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>

                                  ';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('admin.library.rules_regulations.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $main_cat = LibraryCat::where('parent', '0')->get();
        $sub_cat = [];
        return view('admin.library.rules_regulations.create', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreRulesAndRegulationsRequest $request)
    {
        $main = RulesAndRegulations::create(
            [
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'name' => $request->name,
                'release_date' => $request->release_date,
                'publication_date' => $request->publication_date,
                'status' => $request->status,
                'about' => $request->about,
                'law_name' => $request->law_name,
                'law_description' => $request->law_description,
                'text' => $request->text,
                'pdf_file' => saveImage($request->pdf_file, 'uploads/library/rules_regulations/pdf/'),
                'world_file' => saveImage($request->world_file, 'uploads/library/rules_regulations/world/'),
            ]
        );
        foreach ($request->release_tools as $tool) {

            RulesAndRegulationsReleaseTools::create([
                'rules_regulation_id' => $main->id,
                'tool_name' => $tool['tool'],
            ]);
        }

        return redirect()->back()->with('success', 'تم الحفظ بنجاح');

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item = RulesAndRegulations::with('ReleasTools')->findOrFail($id);
        $main_cat = LibraryCat::where('parent', '0')->get();
        $sub_cat = LibraryCat::where('parent', $item->category_id)->get();
        return view('admin.library.rules_regulations.edit', get_defined_vars());

    }


    public function update(StoreRulesAndRegulationsRequest $request)
    {
        $item = RulesAndRegulations::findOrFail($request->id);
        $item->update([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'release_date' => $request->release_date,
            'publication_date' => $request->publication_date,
            'status' => $request->status,
            'about' => $request->about,
            'law_name' => $request->law_name,
            'law_description' => $request->law_description,
            'text' => $request->text,

        ]);

        if ($request->has('pdf_file')) {
            $item->update([
                'pdf_file' => saveImage($request->pdf_file, 'uploads/library/rules_regulations/pdf/'),
            ]);
        }
        if ($request->has('world_file')) {
            $item->update([
                'world_file' => saveImage($request->world_file, 'uploads/library/rules_regulations/world/'),
            ]);
        }
        if ($request->has('release_tools')) {
            foreach ($request->release_tools as $tool) {
                if (!is_null($tool['tool'])) {
                    RulesAndRegulationsReleaseTools::create([
                        'rules_regulation_id' => $item->id,
                        'tool_name' => $tool['tool'],
                    ]);
                }

            }
        }

        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }

    public function destroy($id)
    {
        $book = RulesAndRegulations::findOrFail($id);
        $book->delete();
        return \response()->json([
            'status' => true
        ]);
    }

    public function DestroyReleaseTools($id)
    {
        $book = RulesAndRegulationsReleaseTools::findOrFail($id);
        $book->delete();
        return \response()->json([
            'status' => true
        ]);
    }

    public function getLibrarySubCatBaseId($id)
    {
        $sub_cat = LibraryCat::where('parent', $id)->get();
        $items_html = view('admin.library.rules_regulations.includes.sub-cat-select', compact('sub_cat'))->render();
        return \response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);

    }
}

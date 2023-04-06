<?php

namespace App\Http\Controllers\Admin;

use App\Facades\AppFacade;
use App\Helper\Status;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Service\AuthorService;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var AuthorService
     */
    private AuthorService $authorService;

    /**
     *
     */
    public function __construct()
    {
        $this->authorService = new AuthorService;
        parent::__construct();
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $authors = Author::all();
        $statuses = Status::getSelectedStatuses([
            Status::STATUS_ACTIVE,
            Status::STATUS_INACTIVE,
            Status::STATUS_PENDING,
            Status::STATUS_NEED_MODIFICATION
        ]);


        return view('back.author.create', compact('authors', 'statuses'));
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $authors = $this->authorService->all();
        $title = 'Authors';
        return view('back.author.index', compact('authors','title'));
    }

    
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status' => 'required',
        ]);

        $author = new Author;
        $author->name = $validatedData['name'];
        $author->email = $validatedData['email'];
        $author->password = bcrypt($validatedData['password']);
        $author->status = $validatedData['status'];


        if ( $author->save()) {
            AppFacade::generateActivityLog('authors', 'create', DB::getPdo()->lastInsertId());
            flash()->addSuccess('Author successfully created');
            return redirect()->route('admin.author.index');
        }

        flash()->addError('Author failed to add');
        return redirect()->back();
    }

    // READ

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $author = Author::find($id);
        return view('back.author.show', compact('author'));
    }

    // UPDATE

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email,' . $id,
            'password' => 'nullable|min:8',
            'status' => 'required',
        ]);

        $author = Author::find($id);
        $author->name = $validatedData['name'];
        $author->email = $validatedData['email'];
        if ($validatedData['password']) {
            $author->password = bcrypt($validatedData['password']);
        }
        $author->status = $validatedData['status'];
        $author->save();

        return redirect()->route('authors.index')->with('success', 'Author updated successfully');
    }

    // DELETE

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully');
    }
}

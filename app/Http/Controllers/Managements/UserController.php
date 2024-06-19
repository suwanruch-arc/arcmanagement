<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Traits\Search;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $query = User::query()->withTrashed();
        $query = Search::getData($query, [
            ['field' => 'name'],
            ['field' => 'email'],
            ['field' => 'username'],
            ['field' => 'contact_number'],
            ['field' => 'position'],
            ['field' => 'role'],
            ['field' => ['name', 'keyword'], 'ref' => 'partner'],
            ['field' => ['name', 'keyword'], 'ref' => 'department']
        ]);
        $users = $query->orderBy('status')->paginate(25);
        return view('manage.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->authorize('create');

        return view('manage.users._form', [
            'model' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('manage.users._form', [
            'model' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->status = 'inactive';
        $user->save();
        $user->delete();

        return redirect()->to(url()->previous())
            ->with('success', __('message.deleted', ['name' => $user->name]));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            if ($user->trashed()) {
                $user->restore();
            }
            User::where('id', $id)->update(['status' => 'active']);

            return redirect()->to(url()->previous())
                ->with('success', __('message.restored', ['name' => $user->name]));
        }
        return redirect()->to(url()->previous())
            ->with('error', __('message.update_failed'));
    }
}

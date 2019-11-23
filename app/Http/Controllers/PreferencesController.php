<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrefRequest;
use App\Repositories\PreferencesRepositoryInterface;
use Illuminate\Http\Request;
use Auth;
class PreferencesController extends Controller
{
    //
    protected $prefs;
    public function __construct(PreferencesRepositoryInterface $pref)
    {
        $this->prefs = $pref;
    }

    public function show()
    {
        //dd($this->prefs->findWhere(['user_id', '=', Auth::user()->id]));
        return view('preferences.detail', ['prefs' => $this->prefs->findWhere(['user_id', '=', Auth::user()->id])]);
    }

    public function edit()
    {
        return view('preferences.edit', ['prefs' => $this->prefs->findWhere(['user_id', '=', Auth::user()->id])]);
    }

    public function update(StorePrefRequest $request)
    {
        $prefs_user = $this->prefs->findWhere(['user_id', '=', Auth::user()->id]);
        //

        $prefs_update = $this->prefs->update($prefs_user[0]->id,
            [
                'es_endpoint' => $request->es_endpoint,
            ]);

        if ($prefs_update) {
            return redirect()->route('show_prefs');
        }
    }

}

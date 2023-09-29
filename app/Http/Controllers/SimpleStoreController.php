<?php

namespace App\Http\Controllers;

use App\Models\Free\Conseils;
use App\Models\Free\TypeConseil;
use Illuminate\Http\Request;

class SimpleStoreController extends Controller
{


    public function index()
    {
        $typeConseils = TypeConseil::all();
        $conseils = Conseils::all();
        return view('index')->with(['typeConseils' => $typeConseils, 'conseils' => $conseils]);
    }

    public function formTypeConseil()
    {
        return view('form.add')->with(['type' => 'typeConseil']);
    }

    public function formConseil()
    {
        $typeConseils = TypeConseil::all();
        return view('form.add')->with(['type' => 'conseil', 'typeConseils' => $typeConseils]);
    }


    public function storeTypeConseil(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:type_conseils,nom',
            'description' => 'required',
        ]);

        $typeConseil = new TypeConseil([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
        ]);
        $typeConseil->save();
        return to_route('index')->with('success', 'TypeConseil saved!');
    }




    public function storeConseil(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'id_type' => 'required|exists:type_conseils,id',
        ]);

        if ($request->input('image') != null && $request->hasFile('image') && $request->file('image')->isValid()) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('conseils'), $imageName);
            $finalName = 'conseils/' . $imageName;
        } else {
            $imageName = null;
        }

        $conseil = new Conseils([
            'titre' => $request->input('titre'),
            'description' => $request->input('description'),
            'image' => $finalName,
            'id_type' => $request->input('id_type'),
        ]);
        $conseil->save();
        return to_route('index')->with('success', 'Conseil saved!');
    }





    public function deleteTypeConseil(int $id)
    {
        $typeConseil = TypeConseil::find($id);
        if (!$typeConseil) {
            return to_route('index')->with('error', 'Type de conseil non trouvé');
        }
        $typeConseil->delete();
        return to_route('index')->with('success', 'Type de conseil supprimé avec succès');
    }



    public function deleteConseil(int $id)
    {
        $conseil = Conseils::find($id);
        if (!$conseil) {
            return to_route('index')->with('error', 'Conseil non trouvé');
        }
        $conseil->delete();
        return to_route('index')->with('success', 'Conseil supprimé avec succès');
    }
}

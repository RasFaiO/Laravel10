<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index',[
            // Podemos mostrar los campos de manera descendente de la siguiente manera, para simplificar el orderBy lo podemos hacer con latest()
            'chirps' => Chirp::with('user')->latest()->get()
            // 'chirps' => Chirp::orderBy('created_at','desc')->get()
            // 'chirps' => Chirp::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);

        // Esto remplaza el create que tenemos abajo, teniendo en cuenta que ya creamos en el usuer un método para la relación usuario -> chirps
        $request->user()->chirps()->create( $validated /*[
            // Una buena práctica es pasar la variable de los datos validados y no pasar un array con los datos
            'message' => $request->get('message'),
            //Internamente se va a setear el user_id al id del usuario que está ejecutando la petición
        ]*/);
        // Insert en DB
        // Chirp::create([
        //     //Podemos remplazar request por $request->get
        //     'message' => $request->get('message'),
        //     'user_id' => auth()->id(), // este auth()->id() retorna el id de usuario
        // ]);
        // Acá estamos definiendo la llave pero no le estamos dando ningún valor, así que como segundo parámetro le pasamos el valor que queremos mostrar, este mismo valor lo podemos pasar directamente en la redirección con el metodo with
        //session()->flash('status', 'Chirp created Succesfully!');
        return to_route('chirps.index')
        ->with('status',__('Chirp created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Acá le estamos indicando a Laravel que la variable que recibimos $chirp, debe ser una instancia del modelo Chirp, a esto se le conoce como Type Hint
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        // if (auth()->user()->isNot($chirp->user)){
        //     abort(403);
        // }
        return view('chirps.edit',[
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        // Lo remplazamos por el metodo authorize
        // if (auth()->user()->isNot($chirp->user)){
        //     abort(403);
        // }
        // Procesamos el formulario que viene del controller que a su vez estamos enviando desde chirps/edit

        // Primero validamos la petición 
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);

        // Luego actualizamos el chirp que recibimos por url
        $chirp->update($validated);

        // Finalmente retornamos a la vista correspondiente
        return to_route('chirps.index')->with('status', __('Chirp updated succesfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return to_route('chirps.index')->with('status', __('Chirp deleted cussesfully!'));
    }
}

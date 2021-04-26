<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        return Client::where('user_id', auth()->id())->get();
    }

    public function store(Request $request) {
        // Validando os dados fornecidos
        $request->validate($this->rules(), $this->messages());

        $client = new Client();

        $client->name = $request->name;
        $client->email = $request->email;
        $client->birthday = $request->birthday;
        $client->user_id = auth()->id();
        $client->save();

        return $client;
    }

    public function show($id){
        $client = Client::find($id);

        if($client) {
            return response()->json($client);
        }

        return response()->json([
            'message'   => 'Cliente não encontrado',
        ], 404);
    }

    public function update(Request $request, $id) {
        // Validando os dados fornecidos
        $request->validate($this->rules(), $this->messages());

        $client = Client::find($id);

        if($client) {
            $client->fill($request->all());
            $client->save();

            return response()->json($client);
        }

        return response()->json([
            'message'   => 'Endereço não encontrado',
        ], 404);
    }

    public function destroy($id) {
        $client = Client::find($id);

        if($client) {
            $client->delete();
        }else{
            return response()->json([
                'message'   => 'Endereço não encontrado',
            ], 404);
        }
    }

    public function rules() {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email:rfc,dns',
            'birthday' => 'required|date',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter no máximo 100 caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'E-mail inválido.',
            'birthday.required' => 'O campo data de nascimento é obrigatório.',
            'birthday.date' => 'Informe uma data válida.',
        ];
    }
}

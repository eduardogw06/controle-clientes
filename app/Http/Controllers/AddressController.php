<?php

namespace App\Http\Controllers;

use App\Address;
use App\Client;
use App\Helper\Viacep;
use Illuminate\Http\Request;

class AddressController extends Controller {
    public function __construct() {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function store(Request $request) {
        $client = Client::where('id', $request->client)->first();

        if($client) {
            // Validando os dados fornecidos
            $request->validate($this->rules(), $this->messages());

            $address = new Address();

            $address->zipcode = $request->zipcode;
            $address->address = $request->address;
            $address->number = $request->number;
            $address->neighborhood = $request->neighborhood;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->client_id = $client->id;
            $address->save();

            return $address;
        }

        return response()->json([
            'message'   => 'Cliente não encontrado',
        ], 404);
    }

    public function show($id){
        $address = Address::where('client_id', '=', $id)->first();

        if($address){
            return response()->json($address);
        }

        return response()->json([
            'message'   => 'Endereço não encontrado',
        ], 200);

    }

    public function update(Request $request, $id) {
        $address = Address::find($id);

        if($address) {
            // Validando os dados fornecidos
            $request->validate($this->rules(), $this->messages());

            $address->fill($request->all());
            $address->save();

            return response()->json($address);
        }

        return response()->json([
            'message'   => 'Endereço não encontrado',
        ], 404);
    }

    public function destroy($id) {
        $address = Address::find($id);

        if($address) {
            $address->delete();
        }

        return response()->json([
            'message'   => 'Endereço não encontrado',
        ], 404);
    }

    public function validateZipcode(Request $request){
        $viaCep = new Viacep($request->zipcode);
        $response = $viaCep->findZipcode();

        if($response['isValid']){
            return response()->json($response);
        }

        return response()->json($response, 200);
    }

    public function rules() {
        return [
            'zipcode' => 'required|digits:8',
            'address' => 'required|max:100',
            'neighborhood' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|digits:2',
        ];
    }

    public function messages() {
        return [
            'zipcode.required' => 'O campo CEP é obrigatório.',
            'zipcode.digits' => 'O campo CEP deve ter exatamente 8 caracteres.',
            'address.required' => 'O campo endereço é obrigatório.',
            'address.max' => 'O campo endereço deve ter no máximo 100 caracteres.',
            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'neighborhood.max' => 'O campo bairro deve ter no máximo 50 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.max' => 'O campo bairro deve ter no máximo 50 caracteres.',
            'state.required' => 'O campo estado é obrigatório.',
            'state.digits' => 'O campo estado deve ter exatamente 2 caracteres.',

        ];
    }
}

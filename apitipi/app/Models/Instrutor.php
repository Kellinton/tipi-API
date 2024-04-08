<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrutor extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'email', 'foto'];

    public function Regras(){
        return [
            'nome'  => 'required|unique:instrutors,nome'.$this->id.'|min:3',
            'email' => 'required|unique:instrutors,email'.$this->id.'|max:30',
            'foto'  => 'required'
        ];
    }

    public function Feedback(){
        return [
            'required'      => 'O campo :attribute é obrigatório.',
            'nome.unique'   => 'O nome do instrutor já existe.',
            'nome.min'      => 'O nome deve conter mais que 3 caracteres',
            'email.unique'  => 'O email informado já existe.',
            'email.max'     => 'O email não pode ultrapassar 30 caracteres.'
        ];
    }
}

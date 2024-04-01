<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'foto'];

    // função de validação

    //regras de validação
    public function Regras()
    {
        return [
            'nome' => 'required|unique:alunos,nome,'.$this->id.'|min:3', // tipos de validação. required (requer), e unique (único) na tabela 'alunos' e na clouna 'nome', min:3 (mínimo de 3 caracteres)
            'foto' => 'required'
            // 'foto' => 'required|file|mimes:png,jpg.docx,pdf' // precisar ser um arquivo (file) e o tipo (mimes)
        ];
    }

    //feedback
    public function Feedback()
    {
        return [
            'required'      => 'O campo :attribute é obrigatório',
            // 'foto.mimes'    => 'O arquivo deve ser uma imagem em PNG ou JPG',
            'nome.unique'   => 'O nome do aluno já existe',
            'nome.min'      => 'O nome deve conter mais que 3 caracteres',
        ];
    }
}

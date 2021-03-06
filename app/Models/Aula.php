<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $fillable = [
    	'id_chave',
    	'id_porteiro',
    	'id_aluno',
    	'id_professor',
    	'data_inicio',
    	'data_fim',
    	'status',
    	'user_id'
    ];

    public function chave(){
        return $this->belongsTo('App\Models\Chave','id_chave');
	}
	public function aluno(){
        return $this->belongsTo('App\Models\Aluno','id_aluno');
	}
	public function professor(){
        return $this->belongsTo('App\Models\Professor','id_professor');
    }
}

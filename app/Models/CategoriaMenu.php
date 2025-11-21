<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaMenu extends Model
{

    
    use HasFactory;

    protected $table = 'categorias_menu';


    protected $fillable =
        [
        'nombre',
        'visible_publico',
        'activo'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts =
        [
        'id' => 'string',
        'nombre' => 'string',
        'visible_publico' => 'string',
        'activo' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];



    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules =
    [
        'nombre' => 'required',
        'visible_publico' => 'required',
        'activo' => 'required',
    ];


    /**
     * Custom messages for validation
     *
     * @var array
     */
    public static $messages =[

    ];


    /**
     * Accessor for relationships
     *
     * @var array
     */
    

}

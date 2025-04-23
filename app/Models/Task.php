<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    // By default, it assumes the table name is the plural form of the model class name. 
    // Since this model class is Task, Laravel expects the corresponding database table to be named tasks.
    // But in case you use a custom table name, you will overrides the default table name as showed below:
    // protected $table = 'tasks';

    // Specify fillable attributes to allow mass-assignment.
    protected $fillable = ['title', 'category', 'description', 'deadline']; // Not mandatory, but highly recommended for security reasons.
}

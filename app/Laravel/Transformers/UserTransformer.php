<?php 

namespace App\Laravel\Transformers;

use App\Laravel\Models\User;

use League\Fractal\TransformerAbstract;

use App\Laravel\Traits\ResponseGenerator;

use Str;

class UserTransformer extends TransformerAbstract{
	use ResponseGenerator;

    public function __construct(){
    
    }

	public function transform(User $user) {
	    return [
	     	'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'created_at' => $user->created_at?->toDateTimeString(),
            'updated_at' => $user->updated_at?->toDateTimeString(),
            'deleted_at' => $user->deleted_at?->toDateTimeString()
	     ];
	}
}
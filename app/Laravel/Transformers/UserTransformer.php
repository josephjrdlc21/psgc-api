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
	     	'id' => $user->id ?:0,
	     ];
	}
}
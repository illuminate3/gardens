<?php

namespace App;
use Illuminate\Http\Request;
trait PeriodTrait {

	public function getShowYear(Request $request= null)
		
		{
			if($request && $request->has('year')) {
				
					$request->session()->put('showyear',$request->get('year'));
					$this->showyear = $request->session()->get('showyear');
					
			}else{
				if(\Session::has('showyear')){
					$this->showyear;
				}else{

						$this->showyear = date('Y');
						\Session::put('showyear',$this->showyear);
					

				}
			}
			
			return $this->showyear;
		}
}
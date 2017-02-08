<p>{{implode("/",$plotemail['name'])}} </p>
<p>According to the McNear Community Garden records as of {{date('l jS \of F Y')}} you have contributed {{$plotemail['sum']}} community 
hours year to date.  The annual commitment for a {{$plotemail['type']}} plot is {{$plotemail['type']=='full' ? '24' : '12'}} hours.</p>

<p> You can check and update your hours at <a href="{{route('hours.index')}}" >this link</a></p>
<p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
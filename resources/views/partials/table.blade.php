<table id="sorttable" class="table table-striped table-bordered table-condensed table-hover dataTable no-footer" role="grid" aria-describedby="sorttable_info">
<thead>
@while(list($key,$field)=each($fields))
    <th>
        {{$key}}
    </th>
@endwhile

</thead>
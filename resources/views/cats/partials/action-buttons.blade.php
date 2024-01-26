<div class="pull-right btn-group" role="group">
    {{ link_to_route('cats.edit', trans('app.edit'), [$cat->id], ['class' => 'btn btn-warning']) }}
    {{ link_to_route('cats.show', trans('app.show_profile').' '.$cat->full_name, [$cat->id], ['class' => Request::segment(3) == null ? 'btn btn-default active' : 'btn btn-default']) }}
    {{ link_to_route('cats.chart', trans('app.show_family_chart'), [$cat->id], ['class' => Request::segment(3) == 'chart' ? 'btn btn-default active' : 'btn btn-default']) }}
    {{ link_to_route('cats.tree', trans('app.show_family_tree'), [$cat->id], ['class' => Request::segment(3) == 'tree' ? 'btn btn-default active' : 'btn btn-default']) }}
    {{ link_to_route('cats.marriages', trans('app.show_couples'), [$cat->id], ['class' => Request::segment(3) == 'marriages' ? 'btn btn-default active' : 'btn btn-default']) }}
    
</div>

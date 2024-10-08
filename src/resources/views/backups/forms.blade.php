@if (Request::get('action') == 'delete' && Request::has('file_name'))
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('backup.delete') }}</h3>
        </div>
        <div class="panel-body">
            <p>{!! trans('backup.sure_to_delete_file', ['filename' => Request::get('file_name')]) !!}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('backups.index') }}" class="btn btn-default">{{ trans('backup.cancel_delete') }}</a>
            <form action="{{ route('backups.destroy', Request::get('file_name')) }}" method="post" class="pull-right">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <input type="hidden" name="file_name" value="{{ Request::get('file_name') }}">
                <input type="submit" class="btn btn-danger" value="{{ trans('backup.confirm_delete') }}">
            </form>
        </div>
    </div>
@endif
@if (Request::get('action') == 'restore' && Request::has('file_name'))
    <div class="panel panel-warning">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('backup.restore') }}</h3></div>
        <div class="panel-body">
            <p>{!! trans('backup.sure_to_restore', ['filename' => Request::get('file_name')]) !!}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('backups.index') }}" class="btn btn-default">{{ trans('backup.cancel_restore') }}</a>
            <form action="{{ route('backups.restore', Request::get('file_name')) }}"
                method="post"
                class="pull-right"
                onsubmit="return confirm('Click OK to Restore.')">
                {{ csrf_field() }}
                <input type="hidden" name="file_name" value="{{ Request::get('file_name') }}">
                <input type="submit" class="btn btn-warning" value="{{ trans('backup.confirm_restore') }}">
            </form>
        </div>
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <form action="{{ route('backups.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="file_name" class="control-label">{{ trans('backup.create') }}</label>
                <input type="text" name="file_name" class="form-control" placeholder="{{ date('Y-m-d_Hi') }}">
                {!! $errors->first('file_name', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.create') }}" class="btn btn-success">
            </div>
        </form>
        <form action="{{ route('backups.upload') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="backup_file" class="control-label">{{ trans('backup.upload') }}</label>
                <input type="file" name="backup_file" class="form-control">
                {!! $errors->first('backup_file', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.upload') }}" class="btn btn-primary">
            </div>
        </form>
        <hr>
        <form action="{{ route('backups.clear_cats') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.clear') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.export_cats') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.export') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.import_cats') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <p>Make sure to consult help before usage.</p>
            <div class="form-group">
                <label for="file" class="control-label">{{ trans('backup.import') }}</label>
                <input type="file" name="file" class="form-control">
                {!! $errors->first('file', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.import') }}" class="btn btn-primary">
            </div>
        </form>
        <hr>
        <form action="{{ route('backups.clear_breeds') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.clear_breeds') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.export_breeds') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.export_breeds') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.import_breeds') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="file" class="control-label">{{ trans('backup.import_breeds') }}</label>
                <input type="file" name="file" class="form-control">
                {!! $errors->first('file', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.import_breeds') }}" class="btn btn-primary">
            </div>
        </form>
        <hr>
        <form action="{{ route('backups.clear_ems') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.clear_ems') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.export_ems') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.export_ems') }}" class="btn btn-primary">
            </div>
        </form>
        <form action="{{ route('backups.import_ems') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="file" class="control-label">{{ trans('backup.import_ems') }}</label>
                <input type="file" name="file" class="form-control">
                {!! $errors->first('file', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ trans('backup.import_ems') }}" class="btn btn-primary">
            </div>
        </form>
        <hr>
    </div>
</div>
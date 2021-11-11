@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName(), $table) !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.crud', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.crud.trash', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        @if ($enable_create)
        <a href="{{ route('admin.crud.create', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
        @endif
    </div>
</div>
<x-dashboard-messages/>
<form class="row mb-3">
    <div class="form-group offset-md-4 col-md-4">
        <label for="search_s">Buscar</label>
        <input id="search_s" type="text" class="form-control" value="{{ request()->has('s')?request()->s:'' }}" name="s">
    </div>
    <div class="form-group col-md-2">
        <label>Mostrar</label>
        <select class="form-select" name="paginate">
            @foreach ([10, 20, 50, 100] as $paginate)
            <option value="{{ $paginate }}" {{ request()->has('paginate') && request()->paginate == $paginate ? 'selected' : '' }}>{{ $paginate }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-2">
        <label for="search_p" style="opacity: 0">s</label> <br>
        <button class="btn btn-outline-secondary w-100 text-nowrap" type="submit">
            <i class="fas fa-search"></i>
            Buscar
        </button>
    </div>
</form>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">
        @foreach ($data as $item)
            @if ($loop->first)
            <table class="table table-striped table-bordered display">
                <thead>
                    <tr>
                        @foreach ($inputs as $inputKey => $input)
                            <?php
                            if ( $input->type == 'card-header' || ( property_exists($input, 'listable') && $input->listable == 0 ) ) {
                                continue;
                            }
                            ?>
                            <?php try { ?>
                                <th>{{ $input->label->{App::getLocale()} }}</th>
                            <?php } catch (\Throwable $th) { ?>
                                @dump('no tiene traduccion')
                                @dd($input);
                            <?php } ?>
                        @endforeach                
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                @endif
                <tr>
                    @foreach ($inputs as $inputKey => $input)
                    <?php try { ?>
                    <?php
                    if ( $input->type == 'card-header' || ( property_exists($input, 'listable') && $input->listable == 0 ) ) {
                        continue;
                    }
                    ?>
                    @if ($input->type == 'select')
                        <td>{{ $item->{$input->columnname . '_rel_val'} }}</td>
                    @elseif($input->type == 'select_string')
                        <td>{{ $item->{$input->columnname . '_rel_val'} }}</td>
                    @elseif($input->type == 'color')
                        <td style="background-color: {{ $item->{$input->columnname} }}"></td>
                    @elseif($input->type == 'multimedia_file')
                        @if ($item->{$input->columnname})
                            <td><div style="background-image: url('{{ $item->{$input->columnname}['url'] }}');width: 50px;height: 50px;background-position: center;background-size: cover;background-repeat: no-repeat;margin: auto;"></div></td>
                        @else
                            <td></td>
                        @endif
                    @elseif($input->type == 'gallery')
                        @if ($item->{$input->columnname})
                            <td><div style="background-image: url('{{ asset(Storage::url(__getFirstGallery($item->{$input->columnname}))) }}');width: 50px;height: 50px;background-position: center;background-size: cover;background-repeat: no-repeat;margin: auto;"></div></td>
                        @else
                            <td></td>
                        @endif
                    @elseif($input->type == 'subForm')
                        <td>{{ $item->{$input->columnname}->count() }}</td>
                    @else
                        <td>{{ $item->{$input->columnname} }}</td>
                    @endif
                    <?php } catch (\Throwable $th) { ?>
                        @dump($th->getMessage())
                        @dd($item);
                    <?php } ?>
                    @endforeach
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.crud.edit', ['tablename' => $tablename, 'id' => $item->pkv]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        <a href="{{ route('admin.crud.copy', ['tablename' => $tablename, 'id' => $item->pkv]) }}" class="btn btn-warning btn-sm btn-confirm-copy">
                            <i class="fas fa-sm text-white-50 fa-copy"></i>
                            Duplicar
                        </a>
                        <a href="{{ route('admin.crud.destroy', ['tablename' => $tablename, 'id' => $item->pkv]) }}" class="btn btn-danger btn-sm btn-confirm-delete">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.crud.restore', ['tablename' => $tablename, 'id' => $item->pkv]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-restore"></i>
                            Restaurar
                        </a>
                        @endif
                    </td>
                </tr>
            @if ($loop->last)
                </tbody>
            </table>
            @endif
        @endforeach
        {{ $data->links() }}
    </div>
</div>
@endsection
